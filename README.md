#AdminLTE template Laravel 5 package
A Laravel 5 package that switch default Laravel scaffolding / boilerplate to AdminLTE template with Bootstrap 3.0 and Pratt Landing Page

See demo here:

 http://demo.adminlte.acacha.org/

If you are looking for the Laravel 4 version, use 0.1.5 version/tag and see [OLD-README.md](OLD-README.md)

[![Total Downloads](https://poser.pugx.org/acacha/admin-lte-template-laravel/downloads.png)](https://packagist.org/packages/acacha/admin-lte-template-laravel)
[![Latest Stable Version](https://poser.pugx.org/acacha/admin-lte-template-laravel/v/stable.png)](https://packagist.org/packages/acacha/admin-lte-template-laravel)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/badges/build.png?b=master)](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/build-status/master)

#Requirements

* [Composer](https://getcomposer.org/)
* [Laravel](http://laravel.com/)
* [AdminLTE](https://github.com/almasaeed2010/AdminLTE). You can see and AdminLTE theme preview at: http://almsaeedstudio.com/preview/
* [Pratt](http://blacktie.co/demo/pratt/). Pratt Landing Page

## Laravel 5.2

New version 2.0 supports Laravel 5.2 and now comes with an [installer](https://github.com/acacha/adminlte-laravel-installer) (Laravel/Spark way;-) ).

**So easy to install!**

Install globally with composer:

```bash
composer global require "acacha/adminlte-laravel-installer=~1.0"
```

And convert any Laravel fresh installation to AdminLTE/Pratt with:

```bash
laravel new laravel-with-admin-lte
cd laravel-with-admin-lte
adminlte-laravel install
```

Enjoy!

### Laravel 5.2 manual installation

Follow the typical Laravel package installation steps:

<pre>
 laravel new laravel-with-admin-lte
 cd laravel-with-admin-lte
</pre>

Add admin-lte Laravel package with:

<pre>
 composer require "acacha/admin-lte-template-laravel:2.*"
</pre> 
 
To register the Service Provider edit **config/app.php** file and add to providers array:

```php
/*
* Acacha AdminLTE template provider
 */
Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class,
```

To Register Alias edit **config/app.php** file and add to alias array:

```php
/*
* Acacha AdminLTE template alias
*/
'AdminLTE' => Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::class,
```

Publish files with:

```php
php artisan vendor:publish --tag=adminlte --force
``` 
 
Use force to overwrite Laravel Scaffolding packages. That's all! Open the Laravel project in your browser or homestead machine and enjoy! 

## Laravel 5.1 notes

By default Laravel 5.1 does not include default auth routes. Versions > 1.0 < 2.0 of this package add the necessary routes for you

See  [old README file](OLD-README.md) file for notes of which routes are registered.

###Installation

First install Laravel (http://laravel.com/docs/5.0/installation) and then Create a new Laravel project:

<pre>
 laravel new laravel-with-admin-lte
 cd laravel-with-admin-lte
</pre>

Add admin-lte Laravel package with:

<pre>
 composer require "acacha/admin-lte-template-laravel:1.*"
</pre> 
 
Register ServiceProvider editing **config/app.php** file and adding to providers array:

<pre>
// AdminLTE template provider         
Acacha\AdminLTETemplateLaravel\app\Providers\AdminLTETemplateServiceProvider::class,
</pre>

Publish files with:

<pre>
 php artisan vendor:publish --force --provider="Acacha\AdminLTETemplateLaravel\app\Providers\AdminLTETemplateServiceProvider"
</pre> 
 
Use force to overwrite Laravel Scaffolding packages. That's all! Open the Laravel project in your browser or homestead machine and enjoy! 

Note: use the following for Laravel <5.1 versions:

<pre>
 // AdminLTE template provider
 'Acacha\AdminLTETemplateLaravel\app\Providers\AdminLTETemplateServiceProvider',
</pre>

##First steps, database creation, migrations and login

Once package installed you have to follow the usual steps of any laravel project to Login to the admin interface:

- Create a database. I recommend the use of laravel Homestead ()
- Create/check .env file and configure database acces (database name, password, etc)
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

## See also

https://github.com/acacha/adminlte-laravel-installer
