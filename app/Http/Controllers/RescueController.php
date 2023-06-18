<?php

namespace App\Http\Controllers;

use App\Models\Rescue;
use App\Http\Requests\StoreRescueRequest;
use App\Http\Requests\UpdateRescueRequest;

class RescueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRescueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRescueRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rescue  $rescue
     * @return \Illuminate\Http\Response
     */
    public function show(Rescue $rescue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rescue  $rescue
     * @return \Illuminate\Http\Response
     */
    public function edit(Rescue $rescue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRescueRequest  $request
     * @param  \App\Models\Rescue  $rescue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRescueRequest $request, Rescue $rescue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rescue  $rescue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rescue $rescue)
    {
        //
    }
}
