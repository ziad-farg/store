<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Dashboard\Product\StoreProductRequest;
use App\Http\Requests\Dashboard\Product\UpdateProductRequest;




class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('image', 'category', 'store')
            ->search(request()->query())
            ->paginate();
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = new Product();
        $categories = Category::all();
        $stores = Store::all();
        return view('dashboard.products.create', compact('product', 'categories', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['name']);

        $product = Product::create($validated);

        $tagData = $this->tagData($request);

        /**
         * we use sync to attach tags to the product
         * sync will remove any tags that are not in the array
         * we use [Arr::pluck($tagData, 'id')] to get an array of tag IDs
         **/

        $product->tags()->sync($tagData);

        $this->uploadImage($request, $product);

        Alert::toast('Product added successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product created successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['image', 'category', 'store']); // Load related data

        // Fetch related products by category_id or store_id
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('category_id', $product->category_id)
                    ->orWhere('store_id', $product->store_id);
            })
            ->with(['image', 'store'])
            ->paginate(10); // Paginate the results

        return view('dashboard.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $stores = Store::all();
        $product->load(['image', 'category']);
        $tags = implode(',', $product->tags->pluck('name')->toArray()); // get only the names of the tags as array
        return view('dashboard.products.edit', compact('product', 'categories', 'stores', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $product->update($validated);

        $tagData = $this->tagData($request);

        $product->tags()->sync($tagData);

        $this->uploadImage($request, $product);

        Alert::toast('Product updated successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product updated successfully.');
    }


    /**
     * Process tags from the request, creating any that don't already exist,
     * and return an array of tag IDs to be synced with the product.
     */

    public function tagData(Request $request)
    {
        $tags = json_decode($request->tags, true); // Decode JSON string into an array

        $tag_saved = Tag::all();

        $tagData = array_map(function ($tag) use ($tag_saved) {

            $slug = Str::slug($tag['value']);

            // Check if the tag exists in the database
            $existingTag = $tag_saved->where('slug', $slug)->first();

            if ($existingTag) {
                return [
                    'id' => $existingTag->id,
                ];
            }

            // Create the tag if it doesn't exist
            $newTag = Tag::create([
                'name' => $tag['value'],
                'slug' => $slug,
            ]);

            return [
                'id' => $newTag->id,
            ];
        }, $tags ?? []);

        return Arr::pluck($tagData, 'id');
    }

    /**
     * Force delete the specified product
     */
    public function destroy(Product $product)
    {
        $this->deleteImage($product);

        $product->forceDelete();

        Alert::toast('Product deleted successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.products.index');
    }

    /**
     * archive the specified product.
     */
    public function delete(Product $product)
    {
        $product->delete();

        Alert::toast('Product archived successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Display a listing of the trashed products.
     */
    public function trashed(Request $request)
    {
        $products = Product::onlyTrashed()
            ->with('image')
            ->search($request->query())
            ->paginate();

        return view('dashboard.products.trashed', compact('products'));
    }

    /**
     * Restore the specified product from the trash.
     */
    public function restore(int $id)
    {

        $product = Product::onlyTrashed()->findOrFail($id);

        $product->restore();

        Alert::toast('product restored successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Force delete when the product is trashed.
     */
    public function forceDelete(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        $product->forceDelete();

        $this->deleteImage($product);

        Alert::toast('product deleted successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.products.index');
    }


    // upload image to storage and save path to database
    protected function uploadImage(Request $request, Product $product)
    {
        if (!$request->hasFile('image')) {
            return;
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image->path);
            $product->image->delete();
        }

        return $product->image()->create([
            'path' => $request->file('image')->store('uploads/products', 'public'),
        ]);
    }

    // delete image from storage and database
    protected function deleteImage(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image->path);
            $product->image->delete();
        }
    }
}
