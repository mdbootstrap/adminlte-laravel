<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Acacha\AdminLTETemplateLaravel\Exceptions\SpatieMenuAlreadyExists;
use Acacha\AdminLTETemplateLaravel\Facades\AdminLTE;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Spatie\Menu\Laravel\MenuServiceProvider;

/**
 * Class AdminLTEMenuAlt.
 */
class AdminLTEMenuAlt extends AdminLTEMenu
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'adminlte:menu {--f|force : Force overwrite of files}';
}
