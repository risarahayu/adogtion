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

// Areas
use App\Models\Schedule;
use App\Http\Requests\StoreScheduleRequest;

class VetController extends Controller
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
        $vets = Vet::all();
        $areas = Area::all();
        return view('vets.index', compact('vets', 'areas'));
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
                $user = auth()->user();
                // Simpan area terlebih dahulu
                $area_name = $request->input('area');
                $area = Area::where('name', $area_name)->first();
                if (optional($area)->exists()) {
                    $area = $area;
                } else {
                    $area = new Area();
                    $area->name = $request->input('area');
                    $area->save();
                }
    
                // Validasi data yang diterima dari request
                $validatedData = $request->validated();
        
                // Buat objek Vet baru dengan data yang valid
                $vet = new Vet();
                $vet->user_id = $user->id;
                $vet->area_id = $area->id;
                $vet->name = $validatedData['name'];
                $vet->telephone = $validatedData['telephone'];
                $vet->whatsapp = $validatedData['whatsapp'];
                $vet->map_link = $validatedData['map_link'];
                $vet->save();


                // Simpan jadwal (schedules) ke dalam tabel "schedules"
                foreach ($validatedData['schedule'] as $day => $schedule) {
                    // Melewati iterasi berikutnya jika 'open_day' tidak terdefinisi
                    if (!isset($schedule['open_day'])) { continue; }
                    
                    $scheduleModel = new Schedule();
                    $scheduleModel->vet_id = $vet->id;
                    $scheduleModel->day_name = $day;
                    $scheduleModel->open_hour = $schedule['open_hour'];
                    $scheduleModel->close_hour = $schedule['close_hour'];
                    $scheduleModel->fullday = isset($schedule['fullday']) ? true : false;
                    $scheduleModel->save();
                }
            });
    
            // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
            return redirect()->route('vets.index')->with('success', 'Vet has been created successfully.');
        } catch (\Exception $e) {
            // Tangani error
            dd($e);
            return redirect()->route('vets.create')->with('error', 'Failed to create Vet. Please try again.');
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
        $areas = Area::all();
        return view('vets.edit', compact('vet', 'areas'));
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
        try {
            DB::transaction(function () use ($request, $vet) {
                // Simpan area terlebih dahulu
                $area_name = $request->input('area');
                $area = Area::where('name', $area_name)->first();
                if (optional($area)->exists()) {
                    $area = $area;
                } else {
                    $area = new Area();
                    $area->name = $request->input('area');
                    $area->save();
                }
        
                // Validasi data yang diterima dari request
                $validatedData = $request->validated();
        
                // Update data Vet
                $vet->area_id = $area->id;
                $vet->name = $validatedData['name'];
                $vet->telephone = $validatedData['telephone'];
                $vet->whatsapp = $validatedData['whatsapp'];
                $vet->map_link = $validatedData['map_link'];
                $vet->save();
        
                // Hapus semua jadwal (schedules) terkait dengan Vet
                $vet->schedules()->delete();
        
                // Simpan jadwal baru ke dalam tabel "schedules"
                foreach ($validatedData['schedule'] as $day => $schedule) {
                    // Melewati iterasi berikutnya jika 'open_day' tidak terdefinisi
                    if (!isset($schedule['open_day'])) {
                        continue;
                    }
        
                    $scheduleModel = new Schedule();
                    $scheduleModel->vet_id = $vet->id;
                    $scheduleModel->day_name = $day;
                    $scheduleModel->open_hour = $schedule['open_hour'];
                    $scheduleModel->close_hour = $schedule['close_hour'];
                    $scheduleModel->fullday = isset($schedule['fullday']) ? true : false;
                    $scheduleModel->save();
                }
            });
        
            // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
            return redirect()->route('vets.index')->with('success', 'Vet has been updated successfully.');
        } catch (\Exception $e) {
            // Tangani error
            return redirect()->route('vets.edit', $vet->id)->with('error', 'Failed to update Vet. Please try again.');
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vet  $vet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vet $vet)
    {
        try {
            DB::transaction(function () use ($vet) {
                $vet->schedules()->delete();
                $vet->delete(); 
            });
            return redirect()->route('vets.index')->with([
                'flash' => [
                    'type' => 'success',
                    'message' => 'Vet has been remove',
                ]
            ]);
        } catch (\Exception $e) {
            return redirect()->route('vets.index')->with([
                'flash' => [
                    'type' => 'danger',
                    'message' => 'Cannot remove this vet',
                ]
            ]);
        }
    }

    public function actived(Vet $vet)
    {
        $vet->active = !$vet->active;
        $vet->save();

        return redirect()->route('vets.index')->with('success', 'Vet has been updated successfully.');
    }
}
