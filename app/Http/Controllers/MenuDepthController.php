<?php

namespace App\Http\Controllers;

use App\Repositories\MenuItemRepository;

class MenuDepthController extends Controller
{
    private $repo;

    public function __construct(MenuItemRepository $menuItemRep)
    {
        $this->repo = $menuItemRep;
    }
    /**
     * Display the specified resource.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        return $this->repo->getDepth($menu);
    }
}
