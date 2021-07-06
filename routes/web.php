<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;

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

Auth::routes();

Route::get('/home', [SuratController::class, 'home'])->name('home')->middleware('auth');

Route::get('/form-tambah', function () {
    return view('form-tambah');
})->middleware('auth');

Route::post('/tambah', [SuratController::class, 'tambah'])->middleware('auth');
Route::get('/hapus-surat/{id}', [SuratController::class, 'hapus'])->middleware('auth');
Route::get('/ubah-surat/{id}', [SuratController::class, 'formUbah'])->middleware('auth');
Route::post('/ubah-surat', [SuratController::class, 'ubah'])->middleware('auth');
Route::get('/download-pdf', [SuratController::class, 'downloadPDF']);
