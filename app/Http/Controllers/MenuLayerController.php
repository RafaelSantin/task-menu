<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MenuItemRepository;

class MenuLayerController extends Controller
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
    public function show($menu,$layer)
    {
        $this->repo->getLayer($menu,$layer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu)
    {
        //
    }
}
