<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/setup', function () {
    Artisan::call('key:generate');
    Artisan::call('migrate', ['--force' => true]);
    return 'Setup complete!';
});

