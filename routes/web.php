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
    // Dashboard
    Route::get('/home', 'HomeController@index')->name('home');

    // Vets
    Route::resource('vets', 'VetController');

    // Stray Dogs
    Route::resource('stray_dogs', 'StrayDogController');

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