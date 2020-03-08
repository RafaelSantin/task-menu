<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ItemChildrenRepository;

class ItemChildrenController extends Controller
{
    private $repo;

    public function __construct(ItemChildrenRepository $itemRep)
    {
        $this->repo = $itemRep;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $item)
    {
        $this->repo->save($request,$item);
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
        $return =  $this->repo->get($item);
        return $return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($item)
    {
        //
    }
}
