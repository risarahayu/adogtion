<?php

namespace App\Http\Controllers;

use App\Models\UserContact;
use App\Models\StrayDog;
use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserContactController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $data = $request->except(['_token', 'stray_dog_id']);
        $stray_dog = StrayDog::find($request->stray_dog_id);
        try {
            DB::transaction(function () use ($user, $data, $stray_dog) {
                !$user->userContact()->exists() ? $user->userContact()->create($data) : $user->userContact()->update($data);

                $adoption = new Adoption();
                $adoption->user_id = $user->id;
                $adoption->stray_dog_id = $stray_dog->id;
                $adoption->save();
            });
            return redirect()->route('stray_dogs.show', ['stray_dog' => $stray_dog])->with('success', 'Success');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('stray_dogs.show', ['stray_dog' => $stray_dog])->with('error', 'Failed');
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserContact  $userContact
     * @return \Illuminate\Http\Response
     */
    public function show(UserContact $userContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserContact  $userContact
     * @return \Illuminate\Http\Response
     */
    public function edit(UserContact $userContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserContact  $userContact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserContact $userContact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserContact  $userContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserContact $userContact)
    {
        //
    }
}
