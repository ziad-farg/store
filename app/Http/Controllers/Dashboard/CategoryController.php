<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Dashboard\Category\StoreCategoryRequest;
use App\Http\Requests\Dashboard\Category\UpdateCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::with('image')
            ->search($request->query())
            ->paginate();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('categories', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['name']);

        $category = Category::create($data);

        if ($request->hasFile('image')) {
            $category->image()->create([
                'path' => $request->file('image')->store('uploads/categories', 'public'),
            ]);
        }

        Alert::toast('Category added successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image->path);
                $category->image->delete();
            }
            $category->image()->create([
                'path' => $request->file('image')->store('uploads/categories', 'public'),
            ]);
        }

        Alert::toast('Category updated successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Force delete the specified category
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image->path);
            $category->image->delete();
        }

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
            ->with('image')
            ->search($request->query())
            ->paginate();

        return view('dashboard.categories.trashed', compact('categories'));
    }


    /**
     * Restore the specified category from the trash.
     */
    public function restore(int $id)
    {

        $category = Category::withTrashed()->findOrFail($id);

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
        $category = Category::withTrashed()->findOrFail($id);

        if ($category->image) {
            Storage::disk('public')->delete($category->image->path);
            $category->image->delete();
        }

        $category->forceDelete();

        Alert::toast('Category deleted successfully', 'success')
            ->position('top-end')
            ->autoClose(3000)
            ->timerProgressBar();

        return redirect()->route('dashboard.categories.index');
    }
}
