<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spark:install {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Spark scaffolding into the application';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->installNpmPackageConfig();
        $this->installGulpFile();
        $this->installServiceProviders();
        $this->installMiddleware();
        $this->installRoutes();
        $this->installModels();
        $this->installMigrations();
        $this->installViews();
        $this->updateAuthConfig();
        $this->installJavaScript();
        $this->installSass();
        $this->installEnvironmentVariables();
        $this->installTerms();
        $this->call('key:generate');

        $this->table(
            ['Task', 'Status'],
            [
                ['Installing Spark Features', '<info>✔</info>'],
            ]
        );

        if ($this->option('force') || $this->confirm('Would you like to run your database migrations?', 'yes')) {
            (new Process('php artisan migrate', base_path()))->setTimeout(null)->run();
        }

        if ($this->option('force') || $this->confirm('Would you like to install your NPM dependencies?', 'yes')) {
            (new Process('npm install', base_path()))->setTimeout(null)->run();
        }

        if ($this->option('force') || $this->confirm('Would you like to run Gulp?', 'yes')) {
            (new Process('gulp', base_path()))->setTimeout(null)->run();
        }

        $this->displayPostInstallationNotes();
    }

    /**
     * Install the "package.json" file for the project.
     *
     * @return void
     */
    protected function installNpmPackageConfig()
    {
        copy(
            SPARK_PATH.'/resources/stubs/package.json',
            base_path('package.json')
        );
    }

    /**
     * Install the "gulpfile.json" file for the project.
     *
     * @return void
     */
    protected function installGulpFile()
    {
        copy(
            SPARK_PATH.'/resources/stubs/gulpfile.js',
            base_path('gulpfile.js')
        );
    }

    /**
     * Generate and install the application Spark service provider.
     *
     * @return void
     */
    protected function installServiceProviders()
    {
        copy(
            SPARK_PATH.'/resources/stubs/app/Providers/SparkServiceProvider.php',
            app_path('Providers/SparkServiceProvider.php')
        );

        copy(
            SPARK_PATH.'/resources/stubs/config/app.php',
            config_path('app.php')
        );
    }

    /**
     * Install the customized Spark middleware.
     *
     * @return void
     */
    protected function installMiddleware()
    {
        copy(
            SPARK_PATH.'/resources/stubs/app/Http/Middleware/Authenticate.php',
            app_path('Http/Middleware/Authenticate.php')
        );

        copy(
            SPARK_PATH.'/resources/stubs/app/Http/Middleware/VerifyCsrfToken.php',
            app_path('Http/Middleware/VerifyCsrfToken.php')
        );
    }

    /**
     * Install the routes for the application.
     *
     * @return void
     */
    protected function installRoutes()
    {
        copy(
            SPARK_PATH.'/resources/stubs/app/Http/routes.php',
            app_path('Http/routes.php')
        );
    }

    /**
     * Install the customized Spark models.
     *
     * @return void
     */
    protected function installModels()
    {
        copy(
            SPARK_PATH.'/resources/stubs/app/User.php',
            app_path('User.php')
        );

        copy(
            SPARK_PATH.'/resources/stubs/app/Team.php',
            app_path('Team.php')
        );
    }

    /**
     * Install the user migration file.
     *
     * @return void
     */
    protected function installMigrations()
    {
        copy(
            SPARK_PATH.'/resources/stubs/database/migrations/2014_10_12_000000_create_users_table.php',
            database_path('migrations/2014_10_12_000000_create_users_table.php')
        );

        usleep(1000);

        copy(
            SPARK_PATH.'/resources/stubs/database/migrations/2014_10_12_100000_create_subscriptions_table.php',
            database_path('migrations/'.date('Y_m_d_His').'_create_subscriptions_table.php')
        );

        usleep(1000);

        copy(
            SPARK_PATH.'/resources/stubs/database/migrations/2014_10_12_200000_create_teams_tables.php',
            database_path('migrations/'.date('Y_m_d_His').'_create_teams_tables.php')
        );
    }

    /**
     * Install the default views for the application.
     *
     * @return void
     */
    protected function installViews()
    {
        copy(
            SPARK_PATH.'/resources/views/home.blade.php',
            base_path('resources/views/home.blade.php')
        );
    }

    /**
     * Update the "auth" configuration file.
     *
     * @return void
     */
    protected function updateAuthConfig()
    {
        $path = config_path('auth.php');

        file_put_contents($path, str_replace(
            'emails.password', 'spark::emails.auth.password.email', file_get_contents($path)
        ));
    }

    /**
     * Install the default JavaScript file for the application.
     *
     * @return void
     */
    protected function installJavaScript()
    {
        if (! is_dir('resources/assets/js')) {
            mkdir(base_path('resources/assets/js'));
        }

        copy(
            SPARK_PATH.'/resources/stubs/resources/assets/js/app.js',
            base_path('resources/assets/js/app.js')
        );
    }

    /**
     * Install the default Sass file for the application.
     *
     * @return void
     */
    protected function installSass()
    {
        copy(
            SPARK_PATH.'/resources/stubs/resources/assets/sass/app.scss',
            base_path('resources/assets/sass/app.scss')
        );
    }

    /**
     * Install the environment variables for the application.
     *
     * @return void
     */
    protected function installEnvironmentVariables()
    {
        if (! file_exists(base_path('.env'))) {
            return;
        }

        $env = file_get_contents(base_path('.env'));

        if (str_contains($env, 'AUTHY_KEY=')) {
            return;
        }

        (new Filesystem)->append(
            base_path('.env'),
            PHP_EOL.'AUTHY_KEY='.PHP_EOL.PHP_EOL.
            'STRIPE_KEY='.PHP_EOL.
            'STRIPE_SECRET='.PHP_EOL
        );
    }

    /**
     * Install the "Terms Of Service" Markdown file.
     *
     * @return void
     */
    protected function installTerms()
    {
        file_put_contents(
            base_path('terms.md'), 'This page is generated from the `terms.md` file in your project root.'
        );
    }

    /**
     * Display the post-installation information to the user.
     *
     * @return void
     */
    protected function displayPostInstallationNotes()
    {
        $this->comment('Post Installation Notes:');

        $this->line(PHP_EOL.'     → Set <info>AUTHY_KEY</info>, <info>STRIPE_KEY</info>, & <info>STRIPE_SECRET</info> Environment Variables');
    }
}
