<?php

use App\Http\Controllers\PeticioneController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('pages.home');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::get('/users/firmas', [UserController::class, 'peticionesFirmadas'])->name('users.firmas')->middleware('auth');

Route::controller(PeticioneController::class)->group(function () {
    // Públicas
    Route::get('peticiones/index', 'index')->name('peticiones.index');
    Route::get('peticiones/{id}', 'show')->name('peticiones.show');

    // Requieren sesión iniciada
    Route::middleware('auth')->group(function () {
        Route::get('mispeticiones', 'listMine')->name('peticiones.mine');
        Route::get('peticion/add', 'create')->name('peticiones.create');
        Route::post('peticion', 'store')->name('peticiones.store');
        Route::delete('peticiones/{id}', 'delete')->name('peticiones.delete');
        Route::put('peticiones/{id}', 'update')->name('peticiones.update');
        Route::post('peticiones/firmar/{id}', 'firmar')->name('peticiones.firmar');
        Route::get('peticiones/edit/{id}', 'edit')->name('peticiones.edit');
    });
});


Route::controller(UserController::class)->group(function(){
    Route::get('/users','index');
    Route::post('/user','register');
    Route::get('/user/{user}','show');
    Route::get('/user/{user}/peticiones','listPeticiones');
});



require __DIR__.'/auth.php';
