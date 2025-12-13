<?php

use Illuminate\Support\Facades\Route;

Route::get('/setup', function () {
    Artisan::call('key:generate');
    Artisan::call('migrate', ['--force' => true]);
    return 'Setup complete!';
});

