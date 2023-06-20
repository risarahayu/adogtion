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
        // Validasi data yang diterima dari request
        $validatedData = $request->validated();

        $userId = auth()->user()->id;

        $rescue = new Rescue();
        $rescue->stray_dog_id = $validatedData['stray_dog_id'];
        $rescue->vet_id = $validatedData['vet_id'];
        $rescue->user_id = $userId;
        $rescue->status = 'rescuing';
        $rescue->save();

        // Jika berhasil disimpan, kembalikan respon JSON yang sesuai
        return response()->json(['rescue_id' => $rescue->id, 'message' => 'Rescue data saved successfully'], 200);
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
        $rescue->status = 'rescued';
        $rescue->save();

        // Jika berhasil diupdate, kembalikan respon JSON yang sesuai
        return response()->json(['message' => 'Rescue data updated successfully', 'rescue_id' => $rescue->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rescue  $rescue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rescue $rescue)
    {
        if ($rescue) {
            // Lakukan proses penghapusan Rescue
            $rescue->delete();
            
            // Respon berhasil
            return response()->json(['message' => 'Rescue deleted successfully'], 200);
        }
        
        // Respon jika Rescue tidak ditemukan
        return response()->json(['message' => 'Rescue not found'], 404);
    }
}
