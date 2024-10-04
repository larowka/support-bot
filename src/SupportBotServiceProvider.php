<?php

namespace Larowka\SupportBot;

use Illuminate\Support\ServiceProvider;

class SupportBotServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/support-bot.php', 'support-bot'
        );

//        $this->commands([
//            ActionMakeCommand::class
//        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ]);

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'support-bot');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/support-bot.php' => config_path('support-bot.php'),
            ], 'support-bot-config');

            $this->publishes([
                __DIR__.'/../lang' => lang_path(),
            ], 'support-bot-lang');
        }
    }
}