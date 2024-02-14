<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Livestreamcomment;
use App\Http\Requests\StoreLivestreamcommentRequest;
use App\Http\Requests\UpdateLivestreamcommentRequest;

class LivestreamcommentController extends Controller
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
    public function store(StoreLivestreamcommentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Livestreamcomment $livestreamcomment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livestreamcomment $livestreamcomment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLivestreamcommentRequest $request, Livestreamcomment $livestreamcomment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livestreamcomment $livestreamcomment)
    {
        //
    }
}
