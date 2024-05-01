<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('search');
});

Route::get('/submit', function () {
    return view('submit');
});
