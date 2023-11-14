<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Game;

class GameServiceProvider extends ServiceProvider {


    public function register(): void {
        $this->app->singleton(Game::class, function($app) {
            return new Game();
        });        
    }

    public function boot(): void {

    }


}