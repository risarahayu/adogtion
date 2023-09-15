<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\StrayDog;
use App\Models\Adoption;
use App\Models\Rescue;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(StrayDog $stray_dog)
    {
        $user = auth()->user();
        $stray_dogs = $user->strayDogs()->orderByDesc('created_at')->withCount('adoptions')->get();
        // $stray_dogs = StrayDog::all();
        $adoptions = $user->adoptions();
        return view('dashboard.index', compact('user', 'stray_dogs', 'adoptions'));
    }

    public function search(Request $request)
    {
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
        $user = auth()->user();
        $adoptions = $user->adoptions();
        return view('dashboard.index', compact('user', 'stray_dogs', 'adoptions'));
    }

    public function sort($status)
    {
        if (!in_array($status, ['unrescued', 'rescued', 'adopted'])) {
            // If the area is not found, you can handle the error or redirect as needed
            return redirect()->back()->with([
                'flash' => [
                    'type' => 'danger',
                    'message' => 'Something error',
                ]
            ]);
        }

        $user = auth()->user();
        $adoptions = $user->adoptions();

        if($status == "unrescued") {
            //if there is no a record in rescues table
            $stray_dogs = $user->strayDogs()->whereDoesntHave('rescue')->get();
        } else if ($status == "adopted") {
            //if there is a record in adopted column
            $stray_dogs = $user->strayDogs()->where("adopted", true)->get();
        } else if ($status == "rescued") {
            $stray_dogs = $user->strayDogs()->whereHas('rescue', function ($q) use ($status) {
                $q->where('status', $status)->where("adopted", false);
            })->get();
        }

        // // Find the stray dogs based on the given status
        // $stray_dogs = StrayDog::whereHas('rescue', function ($q) use ($status) {
        //     $q->where('status', $status)->orderByDesc('created_at');
        // })->withCount('adoptions')->get();
                        
        // Pass the filtered straydogs and the area to the view
        return view('dashboard.index', compact('stray_dogs', 'adoptions','user'));
    }

}
