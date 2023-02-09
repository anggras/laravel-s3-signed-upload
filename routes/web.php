<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampleController;

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

Route::get('/sample', [SampleController::class, 'view']);
Route::get('/sample/postupload/', [SampleController::class, 'signedurlforpost']);
Route::post('/sample/submit', [SampleController::class, 'submit']);