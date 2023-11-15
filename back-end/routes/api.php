<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/start', [GameController::class, 'startGame']);
Route::post('/updateCell/{index}', [GameController::class, 'processUpdateCell']);