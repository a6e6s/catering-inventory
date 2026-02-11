<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/locale/{locale}', [HomePageController::class, 'locale'])->name('locale');
