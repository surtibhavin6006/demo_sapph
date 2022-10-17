<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\TeamController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix'=>'team','as'=>'api.team.'],function() {
   Route::get('/',[TeamController::class,'index'])->name('list');
   Route::post('/',[TeamController::class,'store'])->name('store');
   Route::post('/winner-step/{stepId}',[TeamController::class,'winnerStep'])->name('winner-step');
});
