<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Livestreamguest;
use App\Http\Requests\StoreLivestreamguestRequest;
use App\Http\Requests\UpdateLivestreamguestRequest;

class LivestreamguestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLivestreamguestRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Livestreamguest $livestreamguest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livestreamguest $livestreamguest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLivestreamguestRequest $request, Livestreamguest $livestreamguest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livestreamguest $livestreamguest)
    {
        //
    }
}
