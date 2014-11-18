<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get(
    '/',
    array(
        'uses' => 'HomeController@showWelcome',
        'as'   => 'HomePage',
    )
);

Route::get(
    '/getinfo',
    array(
        'uses' => 'HomeController@getUserInfo',
        'as'   => 'getInfo',
    )
);

Route::post(
    '/doRegister',
    array(
        'uses' => 'HomeController@doRegister',
        'as'   => 'doRegister',
    )
);