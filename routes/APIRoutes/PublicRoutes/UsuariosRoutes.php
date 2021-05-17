<?php
Route::group(['prefix'=>'usuarios','middleware'=>['jwt.auth']],function(){
	
	Route::get('/','PrivateControllers\UsuariosController@getAll')->name('saludo');
	Route::post('/create','PrivateControllers\UsuariosController@create');
	Route::get('/show','PrivateControllers\UsuariosController@show');
	Route::post('/update','PrivateControllers\UsuariosController@update');
	Route::post('/delete','PrivateControllers\UsuariosController@delete');

});
