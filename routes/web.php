<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Horizon\Horizon;

Route::get('/', function () {
    return view('welcome');
});

Horizon::auth(function ($request) {
    return Auth::guard('admin')->check();
});

Auth::routes();

/*// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');*/

// Route::resource('example', ExampleController::class);
// Route::get('example', 'ExampleController@index')->name('example.index');
// Route::get('example/create', 'ExampleController@create')->name('example.create');
// Route::get('example/{example}', 'ExampleController@show')->name('example.show');
// Route::get('example/{example}/edit', 'ExampleController@edit')->name('example.edit');
// Route::post('example', 'ExampleController@store')->name('example.store');
// Route::put('example/{example}', 'ExampleController@update')->name('example.update');
// Route::delete('example/{example}', 'ExampleController@destroy')->name('example.destroy');

// Route::redirect('/', 'login')->name('root');/*首页*/
// Route::get('/', 'PagesController@root')->name('root');/*首页*/

// Authentication Routes...
Route::get('designers/login', 'DesignerAuth\LoginController@showLoginForm')->name('designers.login');
Route::post('designers/login', 'DesignerAuth\LoginController@login');
Route::post('designers/logout', 'DesignerAuth\LoginController@logout')->name('designers.logout');

// Registration Routes...
Route::get('designers/register', 'DesignerAuth\RegisterController@showRegistrationForm')->name('designers.register');
Route::post('designers/register', 'DesignerAuth\RegisterController@register');

// Password Reset Routes...
Route::get('designers/password/reset', 'DesignerAuth\ForgotPasswordController@showLinkRequestForm')->name('designers.password.request');
Route::post('designers/password/email', 'DesignerAuth\ForgotPasswordController@sendResetLinkEmail')->name('designers.password.email');
Route::get('designers/password/reset/{token}', 'DesignerAuth\ResetPasswordController@showResetForm')->name('designers.password.reset');
Route::post('designers/password/reset', 'DesignerAuth\ResetPasswordController@reset');

/*需要登录的路由*/
Route::group(['middleware' => 'auth'], function () {

    /*设计师中心*/
    Route::get('designers/home', 'DesignersController@home')->name('designers.home'); // 设计师个人主页
    Route::get('designers/{designer}/edit', 'DesignersController@edit')->name('designers.edit'); // 编辑个人信息页面
    Route::get('designers/{designer}/password', 'DesignersController@password')->name('designers.password'); // 修改密码页面
    Route::put('designers/{designer}/update_password', 'DesignersController@updatePassword')->name('designers.update_password'); // 修改密码提交
    Route::get('designers/{designer}/password_success', 'DesignersController@passwordSuccess')->name('designers.password_success'); // 修改密码成功 页面
    Route::put('designers/{designer}', 'DesignersController@update')->name('designers.update'); // 编辑个人信息提交 & 修改密码提交 & 绑定手机提交
});
