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
     * Routes for Posts
     */
    Route::get('/posts', 'PostsController@store')->name('posts.store');
    Route::get('/posts/view/{id}', 'PostsController@view')->name('posts.view');
    Route::get('/posts/create', 'PostsController@create')->name('posts.create');
    Route::post('/posts/save', 'PostsController@save')->name('posts.save');
    Route::get('/posts/edit/{id}', 'PostsController@edit')->name('posts.edit');
    Route::post('/posts/update/{id}', 'PostsController@update')->name('posts.update');
    Route::get('/posts/delete/{id}', 'PostsController@delete')->name('posts.delete');

    /**
     * Routes for Categories
     */
    Route::get('/categories', 'CategoriesController@store')->name('categories.store');
    Route::post('/categories/save', 'CategoriesController@save')->name('categories.save');
    Route::post('/categories/update/{id}', 'CategoriesController@update')->name('categories.update');
    Route::get('/categories/delete/{id}', 'CategoriesController@delete')->name('categories.delete');

    /**
     * Routes for Email
     */
    Route::get('/email', 'EmailController@form')->name('email.form');
    Route::post('/email/send', 'EmailController@send')->name('email.send');

    /**
     * Routes for Roles
     */
    Route::get('/roles', 'RolesController@store')->name('roles.store');
    Route::get('/roles/create', 'RolesController@create')->name('roles.create');
    Route::post('/roles/save', 'RolesController@save')->name('roles.save');
    Route::get('/roles/view/{id}', 'RolesController@view')->name('roles.view');
    Route::get('/roles/edit/{id}', 'RolesController@edit')->name('roles.edit');
    Route::post('/roles/update/{id}', 'RolesController@update')->name('roles.update');
    Route::get('/roles/delete/{id}', 'RolesController@delete')->name('roles.delete');

    /**
     * Routes for Users
     */
    Route::get('/users', 'UsersController@store')->name('users.store');
    Route::get('/users/view/{id}', 'UsersController@view')->name('users.view');
    Route::get('/users/edit/user-role/{id}', 'UsersController@editUserRole')->name('users.edit.role');
    Route::post('/users/update/user-role/{id}', 'UsersController@updateUserRole')->name('users.update.role');
    Route::get('/users/delete/{id}', 'UsersController@delete')->name('users.delete');
});
