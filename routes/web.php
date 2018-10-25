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


Route::get('/', 'login\LoginController@LoginShow');

Route::get('login', 'login\LoginController@LoginShow');

Route::post('login', 'login\LoginController@login');

Route::get('logout', 'login\LoginController@logout');

Route::prefix('password')->group(function () {
	Route::get('forgot'        , 'password\PasswordController@forgotPasswordView');
	Route::post('emailReset'   , 'password\PasswordController@sendPasswordResetToken');
	Route::get('resetPassword' , 'password\PasswordController@resetPasswordView');
	Route::put('reset'         , 'password\PasswordController@resetPassword');
	Route::put('update'        , 'password\PasswordController@updatePassword');
});

Route::prefix('admin')->group(function () {
	Route::get('/','admin\adminController@inicio');
	Route::prefix('user')->group(function () {
		Route::get('new'              , 'admin\usersController@newView');
		Route::get('list'             , 'admin\usersController@listView');
		Route::get('listStatus'       , 'publics\UserClientStatusController@listStatus');
		Route::get('listType'         , 'publics\UserTypeController@listType');
		Route::post('new'             , 'admin\usersController@new');
		Route::post('list'            , 'admin\usersController@list');
		Route::put('update'           , 'admin\usersController@update');
		Route::put('block'            , 'admin\usersController@block');
		Route::put('activate'         , 'admin\usersController@activate');
		Route::put('delete'           , 'admin\usersController@delete');
		Route::put('restore'          , 'admin\usersController@restore');
		Route::put('updatePassword'   , 'admin\usersController@updatePassword');
		Route::put('redefinePassword' , 'admin\usersController@redefinePassword');
		Route::get('count'            , 'admin\usersController@countUser');
	});
});
