<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

//    $router->get('/', 'HomeController@index')->name('admin.home');/*首页 - 系统信息*/
    $router->redirect('/', 'admin/demos');/*重定向至我的项目*/
    // $router->get('dashboard', 'PagesController@dashboard')->name('admin.dashboard');/*系统信息*/
    $router->get('horizon', 'PagesController@horizon')->name('admin.horizon');/*Horizon*/
    $router->post('wang_editor/images', 'WangEditorController@images')->name('admin.wang_editor.images');/*WangEditor 上传图片*/

    $router->resource('users', 'UsersController');
    // $router->get('demos/assignment', 'DemosController@assignmentShow')->name('admin.demos.assignment.show'); /*Demo Assignment 页面*/
    // $router->post('demos/assignment', 'DemosController@assignmentStore')->name('admin.demos.assignment.store'); /*Demo Assignment 请求处理*/
    $router->resource('demos', 'DemosController');
    $router->resource('categories', 'CategoriesController');
});
