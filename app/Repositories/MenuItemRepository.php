<?php

namespace App\Repositories;

use App\Menu;
use App\Item;
use App\Http\Utils\GeneralUtils;
use Illuminate\Support\Facades\Log;


class MenuItemRepository
{
    private $menu;
    private $item;

    public function __construct(Menu $menu, Item $item)
    {
    	$this->menu = $menu;
        $this->item = $item;
    }


    public function save($request, $menu)
    {   
        $menu =  $this->menu->find($menu);
        $items = $request->all();
        
        // $depth = GeneralUtils::verifyDepth($request, $menu->menu_max_depth);
        $this->saveItems($items, $menu->menu_id);
    }

    public function get($menu)
    {
        $menuItems =  $this->item->where('menu_id',$menu)->orderBy('item_id','asc')->orderBy('item_children_of','asc')->get()->toArray();

        $parent = null;

        foreach ($menuItems as $value) {
            if (is_null($value['item_children_of']))
            {    
                $children = $this->getChildren($menuItems, $value['item_id']);

                Log::info('children 1');
                Log::info($children);

                if(!empty($children)){
                    $return[] = [
                            'name' => $value['item_description'],
                            'children' => $children
                        ];
                }else{
                    $return[] = [
                            'name' => $value['item_description']
                        ];
                } 
            }
                   

        }

        return $return;
    }

    private function getChildren(&$items, $parent_id)
    {
        $return = [];
        foreach ($items as $key => &$value) {
            if($value['item_children_of'] == $parent_id)
            {
                $children = $this->getChildren($items, $value['item_id']);

                if(!empty($children)){
                    $return[] = [
                            'name' => $value['item_description'],
                            'children' => $children
                        ];
                }else{
                    $return[] = [
                            'name' => $value['item_description']
                        ];
                }
                 Log::info('unset 1');
            Log::info($key);
                unset($value);

            // Log::info('array ');
            // Log::info($items);

            }    
        }
         return $return;
    }

    private function saveItems($data, $menu, $parent = null, $layer = 1)
    {       

        foreach ($data as $value) {
            $layer = ($parent == null) ? 1 : $layer;
            Log::info($value['name']);
            $new = new $this->item;
            $new->item_description = $value['name'];
            $new->item_children_of = $parent;
            $new->item_layer = $layer;
            $new->menu_id = $menu;
            $new->save();

            if (isset($value['children'])  && !empty($value['children']))
            {
                $this->saveItems($value['children'], $menu, $new->item_id, ($layer+1));
            }
        }
    }

    public function delete($menu)
    {
        $menu =  $this->menu->find($menu);
        $menu->delete();        
    } 
}