<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAll();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        try {
            $this->categoryService->create($request->all());
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $category = $this->categoryService->find($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->categoryService->update($id, $request->all());
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $this->categoryService->delete($id);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
