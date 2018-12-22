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

Auth::routes(['verify' => true]);
Route::get('/', 'HomeController@index')->name('home');

Route::middleware(['auth', 'verified', 'web'])->group(function(){

    /**
     * Routes for Post
     */
    Route::get('/posts', 'PostController@store')->name('post.store');
    Route::get('/posts/view/{id}', 'PostController@view')->name('post.view');
    Route::get('/posts/create', 'PostController@create')->name('post.create');
    Route::post('/posts/save', 'PostController@save')->name('post.save');
    Route::get('/posts/edit/{id}', 'PostController@edit')->name('post.edit');
    Route::post('/posts/update/{id}', 'PostController@update')->name('post.update');
    Route::get('/posts/delete/{id}', 'PostController@delete')->name('post.delete');

    /**
     * Routes for Category
     */
    Route::get('/categories', 'CategoryController@store')->name('category.store');
    Route::post('/categories/save', 'CategoryController@save')->name('category.save');
    Route::post('/categories/update/{id}', 'CategoryController@update')->name('category.update');
    Route::get('/categories/delete/{id}', 'CategoryController@delete')->name('category.delete');

    /**
     * Routes for Email
     */
    Route::get('/email', 'EmailController@form')->name('email.form');
    Route::post('/email/send', 'EmailController@send')->name('email.send');

    /**
     * Routes for Role
     */
    Route::get('/roles', 'RoleController@store')->name('role.store');
    Route::get('/roles/create', 'RoleController@create')->name('role.create');
    Route::post('/roles/save', 'RoleController@save')->name('role.save');
    Route::get('/roles/view/{id}', 'RoleController@view')->name('role.view');
    Route::get('/roles/edit/{id}', 'RoleController@edit')->name('role.edit');
    Route::post('/roles/update/{id}', 'RoleController@update')->name('role.update');
    Route::get('/roles/delete/{id}', 'RoleController@delete')->name('role.delete');

    /**
     * Routes for User
     */
    Route::get('/users', 'UserController@store')->name('user.store');
    Route::get('/users/view/{id}', 'UserController@view')->name('user.view');
    Route::get('/users/edit/user-role/{id}', 'UserController@editUserRole')->name('user.edit.role');
    Route::post('/users/update/user-role/{id}', 'UserController@updateUserRole')->name('user.update.role');
    Route::get('/users/delete/{id}', 'UserController@delete')->name('user.delete');
});
