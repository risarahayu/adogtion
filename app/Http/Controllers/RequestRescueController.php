<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\RequestRescue;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class RequestRescueController extends Controller
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
        $user = auth()->user();
        // $stray_dogs = StrayDog::all();
        $areas = Area::all();
        return view('request_rescue.create', compact('user', 'areas'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
            // dd($request);
        // $strayDog = null;
        DB::transaction(function () use ($request) {
            // Create area
            $area_name = $request->input('area');
            $area = Area::where('name', $area_name)->first();
            // dd($area);
            if (optional($area)->exists()) {
                $area = $area;
            } else {
                $area = new Area();
                $area->name = $request->input('area');
                $area->save();
            }

            // Create request
            $stray_dog_request = array_merge($request->except(['_token', 'area']), ['area_id' => $area->id]);
            // dd($stray_dog_request);
            $strayDog = RequestRescue::create($stray_dog_request);
            
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
        
        // return redirect()->route("stray_dogs.show", ['stray_dog' => $strayDog->id])->with([
        //     'flash' => [
        //         'type' => 'success',
        //         'message' => 'Stray dog has been add successfully',
        //     ]
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get straydog id from model
        $strayDog = RequestRescue::findOrFail($id);

        //get image
        $images = $strayDog->images;
        

        //check user login 
        $user = auth()->user();

        // get area
        $areas = Area::all();

        return view('request_rescue.edit', compact('strayDog', 'user', 'areas', 'images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    // dd($request);

        // Validasi input jika diperlukan
    // $request->validate([
       
    // ]);

    // Temukan data yang akan diperbarui
    $strayDog = RequestRescue::findOrFail($id);

    // Update data dengan data baru dari permintaan
    $strayDog->update([
        'dog_type' => $request->input('dog_type'),
        'color' => $request->input('color'),
        'temperament' => $request->input('temperament'),
        'gender' => $request->input('gender'),
        'size' => $request->input('size'),
        'description' => $request->input('description'),
        
    ]);

    // Jika Anda juga ingin memperbarui area, lakukan pengecekan dan update jika perlu
    $area_name = $request->input('area');
    $area = Area::where('name', $area_name)->first();
    if (optional($area)->exists()) {
        $areaId = $area->id;
    } else {
        $newArea = new Area();
        $newArea->name = $area_name;
        $newArea->save();
        $areaId = $newArea->id;
    }

    // Update 'area_id' pada model RequestRescue
    $strayDog->update(['area_id' => $areaId]);

    // Redirect atau lakukan sesuatu setelah update
    // return redirect()->route('nama.route.yang.diinginkan')->with([
    //     'flash' => [
    //         'type' => 'success',
    //         'message' => 'Stray dog data has been updated successfully',
    //     ]
    // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
