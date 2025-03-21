<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LocalServiceProvider extends ServiceProvider
{
    protected array $providers = [
        'Barryvdh\Debugbar\ServiceProvider',
        'Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider',
    ];

    protected array $aliases = [
        'Debugbar' => 'Barryvdh\Debugbar\Facade'
    ];

    public function register(): void
    {
        if ($this->app->isLocal()) {
            foreach ($this->providers as $provider) {
                $this->app->register($provider);
            }
            if (!empty($this->aliases)) {
                foreach ($this->aliases as $alias => $facade) {
                    $this->app->alias($alias, $facade);
                }
            }
        }
    }
}
