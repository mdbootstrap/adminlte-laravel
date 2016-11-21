<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class PublishAdminLTE.
 */
class PublishAdminLTE extends Command
{
    use Installable;
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'adminlte-laravel:publish {--f|force : Force overwrite of files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Acacha AdminLTE Template files into laravel project';

    /**
     * Force overwrite of files.
     *
     * @var bool
     */
    protected $force = false;

    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->processOptions();
        $this->publishHomeController();
        $this->changeRegisterController();
        $this->changeLoginController();
        $this->changeForgotPasswordController();
        $this->changeResetPasswordController();
        $this->publishPublicAssets();
        $this->publishViews();
        $this->publishResourceAssets();
        $this->publishTests();
        $this->publishLanguages();
        $this->publishGravatar();
    }

    /**
     * Install Home Controller.
     */
    private function publishHomeController()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::homeController());
    }

    /**
     * Change Auth Register controller.
     */
    private function changeRegisterController()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::registerController());
    }

    /**
     * Change Auth Login controller.
     */
    private function changeLoginController()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::loginController());
    }

    /**
     * Change Auth Forgot Password controller.
     */
    private function changeForgotPasswordController()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::forgotPasswordController());
    }

    /**
     * Change Auth Reset Password controller.
     */
    private function changeResetPasswordController()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::resetPasswordController());
    }

    /**
     * Install public assets.
     */
    private function publishPublicAssets()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::publicAssets());
    }

    /**
     * Install views.
     */
    private function publishViews()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::viewsToOverwrite());
    }

    /**
     * Install resource assets.
     */
    private function publishResourceAssets()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::resourceAssets());
    }

    /**
     * Install resource assets.
     */
    private function publishTests()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::tests());
    }

    /**
     * Install language assets.
     */
    private function publishLanguages()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::languages());
    }

    /**
     * Install gravatar config file.
     */
    private function publishGravatar()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::gravatar());
    }

    /**
     * Process options before running command.
     */
    private function processOptions()
    {
        $this->force = $this->option('force');
    }
}
