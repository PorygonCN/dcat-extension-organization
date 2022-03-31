<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;
use Porygon\User\Admin\Controller\UserController;

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->group(["prefix" => "user", "as" => "user_center."], function (Router $router) {
        $router->resources([
            "users" => UserController::class,          // 用户管理
        ]);
        // 获取用户导入模板
        $router->get("users/import/template", 'UserController@getImportTemplate')->name("users.import.template");
        // 获取新工号
        $router->get("getleastno", 'UserController@getLeastNo')->name("getleastno");
    });
});
