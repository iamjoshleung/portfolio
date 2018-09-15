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

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/projects', 'ProjectController@index')->name('projects');

Route::prefix('admin')->middleware('auth')->group(function() {
    Route::get('/', 'HomeController@index')->name('admin.index');
    Route::get('projects', 'ProjectController@index')->name('admin.projects.index');
    Route::get('projects/create', 'ProjectController@create')->name('admin.projects.create');
    Route::post('projects', 'ProjectController@store')->name('admin.projects.store');
    Route::get('projects/{project}', 'ProjectController@show')->name('admin.projects.show');
    Route::patch('projects/{project}', 'ProjectController@update')->name('admin.projects.update');
    Route::delete('projects/{project}', 'ProjectController@destroy')->name('admin.projects.destroy');
    Route::post('/projects/sort', 'SortProjectController@store')->name('admin.projects.sort');

    Route::delete('projects/{project}/gallery/{projectGallery}', 'ProjectGalleryController@destroy')->name('admin.project.gallery.destroy');
    Route::post('projects/{project}/gallery', 'SortGalleryController@update')->name('admin.project.gallery.update');
});

Route::get('/{any}', 'SpaController@index')->where('any', '.*');


