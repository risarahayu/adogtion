<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\StrayDog;
use App\Models\Image;
use App\Models\Vet;
use App\Http\Requests\StoreStrayDogRequest;
use App\Http\Requests\UpdateStrayDogRequest;

// Areas
use App\Models\Area;
use App\Http\Requests\StoreAreaRequest;

class StrayDogController extends Controller
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
        $stray_dogs = StrayDog::orderByDesc('created_at')->get();

        return view('stray_dogs.index', compact('stray_dogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $stray_dogs = StrayDog::all();
        $areas = Area::all();
        return view('stray_dogs.create', compact('user', 'stray_dogs', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStrayDogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStrayDogRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Create area
                $area_name = $request->input('area');
                $area = Area::where('name', $area_name)->first();
                if (optional($area)->exists()) {
                    $area = $area;
                } else {
                    $area = new Area();
                    $area->name = $request->input('area');
                    $area->save();
                }

                // Create straydogs
                $stray_dog_request = array_merge($request->except(['_token', 'area']), ['area_id' => $area->id]);
                $strayDog = StrayDog::create($stray_dog_request);
                
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $filename = $image->getClientOriginalName();
                        $path = $image->storeAs('public/stray_dog_images', $filename);
                        $publicPath = Storage::url($path);
                
                        $imageModel = new Image();
                        $imageModel->filename = $publicPath;
                        $strayDog->images()->save($imageModel);
                    }
                }
            });

            return redirect()->route('stray_dogs.index')->with([
                'flash' => [
                    'type' => 'success',
                    'message' => 'Stray dog has been add successfully',
                ]
            ]);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('stray_dogs.create')->with([
                'flash' => [
                    'type' => 'danger',
                    'message' => 'Something error',
                ]
            ]);
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StrayDog  $strayDog
     * @return \Illuminate\Http\Response
     */
    public function show(StrayDog $strayDog)
    {
        $user = auth()->user();
        $stray_dog = $strayDog;
        $vets = [];
        $rescueVet = null;

        if ($stray_dog->rescue()->exists() && $stray_dog->rescue->status == 'rescued') {
            $rescueVet = $stray_dog->rescue->vet;
        }

        if ($rescueVet) {
            $vets[] = $rescueVet;
        } else {
            $vets = Vet::whereHas('area', function ($query) use ($stray_dog) {
                $query->where('id', $stray_dog->area_id);
            })->get();

            if ($vets->isEmpty()) {
                $vets = Vet::all();
            }
        }
        return view('stray_dogs.show', compact('user', 'stray_dog', 'vets'));
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
