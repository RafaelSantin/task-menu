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


        
        $depth = GeneralUtils::getDepthArray($items, $menu->menu_max_depth);

        if($depth <= $menu->menu_max_depth)
        {
            $this->saveItems($items, $menu->menu_id);
            return $request;
        }else{
            return 'The depth is higher then max depth for this menu';
        }
    }

    public function get($menu)
    {
        $menuItems =  $this->item->where('menu_id',$menu)->orderBy('item_id','asc')->orderBy('item_children_of','asc')->get()->toArray();

        $parent = null;
        $return = [];
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
        $menu =  $this->item->where('menu_id',$menu)->delete();
    } 

    public function getMenuLayer($menu, $layer)
    {
        $item = $this->item->where('menu_id',$menu)->where('item_layer',$layer)->get();
        
        $return = $item->map(function($item){
            return ['name' =>  $item->item_description];

        });
       

        return $return;
    }

    public function deleteMenuLayer($menu, $layer)
    {
        $item = $this->item->where('menu_id',$menu)->where('item_layer',$layer)->get();
        
        foreach ($item as $value) {
            $this->relinkChildren($value);
            
            $item = $this->item->find($value->item_id);
            $item->delete();
        }
  
    }

    private function relinkChildren($item, $parent = null)
    {
        $itemChildren = $this->item->where('item_children_of',$item->item_id)->get();

        foreach ($itemChildren as $child) {
            $this->relinkChildren($child, $item);          
        }
        //needed for the first call do not update the one that will be deleted
        if($parent != null )
        {
            $item = $this->item->find($item->item_id);
            $item->item_layer = $item->item_layer - 1;
            $item->item_children_of = $parent->item_children_of;
            $item->save();
        }
       

    }

    public function getDepth($menu)
    {
        $depth = $this->item->where('menu_id',$menu)->max('item_layer');

        return ['depth'=> $depth];
    }



}