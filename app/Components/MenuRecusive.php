<?php

namespace App\Components;

use App\Menu;

class MenuRecusive
{
    private $html;
    public function __construct()
    {
        $this->html = '';
    }


    function menuRecusiveAdd($parentId = 0, $subMark = '')
    {
        $data = Menu::where('parent_id', $parentId)->get();
        foreach ($data as $dataItem) {
            $this->html .= '<option value="' . $dataItem->id . '">' . $subMark . $dataItem->name . '</option>';
            $this->menuRecusiveAdd($dataItem->id, $subMark . '--');
        }
        return $this->html;
    }

    function menuRecusiveEdit($parentIdMenuEdit, $parentId = 0, $subMark = '')
    {
        $data = Menu::where('parent_id', $parentId)->get();
        foreach ($data as $dataItem) {
            $this->html .= $parentIdMenuEdit == $dataItem->id ?
                '<option selected value="' . $dataItem->id . '">' . $subMark . $dataItem->name . '</option>' :
                '<option value="' . $dataItem->id . '">' . $subMark . $dataItem->name . '</option>';;
            $this->menuRecusiveEdit($parentIdMenuEdit, $dataItem->id, $subMark . '--');
        }
        return $this->html;
    }
}
