<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('CheckAuthentication')->group(function(){
Route::get('chat',[ChatController::class,'chat'])->name('chat');
Route::post('send',[ChatController::class,'send'])->name('send');

Route::get('list-users',[UserController::class,'index'])->name('user');
Route::post('add-users',[UserController::class,'store'])->name('add');
Route::post('detail-users',[UserController::class,'edit'])->name('DetailUser');
Route::post('update-users',[UserController::class,'update'])->name('UpdateUser');
Route::post('delete-users',[UserController::class,'destroy'])->name('DeleteUser');


// chat private

Route::get('chatSolution/{id}' ,[ChatController::class ,'chatSolution'])->name('chatSolution');

Route::post('postMessage/{id}' ,[ChatController::class ,'Message'])->name('Message');


// profile
Route::get('profileView/{id}' ,[ChatController::class ,'profileView'])->name('profileView');
//

});
