<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::latest()->paginate(10);

        return view('dashboard.categories.index', compact('categories'));
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        try {

            Category::create($request->validated());

            return redirect()
                ->route('category.index')
                ->with('success', 'Category added successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Category could not be added.');
        }
    }

    public function update(
        CategoryRequest $request,
        Category $category
    ): RedirectResponse {
        try {

            $category->update($request->validated());

            return redirect()
                ->route('category.index')
                ->with('success', 'Category updated successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Category could not be updated.');
        }
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {

            return redirect()
                ->route('category.index')
                ->with(
                    'error',
                    'This category cannot be deleted because it is used by one or more products.'
                );
        }

        $category->delete();

        return redirect()
            ->route('category.index')
            ->with(
                'success',
                'Category deleted successfully.'
            );
    }
}