<?php

namespace App\Repositories;

use App\Item;

class ItemRepository
{
    private $model;

    public function __construct(Item $item)
    {
    	$this->model = $item;
    }

    public function save($request)
    {
    	$model = new $this->model;
    	$model->item_description = $request->name;
        $model->item_layer =  1;
        $model->save();    	
    }

    public function get ($item)
    {
        $item = $this->model->find($item);

        $return = ['name'=>$item->item_description];

        return $return;
    }

    public function update ($request,$item)
    {
        $item = $this->model->find($item);
        $item->item_description = $request->name;
        $item->save();
    }

    public function delete($item)
    {
        $this->model->find($item)->delete();
    }
    

}