<?php

	use Illuminate\Support\Facades\Route;

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

Route::prefix('/v1')->group(function(){
	Route::get('/teams', [\App\Http\Controllers\TeamController::class, 'teams']);
	Route::get('/getPlayedMatches/{team_id}', [\App\Http\Controllers\TeamController::class, 'getPlayedMatches']);
	Route::get('/getStats/{team_id}', [\App\Http\Controllers\TeamController::class, 'getStats']);
	Route::get('/organizeMatches/{weekTime}', [\App\Http\Controllers\TeamController::class, 'organizeMatches']);
	Route::get('/resetMatches', [\App\Http\Controllers\TeamController::class, 'resetMatches']);
	Route::get('/getFixtures', [\App\Http\Controllers\TeamController::class, 'getFixtures']);

});
