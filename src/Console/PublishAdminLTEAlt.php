<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;

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
