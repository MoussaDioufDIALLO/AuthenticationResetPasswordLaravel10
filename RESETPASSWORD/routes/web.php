<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;  
use App\Http\Controllers\Auth\PasswordController;

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

Route::get('login', [AuthController::class, 'index'])->name('login'); 
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register'); 
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [AuthController::class, 'postRegistration'])->name('regster.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout'); 

//Password 


  
Route::get('forget-password', [PasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [PasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [PasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [PasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


