<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoriesByGroup = Category::select('id', 'group', 'name', 'icon', 'color', 'type')->orderBy('group')->orderBy('name')->get()->groupBy('group');
        return Inertia::render('categories/Categories', ['categoriesByGroup' => $categoriesByGroup]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('categories/CreateNewCategory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $category = new Category;

        $category->name = $request->name;
        $category->type = $request->type;

        $category->user_id = Auth::id();

        $category->save();

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->fill($request->validated());

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
