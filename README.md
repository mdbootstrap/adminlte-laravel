# AdminLTE template Laravel package
A Laravel package that switch default Laravel scaffolding / boilerplate to AdminLTE template with Bootstrap 3.0 and Pratt Landing Page

See demo here:

 http://demo.adminlte.acacha.org/

If you are looking for the Laravel 4 version, use 0.1.5 version/tag and see [OLD-README.md](OLD-README.md)

[![Latest Version on Packagist](https://poser.pugx.org/acacha/admin-lte-template-laravel/v/stable.svg)](https://packagist.org/packages/acacha/admin-lte-template-laravel)
[![Total Downloads](https://poser.pugx.org/acacha/admin-lte-template-laravel/downloads.png)](https://packagist.org/packages/acacha/admin-lte-template-laravel)
[![Monthly Downloads](https://poser.pugx.org/acacha/admin-lte-template-laravel/d/monthly)](https://packagist.org/packages/acacha/admin-lte-template-laravel)
[![Daily Downloads](https://poser.pugx.org/acacha/admin-lte-template-laravel/d/daily)](https://packagist.org/packages/acacha/admin-lte-template-laravel)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/badges/build.png?b=master)](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/build-status/master)
[![StyleCI](https://styleci.io/repos/35628567/shield)](https://styleci.io/repos/35628567)
[![Build Status](https://travis-ci.org/acacha/adminlte-laravel.svg?branch=master)](https://travis-ci.org/acacha/adminlte-laravel)

# Installation

```bash
composer require "acacha/admin-lte-template-laravel"
```

Finally publish files with:

```php
php artisan vendor:publish --tag=adminlte --force
```

# Requirements

This packages use (no need to install):

* [Composer](https://getcomposer.org/)
* [Laravel](http://laravel.com/)
* [AdminLTE](https://github.com/almasaeed2010/AdminLTE).
* [Pratt](http://blacktie.co/demo/pratt/). Pratt Landing Page
* [acacha/helpers](https://github.com/acacha/helpers) : Extra helpers for Laravel provided by acacha.
* [creativeorange/gravatar](https://github.com/creativeorange/gravatar): Gravatar support for user's profile images. This could be optional through configuration.
* [league/flysystem](https://github.com/thephpleague/flysystem) : Filesystem support.
* [laravel/ui](https://github.com/laravel/ui) : Laravel authentication scaffolding.
* [thephpleague/skeleton](https://github.com/thephpleague/skeleton). This package use/has been adapted to use the phpleague skeleton.
* Acacha llum requires GNU sed. on MAC OS install GNU sed with:

```bash
brew install gnu-sed --with-default-names
```

This package assumes that you have in path your composer bin folder:

```
/YOUR_PATH_TO_HOME/.composer/vendor/bin
```

For example adding this line:

```bash
export PATH=${PATH}:~/.composer/vendor/bin
```

to your ~/.bashrc file

Note: in some systems the path coul be diferent for example:

```bash
export PATH=${PATH}:~/.config/composer/vendor/bin
```

Please be sure to check you environment.

## Optional requirements
* [Laravel menu](https://github.com/spatie/laravel-menu): only used with command adminlte:menu that replaces default adminlte menu with a menu with spatie/laravel-menu support.

## Laravel 7 and older

- This package works smoothly with Laravel 7.x with 7.x version
- This package works smoothly with Laravel 6.x|5.x with 6.x version

## Laravel Routes

This package installs Laravel routes that you will not find them at routes.php file. The routes installed by package would be find at file:

 https://github.com/acacha/adminlte-laravel/blob/master/src/Http/routes.php

A file included by AdminLTETemplateServiceProvider:

 https://github.com/acacha/adminlte-laravel/blob/master/src/Providers/AdminLTETemplateServiceProvider.php

You can override this routes by changing order of ServiceProviders in config/app.php file so if you put:

```php
App\Providers\RouteServiceProvider::class
```

After

```php
Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class
```

Your routes in routes.php file will override default adminlte-laravel routes.

Also you can install manually the routes in routes.php file. Adminlte-laravel use same routes as Laravel make:auth command use, see:

https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/routes.stub

so you can add this lines to routes.php file:

```php
Route::auth();

Route::get('/home', 'HomeController@index');
```

And disable AdminLTETemplateServiceProvider in config/app.php file ( take into account that Adminte-laravel Facades and
custom commands will not be available).

See issue https://github.com/acacha/adminlte-laravel/issues/69 for more info

## First steps, database creation, migrations and login

Once package installed you have to follow the usual steps of any laravel project to Login to the admin interface:

- Create a database. I recommend the use of laravel Homestead ()
- Create/check .env file and configure database access (database name, password, etc)
- Run migrations with command $ php artisan migrate
- Registera a first user and Login with it

## AdminLTE

AdminLTE is a Free Premium Admin control Panel Theme That Is Based On Bootstrap 3.x created by Abdullah Almsaeed. See:

https://github.com/almasaeed2010/AdminLTE

## Avatar/Gravatar

Adminlte-laravel supports global recognized avatar (http://gravatar.com) using package creativeorange/gravatar (https://github.com/creativeorange/gravatar).

# Artisan Commands

## make:view

This commands adds a view to **resources/views** folder using default adminlte layout:

```bash
php artisan make:view about
```

## make:menu

This commands adds a menu entry to file **config/menu.php**:

```bash
php artisan make:menu link menuname
```

Example:

```bash
php artisan make:menu /contact
```

## make:route

This commands adds a route to routes file using:

```bash
php artisan make:route linkname
```

For example you can add a route  **routes/web.php** file with URI **/about** using:

```bash
php artisan make:route about
```

This commands add this entry to routes/web.php

You can create 3 types of routes with option **type**:

* **regular**: routes using a clousure with a simple return view command. This is the default one
* **controller**: routes using a controller.
* **resource**: routes using a resource controller.

Examples:

```bash
php artisan make:route about --type=controller
```

this adds the following:

```php
Route::get('about', 'AboutController@index');
```

to file **routes/web.php**. You can choose the controller name and method with:

```bash
php artisan make:route about MyController@method --type=controller
```

If you want to create a resource controller:

```bash
php artisan make:route about --type=resource
```

this adds the following:

```php
Route::resource('about', 'About@index');
```

to file **routes/web.php**.

You can also create routes with other HTTP methods using option **method**:

```bash
php artisan make:route save --method=post
```

You can also add routes to api using option **api**:

```bash
php artisan make:route save --api
```

Then the routes will be added to **routes/api.php**.

Finally use option **-a** to add actions after route creation:

```bash
php artisan make:route about -a
```

Last command also create a view with name **about.blade.php**. Using:

```bash
php artisan make:route about -a --type=controller
```

Will create a Controller file with name **AboutController** and method index.

You can consult all options with:

```bash
php artisan make:route --help
```

## adminlte:publish | adminlte-laravel:publish

This command is already executed during installation you can (re)execute manually with:

```bash
php artisan adminlte:publish
```

Publish all necessary files from package to Laravel project.

## adminlte:sidebar | adminlte-laravel:sidebar

Only publish package sidebar to Laravel project allowing to customize sidebar:

```bash
php artisan adminlte:sidebar
```

Note: sidebar is already published when you use **adminlte-laravel install** command.

## adminlte:menu | adminlte-laravel:menu

Replaces sidebar view with a sidebar using [spatie/laravel-menu](https://github.com/spatie/laravel-menu):

```bash
php artisan adminlte:menu
```

This command also installs spatie/laravel-menu package and creates a default menu located **config/menu.php**.

***IMPORTANT***: Spatie Laravel Menu required PHP7.0 or superior to work

## adminlte-laravel:admin | adminlte:admin

Executes make:adminUserSeeder artisan command (see next section) an executes seed. This command adds a default admin user to database.

```bash
php artisan adminlte:admin
File /home/sergi/Code/AdminLTE/acacha/adminlte-laravel_test/database/seeds/AdminUserSeeder.php created
User Sergi Tur Badenas(sergiturbadenas@gmail.com) with the environemnt password (env var ADMIN_PWD) created succesfully!
```

This command use (if exists) environment variables (.env file) ADMIN_USER, ADMIN_EMAIL and ADMIN_PWD. If this env variables does not exists then
user git config (~/.gitconfig) to obtain data and if this info does not exists use Admin (admin@example.com) and password 123456 as default.

### make:adminUserSeeder

Create a new seed to add admin user to database. Use:

```bash
php artisan make:adminUserSeeder
File /home/sergi/Code/AdminLTE/acacha/adminlte-laravel_test/database/seeds/AdminUserSeeder.php created
```
# Social Login/Register with acacha/laravel-social

It's a cinch to add (optional) Social Login/Register support to Laravel Adminlte using [acacha/laravel-social](https://github.com/acacha/laravel-social) package. Execute in your project root folder:

```bash
adminlte-laravel social
```

Follow the wizard to configure your social providers Oauth data and enjoy!

More info at https://github.com/acacha/laravel-social.

## How to remove social Login?

Remove line

```php
@include('auth.partials.social_login')
```

in files `resources/views/auth/login.blade.php` and `register.blade.php`

# Roadmap

- Add email html templates
- Add breadcrumps with: https://github.com/davejamesmiller/laravel-breadcrumbs

## Documentation TODO

- Gulp file provided to compile Boostrap and AdminLTE less files
- Partial views (html header, content header, footer, etc.) to easily reuse code

## Packagist

https://packagist.org/packages/acacha/admin-lte-template-laravel

## More info

http://acacha.org/mediawiki/AdminLTE#adminlte-laravel

## Tests

### Testing this package

Use phpunit on run composer script test:

``` bash
$ composer test
```

### Testing laravel project once this package is installed

Once this package is installed in a Laravel project some tests are installed to test package features. There are two kind of tests Feature/Unit tests and Browser tests. To execute Feature/Unit tests execute:

```
./vendor/bin/phpunit
```

In a new created laravel project with acacha-admintle.laravel installed to test that package is installed correctly. You can also execute Browser tests with Laravel Dusk (please install first manually Dusk package following https://laravel.com/docs/master/dusk):

```
php artisan dusk:install
touch database/testing.database.sqlite
php artisan serve --env=dusk.local &
php artisan dusk
```

You can also test this package in a sandbox without need to install. Run script:

```bash
./test.sh
```

## Localization

All strings are localized using Laravel localization support: https://laravel.com/docs/master/localization

In your config/app.php file you can change locale to change language. You can install only localized files using tag  adminlte_lang:

```bash
php artisan vendor:publish --tag=adminlte_lang --force
```

The following languages are supported by default on this package: English, Catalan, Spanish, Dutch and Brazilian Portuguese. Please feel free to submit a new pull request with another languages if you wish.

## Troubleshooting

### GNU sed on MAC OS

NOTA: not needed in Laravel 5.5+

Acacha llum need GNU sed to work so replace BSD sed with GNU sed using:

```bash
brew install gnu-sed --with-default-names
```

Check you version of sed with:

```bash
man sed
```

sed GNU version path is:

```bash
$ which sed
/usr/local/bin/sed
```

Instead of default path of BSD sed (installed by default on MAC OS):

```bash
/usr/bin/sed
```

More info at https://github.com/acacha/adminlte-laravel/issues/58

## How to use username at login instead of email

Execute command:

```
php artisan adminlte:username
```

And then you can use username instead of email for login.

NOTE: when we are using login by username if login by usernames fails then
system try to use the introduced username as an email for login. So users
can also login using email.

To come back to email login remove **field** option from **config/auth.php** file:

```bash
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\User::class,
        'field' => 'username' // Adminlte laravel. Valid values: 'email' or 'username'
    ],
```

NOTE: Migration required to add username field to users table requires:

```bash
composer require doctrine/dbal
```

### Default domain for username registration

Optionally you can define a default domain name for username login. Add domain option:

```php
'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
    'domain' => 'defaultdomain.com',
],
```

to file **config/auth.php**. Then if an user tries to login with no domain the default domain will be appended whe logging.

So with previous example you can type at login:

```
sergiturbadenas
```

and system/javascript will replace that with:

```
sergiturbadenas@defaultdomain.com
```

# Vue

Laravel adminlte package by default publish Laravel translations into Javascript/Vue.js adding to HTML header the following script:

```javascript
<script>
    //See https://laracasts.com/discuss/channels/vue/use-trans-in-vuejs
    window.trans = @php
        // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
        $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
        $trans = [];
        foreach ($lang_files as $f) {
            $filename = pathinfo($f)['filename'];
            $trans[$filename] = trans($filename);
        }
        $trans['adminlte_lang_message'] = trans('adminlte_lang::message');
        echo json_encode($trans);
    @endphp
</script>
```

This script is located in partial blade file (vendor/acacha/admin-lte-template-laravel/resources/views/layouts/partials/htmlheader.blade.php)

So global variable window.trans contains all Laravel translations at can be used in any Javascript file.

Also in file **resources/assets/js/bootstrap.js** code section:

```
Vue.prototype.trans = (key) => {
    return _.get(window.trans, key, key);
};
```

Allows using directly the trans function in vue templates:

```
{{ trans('auth.failed') }}
```

Also you can use inside Vue components code:

```
this.trans('auth.failed')
```

Laravel Adminlte messages ara available using prefix **adminlte_lang_message**:

```
{{ trans('adminlte_lang_message.username') }}
```


Feel free to remove/adapt this file to your needs.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email sergiturbadenas@gmail.com instead of using the issue tracker.

## Credits

- [Sergi Tur Badenas][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## See also

https://github.com/acacha/adminlte-laravel-installer

[ico-version]: https://img.shields.io/packagist/v/acacha/adminlte-laravel.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/acacha/adminlte-laravel/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/acacha/adminlte-laravel.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/acacha/adminlte-laravel.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/acacha/adminlte-laravel.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/acacha/admin-lte-template-laravel
[link-travis]: https://travis-ci.org/acacha/adminlte-laravel
[link-scrutinizer]: https://scrutinizer-ci.com/g/acacha/adminlte-laravel/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/acacha/adminlte-laravel
[link-downloads]: https://packagist.org/packages/acacha/adminlte-laravel
[link-author]: https://github.com/acacha
[link-contributors]: ../../contributors
