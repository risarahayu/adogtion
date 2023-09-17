<?php

namespace App\Http\Controllers;

use App\Models\Rescue;
use App\Http\Requests\StoreRescueRequest;
use App\Http\Requests\UpdateRescueRequest;

class RescueController extends Controller
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
     * @param  \App\Http\Requests\StoreRescueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRescueRequest $request)
    {
        $userId = auth()->user()->id;
        $rescue = new Rescue();
        $rescue->stray_dog_id = $request->stray_dog_id;
        $rescue->vet_id = $request->vet_id;
        $rescue->user_id = $userId;
        $rescue->status = 'rescuing';
        $rescue->save();

        return redirect()->route('stray_dogs.squad', $rescue->stray_dog->id)->with([
            'flash' => [
                'type' => 'success',
                'message' => 'You have select vet for this stray dog.',
            ]
        ]);
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
        if ($request->rescue_status == 'to_rescued') {
            $rescue->status = 'rescued';
            $rescue->save();
    
            return redirect()->route('stray_dogs.show', $rescue->stray_dog->id )->with([
                'flash' => [
                    'type' => 'success',
                    'message' => 'You have rescued this dog',
                ]
            ]);
        } else {
            $rescue->status = 'rescuing';
            $rescue->save();
    
            return redirect()->route('stray_dogs.show', $rescue->stray_dog->id )->with([
                'flash' => [
                    'type' => 'danger',
                    'message' => 'You have canceled the rescue.',
                ]
            ]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rescue  $rescue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rescue $rescue)
    {
        $stray_dog_id = $rescue->stray_dog->id;
        // Lakukan proses penghapusan Rescue
        $rescue->delete();
        
        // Respon berhasil
        return redirect()->route('stray_dogs.show', $stray_dog_id )->with([
            'flash' => [
                'type' => 'danger',
                'message' => 'You have cancel selected vet',
            ]
        ]);
    }
}
