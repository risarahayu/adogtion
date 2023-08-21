<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\StrayDog;
use App\Models\Image;
use App\Models\Vet;
use App\Http\Requests\StoreStrayDogRequest;
use App\Http\Requests\UpdateStrayDogRequest;

// Areas
use App\Models\Area;
use App\Models\Adoption;
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
    public function index(StrayDog $stray_dog)
    {
        // filter
        $area=Area::all();
        $stray_dogs = StrayDog::orderByDesc('created_at')->withCount('adoptions')->get();
       
        return view('stray_dogs.index', compact('stray_dogs','area'));
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
        $strayDog = null;
       
        DB::transaction(function () use ($request, &$strayDog) {
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
        
        return redirect()->route("stray_dogs.show", ['stray_dog' => $strayDog->id])->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Stray dog has been add successfully',
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StrayDog  $strayDog
     * @return \Illuminate\Http\Response
     */
    public function show(StrayDog $strayDog)
    {
        $own = $strayDog->user;
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
        return view('stray_dogs.show', compact('user', 'stray_dog', 'vets', 'own'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StrayDog  $strayDog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get straydog id from model
        $strayDog = StrayDog::findOrFail($id);

        //check user login 
        $user = auth()->user();

        // get area
        $areas = Area::all();

        return view('stray_dogs.edit', compact('strayDog', 'user', 'areas'));
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
        DB::transaction(function () use ($request, &$strayDog) {
            // Update area (if necessary)
            $area_name = $request->input('area');
            $area = Area::where('name', $area_name)->first();
            if (optional($area)->exists()) {
                // If the area already exists, update the area_id of the StrayDog instance
                $strayDog->area_id = $area->id;
            } else {
                // If the area doesn't exist, create a new area and update the area_id of the StrayDog instance
                $newArea = new Area();
                $newArea->name = $area_name;
                $newArea->save();
                $strayDog->area_id = $newArea->id;
            }

            // Update other attributes of the StrayDog model
            $strayDog->dog_type = $request->input('dog_type');
            $strayDog->color = $request->input('color');
            $strayDog->temperament = $request->input('temperament');
            $strayDog->gender = $request->input('gender');
            $strayDog->size = $request->input('size');
            $strayDog->description = $request->input('description');
            $strayDog->save();

            // Handle images update (if necessary)
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

        return redirect()->route("stray_dogs.show", ['stray_dog' => $strayDog->id])->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Stray dog has been updated successfully',
            ]
        ]);

            }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StrayDog  $strayDog
     * @return \Illuminate\Http\Response
     */
    public function destroy(StrayDog $strayDog)
    {
        $strayDog->delete();
        return redirect()->route('stray_dogs.index')->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Stray dog has been remove',
            ]
        ]);
    }

    public function search(Request $request)
    {

        // dd($request);

        // get from form
        $search = $request->search;

        //query
        $stray_dogs = StrayDog::orderByDesc('created_at')
            ->withCount('adoptions')
            ->where('gender','like',"%".$search."%")
            ->orWhere('dog_type','like',"%".$search."%")
            ->orWhere('color','like',"%".$search."%")
            ->orWhere('temperament','like',"%".$search."%")
            ->orWhere('size','like',"%".$search."%")
            ->orWhere('description','like',"%".$search."%")
            ->get();
            $area=Area::all();
        return view('stray_dogs.index', compact( 'stray_dogs','area'));
        
    }

    public function sort($area_name)
    {

        $area_name=$area_name;
        // dd($area_name);
        // Find the area based on the given area_name
        $area=Area::all();
        $area_check = Area::where('name', $area_name)->first();
        // dd($area);

        if (!$area_check) {
            // If the area is not found, you can handle the error or redirect as needed
            return redirect()->back()->with('error', 'Area not found.');
        }

        // Retrieve the filtered straydogs based on the area name
        $stray_dogs = Straydog::whereHas('area', function ($q) use ($area_name) {
            $q->where('name', $area_name)->orderByDesc('created_at');
        })->withCount('adoptions')->get();
        //  dd($area_name);
       

        // Pass the filtered straydogs and the area to the view
        return view('stray_dogs.index', compact('stray_dogs', 'area','area_name'));
    }
}
