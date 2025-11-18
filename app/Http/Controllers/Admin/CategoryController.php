<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): Response
    {
        $categories = Category::all();

        return view('admin.category.index', [
            'categories' => $categories,
        ]);
    }

    public function store(CategoryStoreRequest $request): Response
    {
        $category = Category::create($request->validated());

        return redirect()->route('admin.category.index');
    }

    public function update(CategoryUpdateRequest $request, Category $category): Response
    {
        $category = Category::find($id);


        $category->update($request->validated());

        return redirect()->route('admin.category.index');
    }

    public function destroy(Request $request, Category $category): Response
    {
        $category = Category::find($id);

        $category->delete();

        return redirect()->route('admin.category.index');
    }
}
