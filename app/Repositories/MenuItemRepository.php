<?php

namespace App\Repositories;

use App\Menu;
use App\Item;
use App\Utils\GeneralUtils;

class MenuItemRepository
{
    private $menu;
    private $item;

    public function __construct(Menu $menu, Item $item)
    {
    	$this->menu = $menu;
        $this->item = $menu;
    }


    public function save($request, $menu)
    {   
        $menu =  $this->menu->find($menu);

        
        $depth = GeneralUtils::verifyDepth($request));
        return $depth;
 
    }

    private function verifyDepth(array $array, $max_depth){        

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = array_depth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }



}