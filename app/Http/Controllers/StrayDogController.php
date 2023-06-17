<?php

namespace App\Http\Controllers;

use App\Models\StrayDog;
use App\Http\Requests\StoreStrayDogRequest;
use App\Http\Requests\UpdateStrayDogRequest;

// Areas
use App\Models\Area;
use App\Http\Requests\StoreAreaRequest;

class StrayDogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stray_dogs = StrayDog::all();

        return view('stray_dogs.index', compact('stray_dogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stray_dogs = StrayDog::all();
        $areas = Area::all();
        return view('stray_dogs.create', compact('stray_dogs', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStrayDogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStrayDogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StrayDog  $strayDog
     * @return \Illuminate\Http\Response
     */
    public function show(StrayDog $strayDog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StrayDog  $strayDog
     * @return \Illuminate\Http\Response
     */
    public function edit(StrayDog $strayDog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStrayDogRequest  $request
     * @param  \App\Models\StrayDog  $strayDog
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStrayDogRequest $request, StrayDog $strayDog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StrayDog  $strayDog
     * @return \Illuminate\Http\Response
     */
    public function destroy(StrayDog $strayDog)
    {
        //
    }
}
