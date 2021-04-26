<?php

namespace App\Http\Controllers;

use App\Components\MenuRecusive;
use Illuminate\Http\Request;
use App\Menu;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    private $menuRecusive;
    private $menu;
    public function __construct(MenuRecusive $menuRecusive, Menu $menu){
            $this->menuRecusive = $menuRecusive;
            $this->menu = $menu;

    }


    public function index(){
       $menus= $this->menu->paginate(3);

        return view('admin.menus.index', compact('menus'));
    }

    public function create() {
        $offtion = $this->menuRecusive->menuRecusiveAdd();

        return view('admin.menus.add', compact('offtion'));
    }

    public function store(Request $request){
        $this->menu->create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' =>  Str::slug($request->name),

        ]);
            return redirect()->route('menus.index');

    }

    public function edit($id, Request $request){
        $menufromEdit = $this->menu->find($id);
        $htnlOfftion = $this->menuRecusive->menuRecusiveAddEdit($menufromEdit->parent_id);

        return view('admin.menus.edit', compact('htnlOfftion', 'menufromEdit'));
    }
    public function update($id, Request $request){
        $this->menu->find($id)->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => Str::Slug($request->name),
        ]);
        return redirect()->route('menus.index');
    }
    public function delete($id){
        $this->menu->find($id)->delete();
        return redirect()->route('menus.index');
    }
}
