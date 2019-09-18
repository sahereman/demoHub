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

Route::get('test', 'IndexController@test')->name('name');

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

/*需要登录的路由*/
Route::group(['middleware' => 'auth'], function () {
    //
});
