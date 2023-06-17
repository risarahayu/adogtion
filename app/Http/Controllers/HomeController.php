<?php

namespace App\Http\Controllers;

use App\Models\StrayDog;
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
    public function index()
    {
        $user = auth()->user();
        $stray_dogs = StrayDog::all();
        $adoptions = $user->adoptions();
        return view('dashboard.index', compact('user', 'stray_dogs', 'adoptions'));
    }
}
