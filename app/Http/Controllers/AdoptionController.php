<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Http\Requests\StoreAdoptionRequest;
use App\Http\Requests\UpdateAdoptionRequest;
use Illuminate\Http\Request;

class AdoptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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
     * @param  \App\Http\Requests\StoreAdoptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdoptionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return \Illuminate\Http\Response
     */
    public function show(Adoption $adoption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return \Illuminate\Http\Response
     */
    public function edit(Adoption $adoption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdoptionRequest  $request
     * @param  \App\Models\Adoption  $adoption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Adoption $adoption)
    {
        $stray_dog = $adoption->stray_dog;
        $adoption->update(['status' => 'accepted']);
        $stray_dog->adoptions()->where('status', 'pending')->update(['status' => 'declined']);
        $stray_dog->update(['adopted' => true]);
        return redirect()->route('stray_dogs.show', ['stray_dog' => $stray_dog])->with('success', 'Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adoption $adoption)
    {
        //
    }
}
