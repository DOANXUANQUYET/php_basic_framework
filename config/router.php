<?php

// URL : http://localhost:8080/php_basic_framework/home...

Router::get('/home',function (){
    $controller = new Controller();
    $data['page'] = 'home';
    $controller->load_view('layout_master',$data);
});

Router::get('/post/list','postController@index');
Router::get('/post/add','postController@add');
Router::post('/post/create','postController@create');
Router::get('/post/edit/{id}','postController@edit');
Router::post('/post/update','postController@update');
Router::get('/post/delete/{id}','postController@delete');

Router::get('/category/list','categoryController@index');
Router::get('/category/add','categoryController@add');
Router::post('/category/create','categoryController@create');
Router::get('/category/edit/{id}','categoryController@edit');
Router::post('/category/update','categoryController@update');
Router::get('/category/delete/{id}','categoryController@delete');
