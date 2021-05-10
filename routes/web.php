<?php

use Illuminate\Support\Facades\Route;

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
    return redirect(route('incidents.index'));
});

Route::prefix('incidents')
    ->name('incidents.')
    ->group(function () {
        Route::get('/',               'IncidentsController@index')->name('index');
        Route::get('/create',         'IncidentsController@create')->name('create');
        Route::post('/store',         'IncidentsController@store')->name('store');
        Route::get('/edit/{id}',      'IncidentsController@edit')->name('edit');
        Route::put('/update/{id}',    'IncidentsController@update')->name('update');
        Route::delete('/delete/{id}', 'IncidentsController@destroy')->name('destroy');
    });
