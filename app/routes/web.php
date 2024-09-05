<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Search;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', Search::class);