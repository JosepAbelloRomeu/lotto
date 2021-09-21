<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LottoController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\HistoricController;

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

Route::get('/', function () {
    return view('welcome');
});

/* Route::get('/lotto', [LottoController::class, 'index']);
Route::get('/random', [LottoController::class, 'random']); */
Route::get('/result', [ResultController::class, 'index']);
Route::get('/hits', [HistoricController::class, 'index']);
Route::post('/handle-result', [ResultController::class, 'handleResult'])->name('handle-result');
Route::get('/get-teams', [ResultController::class, 'getTeams'])->name('teams-ajax');
Route::get('/{id}', [JourneyController::class, 'index'])->name('journey');
