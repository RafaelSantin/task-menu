<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MenuItemRepository;

class MenuItemController extends Controller
{
    private $repo;

    public function __construct(MenuItemRepository $menuItemRep)
    {
        Log::info('Showing user profile for user: ');
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
        $depth = $this->repo->save($request, $menu);
        return $depth;
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        //
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
