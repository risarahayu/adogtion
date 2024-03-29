<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function set_role($role){
        session(['role' => $role]);
        return redirect()->route("stray_dogs.index")->with([
            'flash' => [
                'type' => 'success',
                'message' => 'Berhasil login',
            ]
        ]);
    }
}
