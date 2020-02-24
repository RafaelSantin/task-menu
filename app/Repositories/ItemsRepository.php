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

    public static function save($request)
    {
    	$model = new $this->model;
    	$model->menu_name = $request->name ;
    	
    }
}