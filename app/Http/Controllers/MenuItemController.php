<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MenuItemRepository;
use Illuminate\Support\Facades\Log;

class MenuItemController extends Controller
{
    private $repo;

    public function __construct(MenuItemRepository $menuItemRep)
    {
        $this->repo = $menuItemRep;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $menu)
    {
        $return = $this->repo->save($request, $menu);
        return $return;
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        $return = $this->repo->get($menu);

        return json_encode($return);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu)
    {
        $this->repo->delete($menu);
    }
}
