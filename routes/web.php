<?php

use Ibrhaim13\Translate\Http\Controllers\TranslateController;
use Illuminate\Routing\Route;

Route::resource('/posts', [TranslateController::class, 'index']);
