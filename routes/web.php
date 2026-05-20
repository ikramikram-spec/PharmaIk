<?php

use Illuminate\Support\Facades\Route;

//login
Route::get('/', function () {
    return redirect() -> route('login');
});
