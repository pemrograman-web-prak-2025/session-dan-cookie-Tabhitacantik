<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TugasController;

// Home route - accessible to all (ini yang pertama kali diakses)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Tugas routes - protected by auth middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/tugas/create', [TugasController::class, 'create'])->name('tugas.create');
    Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
    Route::get('/tugas/{id}/edit', [TugasController::class, 'edit'])->name('tugas.edit');
    Route::put('/tugas/{id}', [TugasController::class, 'update'])->name('tugas.update');
    Route::delete('/tugas/{id}', [TugasController::class, 'destroy'])->name('tugas.destroy');
});

Route::get('/test-db', function() {
    try {
        DB::connection()->getPdo();
        $jadwals = DB::table('jadwals')->count();
        $tugas = DB::table('tugas')->count();
        return "Database connected! Jadwals: $jadwals, Tugas: $tugas";
    } catch (\Exception $e) {
        return "Database error: " . $e->getMessage();
    }
});