#AdminLTE template Laravel package
A Laravel package that switch default Laravel scaffolding/boilerplate to AdminLTE template

[![Total Downloads](https://poser.pugx.org/acacha/admin-lte-template-laravel/downloads.png)](https://packagist.org/packages/acacha/admin-lte-template-laravel)
[![Latest Stable Version](https://poser.pugx.org/acacha/admin-lte-template-laravel/v/stable.png)](https://packagist.org/packages/acacha/admin-lte-template-laravel)

#Requirements

* [Composer](https://getcomposer.org/)
* [Laravel](http://laravel.com/)
* [AdminLTE](https://github.com/almasaeed2010/AdminLTE). You can see and AdminLTE theme preview at: http://almsaeedstudio.com/preview/

## Laravel 5.1 notes

By default this version of Laravel does not include default auth routes. See:

http://laravel.com/docs/5.1/authentication

You will have to add this lines at your routes.php file:

<pre>
// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

</pre>

or:

<pre>
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
</pre>

and route to /home

<pre>
Route::get('/home', ['middleware' => 'auth', function () {
    return view('home');
}]);
</pre>



Also be aware of using new style (endig with ::class) when adding AdminLTETemplateServiceProvider to **config/app.php** file:

<pre> 
 // AdminLTE template provider
 'Acacha\AdminLTETemplateLaravel\app\Providers\AdminLTETemplateServiceProvider',
</pre>

##Installation

First install Laravel (http://laravel.com/docs/5.0/installation) and then Create a new Laravel project:

<pre>
 $ laravel new laravel-with-admin-lte
 $ cd laravel-with-admin-lte
</pre>

Add admint-lte Laravel package with:

<pre>
 $ composer require "acacha/admin-lte-template-laravel:0.*"
</pre> 
 
Register ServiceProvider editing **config/app.php** file and adding to providers array:

<pre> 
 // AdminLTE template provider
 'Acacha\AdminLTETemplateLaravel\app\Providers\AdminLTETemplateServiceProvider',
</pre>

or in Laravel 5.1:

<pre> 
// AdminLTE template provider         
Acacha\AdminLTETemplateLaravel\app\Providers\AdminLTETemplateServiceProvider::class,
</pre>

Publish files with:

<pre>
 $ php artisan vendor:publish --force --provider="Acacha\AdminLTETemplateLaravel\app\Providers\AdminLTETemplateServiceProvider"
</pre> 
 
Use force to overwrite Laravel Scaffolding packages. That's all! Open the Laravel project in your browser or homestead machine and enjoy! 

##First steps, database creation, migrations and login

Once package installed you have to follow the usual steps of any laravel project to Login to the admin interface:

- Create a database. I recommend the use of laravel Homestead ()
- Create .env file and configure database acces (database name, password, etc)
- Run migrations with command $ php artisan migrate
- Registera a first user and Login with it

##AdminLTE

AdminLTE is a Free Premium Admin control Panel Theme That Is Based On Bootstrap 3.x created by Abdullah Almsaeed. See:

https://github.com/almasaeed2010/AdminLTE

# Roadmap

- Implement Facebook, Google and maybe twitter and github Login with Socialite
- Add email html templates

## Documentation TODO

- Gulp file provided to compile Boostrap and AdminLTE less files
- Partial views (html header, content header, footer, etc.) to easily reuse code
- Add breadcrumps with: https://github.com/davejamesmiller/laravel-breadcrumbs

## Packagist

https://packagist.org/packages/acacha/admin-lte-template-laravel

## More info

http://acacha.org/mediawiki/AdminLTE#adminlte-laravel
