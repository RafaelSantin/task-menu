<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ItemRepository;

class ItemController extends Controller
{
    private $repo;

    public function __construct(ItemRepository $itemRep)
    {
        $this->repo = $itemRep;
    }
    /**
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
     * @param  mixed  $item
     * @return \Illuminate\Http\Response
     */
    public function show($item)
    {
        $return = $this->repo->get($item);
        return $return;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $item)
    {
        $this->repo->update($request, $item);
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($item)
    {
        $this->repo->delete($item);
    }
}
