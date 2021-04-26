<?php
namespace App\Components;
use App\Menu;

class MenuRecusive {

    public function __construct()
    {
        $this->html = '';
        //dung de noi cac chuoi offtion voi nhau;
    }

    public function menuRecusiveAdd ($parentId = 0){
        $data = Menu::where('parent_id', $parentId)->get();
        foreach ($data as $dataItem){
            $this->html.= '<option value="'. $dataItem->id .'">'.  $dataItem->name. '</option>';
            $this->menuRecusiveAdd($dataItem->id );
        }
        return $this->html;
    }
    public function menuRecusiveAddEdit ($parentIdMenuEdit, $parentId = 0){
        $data = Menu::where('parent_id', $parentId)->get();
        foreach ($data as $dataItem){
            if($parentIdMenuEdit == $dataItem->id ){
                $this->html.= '<option  selected value="'. $dataItem->id .'">'.  $dataItem->name. '</option>';
            }else{
                $this->html.= '<option value="'. $dataItem->id .'">'.  $dataItem->name. '</option>';
            }
            $this->html.= '<option value="'. $dataItem->id .'">'.  $dataItem->name. '</option>';
            $this->menuRecusiveAdd($parentIdMenuEdit,$dataItem->id );
        }
        return $this->html;
    }
}
