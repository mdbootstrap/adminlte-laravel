<?php

Route::controller(
'auth', $this->getAppNamespace().'Http\Controllers\Auth\AuthController',
['getLogin' => 'auth.login',
'getLogout' => 'auth.logout',
'getRegister' => 'auth.register',
]);
Route::controller(
'password', $this->getAppNamespace().'Http\Controllers\Auth\PasswordController',
['getReset' => 'auth.reset']);

Route::get('/home', ['as' => 'home', 'middleware' => 'auth', function () {
return view('home');
}]);
