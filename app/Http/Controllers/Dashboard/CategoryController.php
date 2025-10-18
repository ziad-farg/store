<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\StoreCategoryRequest;
use App\Http\Requests\Dashboard\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::with('images', 'parent', 'image')
            // we use withCount without closure function to count all products in the category that status is active or draft or archived
            // ->withCount('products') // Add products count to prevent N+1 queries and get the count of products in each category
            // we use closure function when we want to count specific condition
            // like that we use status active only
            ->withCount(['products' => function ($query) {
                $query->where('status', ProductStatus::ACTIVE);
            }])
            ->search($request->query()) // the request query get all query parameters from the url
            // order by parent_id nulls first, then by parent_id, then by name
            // when parent_id is null, it will be 0, otherwise 1
            // 0 equals first, 1 equals last
            ->orderByRaw('CASE WHEN parent_id IS NULL THEN 0 ELSE 1 END')
            ->orderBy('parent_id')
            ->orderBy('name')
            ->paginate();

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $category = new Category;

        return view('dashboard.categories.create', compact('categories', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['name']);

        $category = Category::create($validated);

        $this->uploadImage($request, $category);

        Alert::toast('Category added successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, Request $request)
    {
        // Load necessary relationships for the show page
        $category->load([
            'image',
            'parent',
            'children.image',
        ]);

        // Load counts for better performance
        $category->loadCount(['products', 'children']);

        // Paginate products for better performance
        $products = $category->products()
            ->with(['image', 'store'])
            ->paginate(10);

        return view('dashboard.categories.show', compact('category', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)
            ->where(function ($query) use ($category) {
                $query->where('parent_id', '!=', $category->id)
                    ->orWhere('parent_id', null);
            })->get();

        return view('dashboard.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['name']);

        $category->update($data);

        $this->uploadImage($request, $category);

        Alert::toast('Category updated successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.categories.index');
    }

    // upload image to storage and save path to database
    protected function uploadImage(Request $request, Category $category)
    {
        if (! $request->hasFile('image')) {
            return;
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image->path);
            $category->image->delete();
        }

        return $category->image()->create([
            'path' => $request->file('image')->store('uploads/categories', 'public'),
        ]);
    }

    /**
     * Force delete the specified category
     */
    public function destroy(Category $category)
    {
        $this->deleteImage($category);

        $category->forceDelete();

        Alert::toast('Category deleted successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * archive the specified category.
     */
    public function delete(Category $category)
    {
        $category->delete();

        Alert::toast('Category archived successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Display a listing of the trashed categories.
     */
    public function trashed(Request $request)
    {
        $categories = Category::onlyTrashed()
            ->with('image', 'parent')
            ->withCount('products')
            ->search($request->query())
            ->paginate();

        return view('dashboard.categories.trashed', compact('categories'));
    }

    /**
     * Restore the specified category from the trash.
     */
    public function restore(int $id)
    {

        $category = Category::onlyTrashed()->findOrFail($id);

        $category->restore();

        Alert::toast('Category restored successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Force delete when the category is trashed.
     */
    public function forceDelete(int $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        $category->forceDelete();

        $this->deleteImage($category);

        Alert::toast('Category deleted successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.categories.index');
    }

    // delete image from storage and database
    protected function deleteImage(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image->path);
            $category->image->delete();
        }
    }
}
