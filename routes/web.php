<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InertiaTestController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CustomerController;
use Inertia\Inertia;

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

Route::get(
    '/test',
    function () {
        return Inertia::render('InertiaTest');
    }
);
Route::get(
    '/component-test',
    function () {
        return Inertia::render('ComponentTest');
    }
);
Route::get(
    '/test/index',
    [InertiaTestController::class, 'index']
)->name('inertia.index');
Route::get(
    '/test/create',
    [InertiaTestController::class, 'create']
)->name('inertia.create');
Route::post(
    '/test',
    [InertiaTestController::class, 'store']
)->name('inertia.store');
Route::get(
    '/test/show/{id}',
    [InertiaTestController::class, 'show']
)->name('inertia.show');
Route::delete(
    '/test/{id}',
    [InertiaTestController::class, 'delete']
)->name('inertia.delete');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::resource('items', ItemController::class)->middleware(['auth', 'verified']);
Route::resource('customers', CustomerController::class)->middleware(['auth', 'verified']);


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
