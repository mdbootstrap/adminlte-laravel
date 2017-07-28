# AdminLTE template Laravel 5 package
**Readme简中译者：能力有限，如果翻译不当之处请见谅。并发起新的 pull request。**


这是一个采用Bootstrap 3.0 和 Pratt Landing Page 用于替换 Laravel 默认脚手架工具的工具包

Demo如下：

http://demo.adminlte.acacha.org/

如果你需要支持 Laravel 4 的版本，请使用 0.1.5 版：
[OLD-README.md](OLD-README.md)

[Latest Version on Packagist](https://packagist.org/packages/acacha/admin-lte-template-laravel)
[Total Downloads](https://packagist.org/packages/acacha/admin-lte-template-laravel)
[Monthly Downloads](https://packagist.org/packages/acacha/admin-lte-template-laravel)
[Daily Downloads](https://packagist.org/packages/acacha/admin-lte-template-laravel)
[Scrutinizer Code Quality](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/?branch=master)
[Code Coverage](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/?branch=master)
[Build Status](https://scrutinizer-ci.com/g/acacha/adminlte-laravel/build-status/master)
[StyleCI](https://styleci.io/repos/35628567)
[Build Status](https://travis-ci.org/acacha/adminlte-laravel)
[Dependency Status Composer](https://www.versioneye.com/user/projects/58483fc98c5dae004be97d36)
[Dependency Status Node.js](https://www.versioneye.com/user/projects/58483fc88c5dae0039a10ca5)

# 安装和使用
**最简单的安装方法！** 使用 composer 全局安装

```bash
composer global require "acacha/adminlte-laravel-installer=~3.0"
```

转换任何 Laravel ~~全新~~ (无需全新安装, 感谢： [Acacha/llum](https://github.com/acacha/llums)) 安装 AdminLTE/Pratt :

```bash
laravel new laravel-with-admin-lte
cd laravel-with-admin-lte
adminlte-laravel install
```
Enjoy！如果你想使用llum：

```bash
llum boot
```

为了能在 Laravel 项目中使用 AdminLTE，llum 将帮你配置数据库（sqlite）执行迁移，安装开发工具和服务。

更多关于 llum 命令的信息请查阅： [Acacha/llum](https://github.com/acacha/llum).

重要提示: 在 MAC OS上你必须将 BSD sed 更换为 GNU sed，例如使用 brew 安装：

```bash
brew install gnu-sed --with-default-names
```

# 依赖
用到以下开发包 (无需安装):

* [Composer](https://getcomposer.org/)
* [Laravel](http://laravel.com/)
* [AdminLTE](https://github.com/almasaeed2010/AdminLTE). 你可以预览 AdminLTE 主题： http://almsaeedstudio.com/preview/
* [Pratt](http://blacktie.co/demo/pratt/). Pratt Landing Page
* [Acacha/user](https://github.com/acacha/user):  提供 Laravel 用户功能，配置可选。
* [acacha/helpers](https://github.com/acacha/helpers) : acacha提供的额外的 Laravel helpers。
* [creativeorange/gravatar](https://github.com/creativeorange/gravatar): 支持 Gravatar 头像， 配置可选。
* [league/flysystem](https://github.com/thephpleague/flysystem) : 文件系统支持。
* [acacha/forms](https://github.com/acacha/forms) : JS表单的实现。
* [acacha/llum](https://github.com/acacha/llum). 简化 Laravel 的包安装（和其他任务），用于在不使用 stubs 的情况下修改 config／app.php 文件 (因此在修改文件时，请慎重考虑。)
*Acacha llum 必须使用 GNU sed，在 MAC OS上安装 GNU sed：

```bash
brew install gnu-sed --with-default-names
```

假设你的 composer bin 路径为：
```
/YOUR_PATH_TO_HOME/.composer/vendor/bin
```

比如增加这一行：

```bash
export PATH=${PATH}:~/.composer/vendor/bin
```

到你的 ~/.bashrc 文件

提示：在一些系统中路径可能不一样，如：

```bash
export PATH=${PATH}:~/.config/composer/vendor/bin
```

请务必检查你的系统环境。

## 可选依赖
* [Laravel menu](https://github.com/spatie/laravel-menu): spatie/laravel-menu 支持仅使用 adminlte:menu 命令来替换默认的 adminlte menu。

## llum package
现可在已有的Laravel的项目中使用 [Acacha/llum](https://github.com/acacha/llum) 来安装providers, aliases等。

感谢 llum ，我们可以在不重新安装的情况下，在任何 Laravel 项目中安装 adminlte-laravel。

然而 acacha/llum 使用的 bash 脚本或像 sed 这样的命令不能跨平台兼容。那么没问题，你可以使用向后兼容的版本：

```bash
laravel new laravel-with-admin-lte
cd laravel-with-admin-lte
adminlte-laravel --no-llum install
```
或者你可以使用1.0版的安装器：
```bash
composer global require "acacha/adminlte-laravel-installer=~3.0"
```

## Laravel 5.4
Laravel 5.4 默认是被支持的，请查阅上方的 【安装和使用】部分。以下信息是关于如何在旧的 Laravel 版本中如何安装此扩展包的方法。

### Laravel 5.4 手动安装
典型的 Laravel 包安装步骤：

添加 admin-lte Laravel 包:

编辑 **config/app.php** 来注册 ServiceProvider，在 providers array 中增加：

```php
/*
 * Acacha AdminLTE template provider
 */
Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class,
```

编辑 **config/app.php** 在 alias array 中增加：

```php
/*
 * Acacha AdminLTE template alias
 */
'AdminLTE' => Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::class,
```

发布:

```php
php artisan vendor:publish --tag=adminlte --force
```

使用 force 强制覆盖。好了！现在可以在浏览器或 homestead 虚拟机中打开你的 Laravel 项目了！

## Laravel 5.3
Laravel 5.3 版应使用 3.x 分支。

## Laravel 5.2
你也可以在以前的 Laravel（5.2) 版本中使用：

```
composer global require "acacha/adminlte-laravel-installer=~2.0"
laravel new --5.2 laravel-with-admin-lte
```

## Laravel 5.1 notes
默认情况下，Laravel 5.1 不包含 auth 路由。此工具包大于1.0，小于2.0的版本会为你添加必要的路由。

想了解注册了哪些路由，请查阅  [旧版 README](OLD-README.md)。

### 安装
首先安装 Laravel (http://laravel.com/docs/5.0/installation) 然后创建一个Laravel 项目

添加 admin-lte Laravel 扩展包:

编辑 **config/app.php** 文件注册一个 ServiceProvider ，在 providers array 中添加：

发布:

使用 force 强制覆盖。好了！现在可以在浏览器或 homestead 虚拟机中打开你的 Laravel 项目了！

提示: Laravel 小于 5.1 的版本应添加如下:

## Laravel 路由
你并不能在 routes.php 文件中找到此工具包安装的 Laravel 路由，被工具包安装的路由可以下面找到：

https://github.com/acacha/adminlte-laravel/blob/master/src/Http/routes.php

AdminLTETemplateServiceProvider 文件:

https://github.com/acacha/adminlte-laravel/blob/master/src/Providers/AdminLTETemplateServiceProvider.php

你可以通过改变 config/app.php 中 ServiceProviders 的顺序重写路由，因此如果你把这段代码：

```php
App\Providers\RouteServiceProvider::class
```

放到这段代码的后面：

```php
Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class
```

那么，你在 routes.php 中的路由将重写 adminlte-laravel 的默认路由。

你也可以在 routes.php 中手动安装路由。Adminlte-laravel使用的路由与Laravel 的 make:auth 命令一样，具体请查阅：

https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/routes.stub

因此你可以在 routes.php 中加入代码：

```php
Route::auth();

Route::get('/home', 'HomeController@index');
```

在 config/app.php 文件中禁用 AdminLTETemplateServiceProvider ( 考虑到 Adminte-laravel Facades 自定义命令可能会不可用).

想了解更多，请查看： https://github.com/acacha/adminlte-laravel/issues/69

## 开始；数据库创建、迁移；登录
一旦扩展包被安装，你要按照 Laravel 项目的常规步骤到 admin 页面登录：

* 创建一个数据库，我推荐使用 Laravel Homestead ()
* 创建/检查 .env 文件并配置数据库访问 (数据库名称、密码等)
* 执行迁移命令：php artisan migrate
* 注册一个用户并登录

## AdminLTE
AdminLTE 是一个 Abdullah Almsaeed 提供的基于 Bootstrap 3.x 免费的 Premium 版管理员控制面板主题，具体请查看：

https://github.com/almasaeed2010/AdminLTE

## Avatar/Gravatar
Adminlte-laravel 可使用工具包 creativeorange/gravatar (https://github.com/creativeorange/gravatar)，支持全球公认头像 (http://gravatar.com)

# Artisan 命令

## make:view
此命令可在 **resources/views** 目录中生成一个默认使用 adminlte 布局的页面

```bash
php artisan make:view about
```

## make:menu
此命令可在 **config/menu.php** 文件中添加一个菜单入口：

```bash
php artisan make:menu link menuname
```

例如:

```bash
php artisan make:menu /contact
```

## make:route
此命令可向路由文件添加路由：

```bash
php artisan make:route linkname
```

比如你可以在 **routes_web.php_**_ 文件中添加一个 _**about** 的URI，命令如下：

```bash
php artisan make:route about
```

此命令可以将这个入口添加到 routes/web.php

你可以是使用 **type** 选项创建3种类型的路由：

* **regular**: routes using a clousure with a simple return view command. This is the default one
* **regular**: 使用一个简单返回视图的命令的路由，这是默认类型

* **controller**: routes using a controller.
* **controller**: 使用控制器的路由

* **resource**: routes using a resource controller.
* **resource**: 使用资源控制器的路由

例如:

```bash
php artisan make:route about --type=controller
```

将增加:

```php
Route::get('about', 'AboutController@index');
```

到 **routes/web.php** 文件，你可以选择一个控制器的名字和方法，如下:

```bash
php artisan make:route about MyController@method --type=controller
```

如果你想创建一个资源控制器：

```bash
php artisan make:route about --type=resource
```

将增加:

```php
Route::resource('about', 'About@index');
```

到 **routes/web.php** 文件

你可以使用 **method** 选项，创建一个其他 HTTP 方法的路由：

```bash
php artisan make:route save --method=post
```

你也可以使用 **api** 选项，为 api 添加一个路由：

```bash
php artisan make:route save --api
```

执行上面的命令后，路由将添加到 **routes/api.php**

最后使用 **-a** 选项，在路由创建后添加 actions

```bash
php artisan make:route about -a
```

最后是命令创建一个名字为 **about.blade.php** 的 view：

```bash
php artisan make:route about -a --type=controller
```

创建一个名为 **AboutController** 的控制器，默认包含 index 方法的文件。

你可以参考的所有选项:

```bash
php artisan make:route --help
```

## adminlte:publish | adminlte-laravel:publish
此命令在使用 [acacha/llum](https://github.com/acacha/llum) 安装的时候已执行，但你也可以手动执行：

```bash
php artisan adminlte:publish
```

发布工具包中所有必要的文件到 Laravel 项目。

## adminlte:sidebar | adminlte-laravel:sidebar
仅发布工具包中允许自定义的侧边栏到 Laravel 项目

```bash
php artisan adminlte:sidebar
```

提示：在你执行 **adminlte-laravel install** 命令时，侧边栏就已经发布了

## adminlte:menu | adminlte-laravel:menu
使用 [spatie/laravel-menu](https://github.com/spatie/laravel-menu) 替换侧边栏

```bash
php artisan adminlte:menu
```
此命令会在安装 spatie_laravel-menu 工具包时，在 _**_config_menu.php** 创建一个默认菜单

**_重要_**: Spatie Laravel Menu 必须在 PHP 7.0 及以上版本才能工作

## adminlte-laravel:admin | adminlte:admin
执行 make:adminUserSeeder artisan 命令（请看下一部分）执行seed，此命令会增加一个默认的 admin 用户到到数据库

```bash
php artisan adminlte:admin
File /home/sergi/Code/AdminLTE/acacha/adminlte-laravel_test/database/seeds/AdminUserSeeder.php created
User Sergi Tur Badenas(sergiturbadenas@gmail.com) with the environemnt password (env var ADMIN_PWD) created succesfully!
```

此命令会使用（是否存在）环境变量（.env 文件）中的 ADMIN_USER、ADMIN_EMAIL、ADMIN_PWD。如果这些环境变量不存在，将会到用户 git 的配置文件(~/.gitconfig)中读取。如果仍无法获取信息，将会默认使用用户： Admin (admin@example.com) 密码：123456 来生成用户

### make:adminUserSeeder
创建一个新的 seed 向数据库增加一个 admin 用户：

```bash
php artisan make:adminUserSeeder
File /home/sergi/Code/AdminLTE/acacha/adminlte-laravel_test/database/seeds/AdminUserSeeder.php created
```

# 使用 acacha/laravel-social 增加 SNS 第三方登录
使用 [acacha/laravel-social](https://github.com/acacha/laravel-social) 工具包为 Laravel Adminlte 增加 SNS 第三方登录支持，在项目根目录执行：

```bash
adminlte-laravel social
```
根据向导配置你的 SNS providers Oauth 数据吧！更多信息：https://github.com/acacha/laravel-social

## 如何移除 SNS 第三方登录?
在文件 `resources/views/auth/login.blade.php` 和 `register.blade.php`
中删除

```php
@include('auth.partials.social_login')
```

# Roadmap

* 添加 email html 模版
* 添加面包屑: https://github.com/davejamesmiller/laravel-breadcrumbs

## 文档 TODO

* Gulp file provided to compile Boostrap and AdminLTE less files
* 部分页面 (html header, content header, footer, etc.) 更容易被复用

## Packagist
https://packagist.org/packages/acacha/admin-lte-template-laravel

## 更多信息
http://acacha.org/mediawiki/AdminLTE#adminlte-laravel

## 测试
有两种测试方法 Feature_Unit 测试和 Browser 测试，执行 Feature_Unit 测试：

```
./vendor/bin/phpunit
```

在新建的 acacha-admintle Laravel 项目中，Laravel 已安装了测试工具包，你也可以使用 Laravel Dusk 进行 Browser tests：

```
php artisan dusk:install
touch database/testing.database.sqlite
php artisan serve --env=dusk.local &
php artisan dusk
```

你也可以在不安装的情况下在沙盒中进行测试，运行脚本：

```bash
./test.sh
```

## 本地化
所有的字符串本地化都可以使用 Laravel localization 支持：https://laravel.com/docs/master/localization

在 config/app.php 文件中，你可以更改地区以更改语言。你只能使用 adminlte_lang 标签安装本地化文件：

```bash
php artisan vendor:publish --tag=adminlte_lang --force
```

下列语言被默认支持：英语，加泰罗尼亚语，西班牙语和巴西葡萄牙语。 如果您愿意，请随时向其他语言提交一个新的 pull request。

## 故障排除

### MAC OS 上的 GNU sed
Acacha llum 需要 GNU sed 来工作， 因此请替换将 BSD sed 为 GNU sed:

```bash
brew install gnu-sed --with-default-names
```

查看你的 sed 版本:

```bash
man sed
```

sed GNU 版本路径是:

```bash
$ which sed
/usr/local/bin/sed
```

替换默认的 BSD sed 路径( MAC OS 默认安装):

```bash
/usr/bin/sed
```

更多信息请查阅： https://github.com/acacha/adminlte-laravel/issues/58

## 如何使用用户名代替邮箱登录
执行命令:

```
php artisan adminlte:username
```

即可使用用户名代替邮箱登录

提示：当用户使用用户名进行登录时，如果登录失败，系统会尝试开启邮箱登录，因此也可以使用邮箱登录。

如果想恢复邮箱登录请移除 **config/auth.php** 文件中的 **field** 选项

```bash
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\User::class,
        'field' => 'username' // Adminlte laravel. Valid values: 'email' or 'username'
    ],
```

提示：数据库迁移时必须添加 username 字段到 users 表中
```bash
composer require doctrine/dbal
```

### 用户名注册默认域
可选项：你可以定义一个默认的用户名登录域，添加域选项：

```php
'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
    'domain' => 'defaultdomain.com',
],
```

到 **config/auth.php** 文件中。如果一个用户试图无域登录时，默认的域将被追加上。

你用上例的方式登录后：

```
sergiturbadenas
```

system/javascript 将替换为：

```
sergiturbadenas@defaultdomain.com
```

# Vue
Laravel adminlte 工具包默认发布 Laravel translations 到 Javascript/Vue.js 中，在 HTML header 下列脚本：
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

此脚本位于部分 blade 文件中 (vendor_acacha_admin-lte-template-laravel_resources_views_layouts_partials/htmlheader.blade.php)

全局变量 window.trans 包含全部的 Laravel translations，在任何 Javascript 文件中都可以被使用。

因此在 **resources_assets_js/bootstrap.js** 文件中的代码部分

```
Vue.prototype.trans = (key) => {
    return _.get(window.trans, key, key);
};
```

允许直接在 vue 模版中直接使用 trans 方法

```
{{ trans('auth.failed') }}
```

你也可以在 Vue组件中使用：

```
this.trans('auth.failed')
```

Laravel Adminlte messages 可使用前缀 **adminlte_lang_message** ：

```
{{ trans('adminlte_lang_message.username') }}
```

请随意删除/调整此文件以满足您的需要。

## Change log
更多最近更新的信息，请查阅：[CHANGELOG](CHANGELOG.md)

## 测试

```bash
$ composer test
```

## 贡献
请点击 [CONTRIBUTING](CONTRIBUTING.md) 和 [CONDUCT](CONDUCT.md) 查看详情。

## 安全
如果你发现任何安全相关的问题，请发送邮件至 sergiturbadenas@gmail.com 而不是使用 issue tracker。

## Credits

* [Sergi Tur Badenas](https://github.com/acacha)
* [All Contributors](../../contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## See also
https://github.com/acacha/adminlte-laravel-installer
