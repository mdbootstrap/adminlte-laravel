<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager;

/**
 * Class PublishAdminLTESidebarAlt.
 */
class PublishAdminLTESidebarAlt extends PublishAdminLTESidebar
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'adminlte:sidebar {--f|force : Force overwrite of files}';

}
