<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PeticioneController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('pages.home');





Route::get('/', [PagesController::class, 'home'])->name('home');

Route::get('/users/firmas', [UserController::class, 'peticionesFirmadas'])->middleware('auth');

Route::controller(PeticioneController::class)->group(function () {
    Route::get('peticiones/index', 'index')->name('peticiones.index');
    Route::get('mispeticiones', 'listMine')->name('peticiones.mine');
    Route::get('peticionesfirmadas', 'peticionesFirmadas')->name('peticiones.peticionesfirmadas');

    Route::get('peticiones/{id}', 'show')->name('peticiones.show');
    Route::get('peticion/add', 'create')->name('peticiones.create');
    Route::post('peticion', 'store')->name('peticiones.store');
    Route::delete('peticiones/{id}', 'delete')->name('peticiones.delete');
    Route::put('peticiones/{id}', 'update')->name('peticiones.update');
    Route::post('peticiones/firmar/{id}', 'firmar')->name('peticiones.firmar');
    Route::get('peticiones/edit/{id}', 'edit')->name('peticiones.edit'); // Apuntando a 'edit'
});


Route::controller(UserController::class)->group(function(){
    Route::get('/users','index');
    Route::post('/user','register');
    Route::get('/user/{user}','show');
    Route::get('/user/{user}/peticiones','listPeticiones');
});



