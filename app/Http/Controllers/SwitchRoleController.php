<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SwitchRoleController extends Controller
{
    public function __invoke(Role $role)
    {
        abort_unless(auth()->user()->hasRole($role), 404);
 
        auth()->user()->update(['current_role_id' => $role->id]);
 
        return redirect('/home');
    }
}
