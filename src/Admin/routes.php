<?php

use Illuminate\Support\Facades\Route;
use Porygon\Organization\Admin\Controllers\DepartmentController;
use Porygon\Organization\Admin\Controllers\PostController;

/**
 * 组织架构
 */
Route::group(["prefix" => "organization", "as" => "organization."], function () {
    Route::resources([
        "departments" => DepartmentController::class,    // 部门管理
        "posts"       => PostController::class,          // 职务管理
    ]);
});
