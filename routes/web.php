<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LottoController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\GenerateController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

/* Route::get('/lotto', [LottoController::class, 'index']);
Route::get('/random', [LottoController::class, 'random']); */
Route::get('/result', [ResultController::class, 'index'])->name('result');
Route::get('/hits', [HistoricController::class, 'index'])->name('hits');
Route::post('/handle-result', [ResultController::class, 'handleResult'])->name('handle-result');
Route::get('/get-teams', [ResultController::class, 'getTeams'])->name('teams-ajax');
Route::get('/journey/{id}', [JourneyController::class, 'index'])->name('journey');

Route::get('/generate', [GenerateController::class, 'index'])->name('generate');
