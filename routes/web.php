<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdressController, QueryBuilderController};


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
    return view('adress_form');
});
Route::post('/save_adress', [AdressController::class, 'save_adress']);
Route::get('/query_results', [QueryBuilderController::class, 'query']);
