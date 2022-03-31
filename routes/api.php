<?php

use Illuminate\Support\Facades\Route;
use Porygon\User\Admin\Controllers\UserController;

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'middleware' => config('admin.route.middleware'),
    "as" => "dcat.admin."
], function () {
    Route::group(["prefix" => "api", "as" => "api."], function () {
    });
});
