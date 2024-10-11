<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Patient\PatientController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::post('/', [HomeController::class, 'readingCSV'])->name('home.readingCSV');
Route::get('/', [HomeController::class, 'index'])->name('home.index');


Route::get('/patient', [PatientController::class, 'index'])->name('patient.index');
Route::post('/patient', [HomeController::class, 'store'])->name('home.store');