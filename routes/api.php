<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;


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
// Route::get('/posts',function(){
//     return response()->json([
//         'posts'=>[
//             'title'=>'post one'
//         ]
//     ]);
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/',[ListingController::class,'index']);
Route::get('/listings/create',[ListingController::class,'create'])->middleware('auth');

//store listing data
Route::post('/listings',[ListingController::class,'store'])->middleware('auth');

Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');
Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');
Route::delete('/listings/{listing}',[ListingController::class,'destroy'])->middleware('auth');
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');



Route::get('/register',[UserController::class,'create'])->middleware('guest');
Route::post('/users',[UserController::class,'store']);
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');
Route::post('/users/authenticate',[UserController::class,'authenticate']);





//route model binding ' in eloquent model ' to get 404 on wrong routes
Route::get('/listings/{listing}',[ListingController::class,'show']);