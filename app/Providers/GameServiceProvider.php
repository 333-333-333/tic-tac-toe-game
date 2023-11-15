<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Models\Game;

class GameServiceProvider extends ServiceProvider {


    public function register(): void {
        $this->app->singleton('game', function () {
            return Cache::remember('game_instance', now()->addMinutes(60), function () {
                return new Game();
            });
        });  
    }

    public function boot(): void {

    }


}