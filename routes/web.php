<?php

use App\Http\Livewire\FuzzyRecommendation;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/fuzzy-recommendation', fn() => view('fuzzy-recommendation'))->name('fuzzy-recomendation');
    
    Route::get('/scenario-comparison', fn() => view('scenario-comparison'))->name('scenario-comparison');

});
