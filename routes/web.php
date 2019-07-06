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

Route::get('/', 'DiaryController@index')->name('diary.index');


// 一覧以外のページはログインしていないと表示(実行)できないように変更
Route::group(['middleware' => 'auth'], function() {
    Route::get('diary/create', 'DiaryController@create')->name('diary.create');
    Route::post('diary/create', 'DiaryController@store')->name('diary.create');
    
    Route::get('diary/{diary}/edit', 'DiaryController@edit')->name('diary.edit');
    Route::put('diary/{diary}/update', 'DiaryController@update')->name('diary.update');
    
    Route::delete('diary/{diary}/delete', 'DiaryController@destroy')->name('diary.destroy'); 

    Route::post('diary/{id}/like', 'DiaryController@like');
    Route::post('diary/{id}/dislike', 'DiaryController@dislike');
});

Auth::routes();
