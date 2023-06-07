<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

// Vets
use App\Models\Vet;
use App\Http\Requests\StoreVetRequest;
use App\Http\Requests\UpdateVetRequest;

// Areas
use App\Models\Area;
use App\Http\Requests\StoreAreaRequest;

class VetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $vets = Vet::all();

        return view('vets.index', compact('vets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vets = Vet::all();
        $areas = Area::all();
        return view('vets.create', compact('vets', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVetRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Simpan area terlebih dahulu
                $area = new Area();
                $area->name = $request->input('area');
                $area->save();
    
                // Validasi data yang diterima dari request
                $validatedData = $request->validated();
        
                // Buat objek Vet baru dengan data yang valid
                $vet = new Vet();
                // $vet->area_id = $area->id;
                $vet->name = $validatedData['name'];
                $vet->telephone = $validatedData['telephone'];
                $vet->whatsapp = $validatedData['whatsapp'];
                $vet->day_open = $validatedData['day_open'];
                $vet->day_close = $validatedData['day_close'];
                $vet->hour_open = $validatedData['hour_open'];
                $vet->hour_close = $validatedData['hour_close'];
                $vet->fullday = $request->has('fullday'); // Cek apakah checkbox 'fullday' di-check
        
                // Simpan objek Vet ke database
                $vet->save();
            });
    
            // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
            return redirect()->route('vets.index')->with('success', 'Vet has been created successfully.');
        } catch (\Exception $e) {
            // Tangani error
            return redirect()->route('vets.index')->with('error', 'Failed to create Vet. Please try again.');
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vet  $vet
     * @return \Illuminate\Http\Response
     */
    public function show(Vet $vet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vet  $vet
     * @return \Illuminate\Http\Response
     */
    public function edit(Vet $vet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVetRequest  $request
     * @param  \App\Models\Vet  $vet
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVetRequest $request, Vet $vet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vet  $vet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vet $vet)
    {
        //
    }
}
