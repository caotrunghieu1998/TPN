<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Components\Recusive;

class CategoryController extends Controller
{
    private $category;

    public function __construct()
    {
        $this->category = new Category;
    }

    // View index Category
    public function index()
    {
        if(!auth()->check()){
            return redirect()->route('admin.login');
        }
        $categories = $this->category->latest()->paginate(5);
        return view('admin.categories.index', compact('categories'));
    }

    // View Create Category
    public function create()
    {
        if(!auth()->check()){
            return redirect()->route('admin.login');
        }
        $htmlOption = $this->getCategory('');
        return view('admin.categories.add', compact('htmlOption'));
    }

    // Create category function
    public function store(Request $request)
    {
        $this->category->create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => str_slug($request->name)

        ]);
        return redirect()->route('categories.index');
    }

    // Get all category (Distinguish parent and child)
    public function getCategory($parentId)
    {
        $data = $this->category->all();
        $recusive = new Recusive($data);
        return $recusive->categoryRecusive($parentId);
    }

    // View Edit Category
    public function edit($id)
    {
        if(!auth()->check()){
            return redirect()->route('admin.login');
        }
        $category = $this->category->find($id);
        if (empty($category)) {
            return redirect()->route('categories.index');
        }
        $htmlOption = $this->getCategory($category->parent_id);
        return view('admin.categories.edit', [
            'category' => $category,
            'htmlOption' => $htmlOption
        ]);
    }

    // Update Category function
    public function update($id, Request $request)
    {
        $category = $this->category->find($id);
        if (!empty($category)) {
            $category->update([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'slug' => str_slug($request->name)
            ]);
        }
        return redirect()->route('categories.index');
    }

    // Delete Category function
    public function delete($id)
    {
        $category = $this->category->find($id);
        if (!empty($category)) {
            $category->delete();
        }
        return redirect()->route('categories.index');
    }
}
