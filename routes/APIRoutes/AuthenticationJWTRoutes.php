<?php

Route::post('/login','JWT\AuthenticationJWTController@login')->name('login');

Route::group(['middleware'=>['jwt.auth']],function(){
	Route::post('/getuser','JWT\AuthenticationJWTController@getAuthenticatedUser');
	Route::post('/logout','JWT\AuthenticationJWTController@logout')->name('logout');
});