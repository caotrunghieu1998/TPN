<?php

namespace App\Http\Controllers;

use App\Components\MenuRecusive;
use App\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private $menu;
    private $menuRecusive;
    public function __construct()
    {
        $this->menuRecusive = new MenuRecusive();
        $this->menu = new Menu();
    }
    // Get View index menu
    public function index()
    {
        if(!auth()->check()){
            return redirect()->route('admin.login');
        }
        $menus = $this->menu->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }
    // Get view create
    public function create()
    {
        if(!auth()->check()){
            return redirect()->route('admin.login');
        }
        $htmlOption = $this->menuRecusive->menuRecusiveAdd();
        return view('admin.menus.add', compact('htmlOption'));
    }
    // Create function
    public function store(Request $request)
    {
        $this->menu->create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => str_slug($request->name)
        ]);
        return redirect()->route('menus.index');
    }
    //Get view Edit
    public function edit($id, Request $request)
    {
        if(!auth()->check()){
            return redirect()->route('admin.login');
        }
        $menuFollowEdit = $this->menu->find($id);
        $htmlOption = $this->menuRecusive->menuRecusiveEdit($menuFollowEdit->parent_id);
        return view('admin.menus.edit', compact('htmlOption', 'menuFollowEdit'));
    }
    //Update function
    public function update($id, Request $request)
    {
        $this->menu->find($id)->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => str_slug($request->name)
        ]);
        return redirect()->route('menus.index');
    }
    //Delete function
    public function delete($id)
    {
        $this->menu->find($id)->delete();
        return redirect()->route('menus.index');
    }
}
