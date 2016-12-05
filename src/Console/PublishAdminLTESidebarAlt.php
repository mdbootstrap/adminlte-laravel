<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;

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
