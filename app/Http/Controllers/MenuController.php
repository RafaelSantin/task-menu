<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MenuRepository;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    private $repo;

    public function __construct(MenuRepository $menuRep)
    {
        Log::info('Showing user profile for user: ');
        $this->repo = $menuRep;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->repo->save($request);
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        $response = $this->repo->get($menu);
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $menu)
    {
         Log::info($request);
         $this->repo->update($request,$menu);
         return $request;
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
