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






// THE CODE ISN'T ORGANIZED (Jquery, Php, ..) 
//All the logic in the project just for test.

Route::get('/', function () {
    return view('welcome');
});


Route::get('/bots', 'MainController@botsPage')->name('botsPage');
Route::get('/edit/bot', 'MainController@editBot')->name('editBot');




Route::get('/done', function(){return 'done';});
Route::get('/add/intent', 'MainController@listIntent');
Route::get('/pages', 'MainController@list');
Route::get('/disconnect/facebook', 'MainController@diconnectFacebook')->name('diconnectFacebook');
Route::post('/add/bot', 'MainController@addBot');