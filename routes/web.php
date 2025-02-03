<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;

// 📌 Najpierw API - Laravel obsługuje endpointy jako pierwsze
Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);
Route::put('/books/{id}', [BookController::class, 'update']);


Route::get('/reviews', [ReviewController::class, 'index']); // Pobieranie recenzji
Route::post('/reviews', [ReviewController::class, 'store']); // Dodawanie recenzji
Route::put('/reviews/{id}', [ReviewController::class, 'update']); // Edycja recenzji (tylko autor)
Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']); // Usuwanie recenzji (tylko autor)


// 📌 Na końcu - Vue obsługuje wszystkie pozostałe trasy
Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');
