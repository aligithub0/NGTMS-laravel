<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::get('/dashboard', function () {
    return view('dashboard'); // This points to `resources/views/dashboard.blade.php`
});


