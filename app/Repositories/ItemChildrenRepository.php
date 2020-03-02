<?php

namespace App\Repositories;

use App\Item;
use App\Http\Utils\GeneralUtils;
use Illuminate\Support\Facades\Log;


class ItemChildrenRepository
{
    private $item;

    public function __construct( Item $item)
    {
        $this->item = $item;
    }


    public function save($request, $item)
    {   
        $item =  $this->item->find($item);
        $items = $request->all();
        $this->saveItems($items, $item->item_id, ($item->item_layer + 1));
    }

    public function get($item)
    {
        $items =  $this->item->where('item_children_of',$item)->orderBy('item_id','asc')->orderBy('item_children_of','asc')->get()->toArray();

        $parent = null;
        $return = [];
        foreach ($items as $value) {    
                $children = $this->getChildren($value['item_id']);

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

        return $return;
    }

    private function getChildren($parent_id)
    {
        $items =  $this->item->where('item_children_of',$parent_id)->orderBy('item_id','asc')->orderBy('item_children_of','asc')->get()->toArray();

        $return = [];
        foreach ($items as $key => $value) {
            Log::info($value['item_id']);
                $children = $this->getChildren($value['item_id']);

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
         return $return;
    }

    private function saveItems($data,  $parent = null, $layer = 1)
    {       

        foreach ($data as $value) {
            $new = new $this->item;
            $new->item_description = $value['name'];
            $new->item_children_of = $parent;
            $new->item_layer = $layer;
            $new->save();

            if (isset($value['children'])  && !empty($value['children']))
            {
                $this->saveItems($value['children'], $new->item_id, ($layer+1));
            }
        }
    }

    public function delete($item)
    {
        //do not knwo if is to remove all subsequenced children so I will keep them
        $this->item->where('item_children_of',$item)->delete();
    } 
}