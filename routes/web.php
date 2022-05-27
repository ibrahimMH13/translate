<?php

use Ibrhaim13\Translate\Http\Controllers\TranslateController;
use Illuminate\Support\Facades\Route;

Route::get('translate/generate', [TranslateController::class,'generate'])->name('translate.generate');
Route::resource('translate', TranslateController::class);
