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
        $user = auth()->user();
        if ($user->userContact()->exists()) {
            $user_contact = $user->userContact();
        } else {
        }
        $user_contact = new UserContact;
        return view('user_contacts.create', compact('user', 'user_contact'));
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
        !$user->userContact()->exists() ? $user->userContact()->create($data) : $user->userContact()->update($data);

        if (isset($stray_dog)) {
            $adoption = new Adoption();
            $adoption->user_id = $user->id;
            $adoption->stray_dog_id = $stray_dog->id;
            $adoption->save();

            return redirect()->route('stray_dogs.show', $stray_dog->id)->with([
                'flash' => [
                    'type' => 'success',
                    'message' => 'You have requested to adopt this dog.',
                ]
            ]);
        } else {
            return redirect()->route('home')->with([
                'flash' => [
                    'type' => 'success',
                    'message' => 'You have updated your contact information.',
                ]
            ]);
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserContact  $userContact
     * @return \Illuminate\Http\Response
     */
    public function show(UserContact $userContact)
    {
        $contact = UserContact::findOrFail($userContact->user_id);
        // dd($contact);
        $name=$contact->user->name;
        
        return view('user_contacts.show', compact('contact','name'));
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
