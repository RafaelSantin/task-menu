<?php

namespace App\Repositories;

use App\Menu;

class MenuRepository
{
    private $model;

    public function __construct(Menu $menu)
    {
    	$this->model = $menu;
    }


    public function save($request)
    {
    	$model = new $this->model;
    	$model->menu_name = $request->name;
    	$model->menu_max_depth = $request->max_depth;
    	$model->menu_max_children = $request->max_children;
    	$model->save();

    	return $request;
    }

    public function get($menu)
    {
        $menu = $this->model->select('menu_name','menu_max_children','menu_max_depth')->find($menu);

        return $menu;
    }

    public function update($request, $menu)
    {
        $model = $this->model->find($menu);
        $model->menu_name = $request->name;
        $model->menu_max_depth = $request->max_depth;
        $model->menu_max_children = $request->max_children;
        $model->save();
    }

    public function delete($menu)
    {
        $this->model->find($menu)->delete();
    }
}