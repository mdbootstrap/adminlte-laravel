<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager;

/**
 * Class PublishAdminLTE.
 */
class PublishAdminLTEAlt extends PublishAdminLTE
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'adminlte:publish {--f|force : Force overwrite of files}';

}
