<?php

namespace Kreatinc\Bot;

use Illuminate\Support\ServiceProvider;

class BotServiceProvider extends ServiceProvider
{
     /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //load routes
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        //load migrations
        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        //load ressources views
        //$this->loadViewsFrom(__DIR__.'/../ressources');

        require_once(__DIR__.'/Libraries/helpers.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //load bot configuration from config folder
        $this->mergeConfigFrom(__DIR__.'/../config/bot.php', 'bot');
        $this->offerPublishing();
        $this->registerCommands();
    }

    /**
     * Setup the resource publishing groups for Bot.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/bot.php' => config_path('bot.php'),
            ], 'bot-config');
        }
    }

    /**
     * Register the Bot Artisan commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\InstallCommand::class,
                Console\PartialLeadsCommand::class,
            ]);
        }
    }
}
