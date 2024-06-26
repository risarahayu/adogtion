<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Landing page
Route::get('/', function () { return redirect()->route('login'); });


Route::namespace('App\Http\Controllers')->group(function () {



    //Rescue Request
    Route::resource('request_rescue', RequestRescueController::class);
    

    //Choose Role
    Route::get('/role/{role}', 'RoleController@set_role')->name('role.set');
    Route::get('/role', 'HomeController@choose_role');


    Route::get('/switch-role/{role}', SwitchRoleController::class)->name('switch.role');
    // Dashboard
    Route::get('/home', 'HomeController@index')->name('home');

    // Vets
    Route::resource('vets', 'VetController');
    Route::put('vets/{vet}/activate', 'VetController@actived')->name('vets.activate');

    // Stray Dogs
    Route::resource('stray_dogs', 'StrayDogController');
    Route::get('stray_dogs/{stray_dog}/squad', 'StrayDogController@squad')->name('stray_dogs.squad');

    // Rescues
    Route::resource('rescues', 'RescueController');

    // UserContacts
    Route::resource('user_contacts', 'UserContactController');

    // Adoptions
    Route::resource('adoptions', 'AdoptionController');

    // search
    Route::get('/search','HomeController@search');
    Route::get('/search/stray_dog','StrayDogController@search');

    //filter
    Route::get('stray_dog/sort/{area_name}', 'StraydogController@sort')->name('straydogs.sort');
    Route::get('/sort/{status}', 'HomeController@sort')->name('home.sort');

});


// User auth
Auth::routes();