<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Fanlist;
use App\Http\Requests\StoreFanlistRequest;
use App\Http\Requests\UpdateFanlistRequest;

class FanlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFanlistRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Fanlist $fanlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFanlistRequest $request, Fanlist $fanlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fanlist $fanlist)
    {
        //
    }
}
