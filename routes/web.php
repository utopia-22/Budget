<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Symfony\Component\HttpKernel\Profiler\Profile;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::middleware(['auth', 'verified'])->group(function () {
   
	Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('user/profile', [ ProfileController::class, 'index'])->name('profile');
	Route::put('user/profile/update-profile-information-form', [ ProfileController::class, 'update'])->name('user-profile-information.update');
	Route::put('user/profile/update-password-form', [ ProfileController::class, 'edit'])->name('user-password.update');
	Route::get('income', [ IncomeController::class, 'index'])->name('income');
	Route::delete('/income/{id}', [ IncomeController::class, 'destroy'])->name('income.destroy');
	Route::post('income', [IncomeController::class, 'store'])->name('income.store');
	Route::get('expense', [ ExpenseController::class, 'index'])->name('expense');
	Route::delete('/expense/{id}', [ ExpenseController::class, 'destroy'])->name('expense.destroy');
	Route::post('expense', [ExpenseController::class, 'store'])->name('expense.store');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

// Route::view('dashboard', 'dashboard')
// 	->name('dashboard')
// 	->middleware(['auth', 'verified']);



