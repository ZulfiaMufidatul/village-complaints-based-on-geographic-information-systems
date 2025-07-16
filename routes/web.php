<?php

use App\Http\Controllers\ComplaintController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ComplaintController::class, 'index'])->name('index');
// POST track (via form pencarian)
Route::post('/track', [ComplaintController::class, 'track'])->name('complaints.track.post');
// GET track (via link di email)
Route::get('/track/{complaints_code}', [ComplaintController::class, 'trackCode'])->name('complaints.track');
Route::get('/track/{complaints_code}/detail', [ComplaintController::class, 'showDetail'])->name('complaints.detail');

Route::get('/complaints', [ComplaintController::class, 'create'])->name('complaints.create');
Route::post('/complaints/store', [ComplaintController::class, 'store'])->name('complaints.store')->middleware("throttle:complaints");

Route::get('/get-rw/{hamletId}', [ComplaintController::class, 'getRW']);
Route::get('/get-rt/{hamletId}/{rwId}', [ComplaintController::class, 'getRT']);
