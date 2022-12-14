<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laravelEx;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route for api1 : that sorts a string according to a specific format
Route::get("api1/{input_str}", [laravelEx::class,'sort']);

//Route for api2 : that receives a number and returns each place value in the number
Route::get("api2/{input_int}", [laravelEx::class,'placeValue']);

//Route for api3 : that replaces the numbers in a string with their binary form.
Route::get("api3/{input_string}", [laravelEx::class,'convertToBinary']);

//Route for api4 : that evaluate prefix notations
Route::get("api4/{input_str}", [laravelEx::class,'prefixEvalution']);
