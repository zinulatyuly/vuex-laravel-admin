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

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('admin/login', 'Auth\LoginController@login')->name('admin.login.submit');
Route::get('admin/logout', 'Auth\LoginController@logout')->name('auth.logout');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('admin.logout.submit');

$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('/', function() {
        return redirect('admin/dashboard');
    });
    Route::get('/{any}', 'HomeController@index')->where('any', '.*');
});
//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
