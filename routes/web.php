<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenAIController;

// Route GET / akan pakai controller (biar bisa reset variable saat balik)
Route::get('/', [OpenAIController::class, 'formInput'])->name('form_input');

// Route untuk proses form → kirim ke OpenAI dan tampilkan hasil
Route::post('/generate', [OpenAIController::class, 'generate'])->name('generate.recipe');