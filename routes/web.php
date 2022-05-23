<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

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

Route::get('/', [ReportController::class, 'reportView'])->name('reportView');
Route::get('api/userIds', [ReportController::class, 'userIdList'])->name('userIdList');
Route::post('api/SearchData', [ReportController::class, 'reportData'])->name('reportData');