<?php
namespace Deflopian\EducationTests;

use Illuminate\Support\ServiceProvider;

class EducationTestsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('education-tests.php'),
        ]);

        // Register commands
        $this->commands('command.education-tests.migration');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRoutes();

        $this->registerCommands();

        $this->mergeConfig();
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function registerCommands()
    {
        $this->app->singleton('command.education-tests.migration', function ($app) {
            return new MigrationCommand();
        });
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
    }

    /**
     * Merges user's and tests's configs.
     *
     * @return void
     */
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'education-tests'
        );
    }

    /**
     * Get the services provided.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.education-tests.migration'
        ];
    }
}
