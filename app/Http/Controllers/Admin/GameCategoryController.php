<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameCategory;
use Illuminate\Http\Request;

class GameCategoryController extends Controller
{
    public function index()
    {
        $categories = GameCategory::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:game_categories,name'
        ]);

        GameCategory::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục game đã được thêm!');
    }

    public function edit(GameCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, GameCategory $category)
    {
        $request->validate([
            'name' => 'required|string|unique:game_categories,name,' . $category->id
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(GameCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
