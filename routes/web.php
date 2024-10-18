<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(config('l5-swagger.documentations.default.routes.api'));
});
