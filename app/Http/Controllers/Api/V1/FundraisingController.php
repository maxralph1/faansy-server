<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Fundraising;
use App\Http\Requests\StoreFundraisingRequest;
use App\Http\Requests\UpdateFundraisingRequest;

class FundraisingController extends Controller
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
    public function store(StoreFundraisingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Fundraising $fundraising)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundraisingRequest $request, Fundraising $fundraising)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fundraising $fundraising)
    {
        //
    }
}
