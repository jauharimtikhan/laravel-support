<?php

namespace Jauhar\Support\Providers;

use Illuminate\Support\ServiceProvider;
use Jauhar\Support\JoeSupport;
use Illuminate\Contracts\Routing\ResponseFactory;

class JoeSupportProvider extends ServiceProvider
{
  public function register()
  {
    // Bind library to container
    $this->app->singleton('joe-support', function ($app) {
      return new JoeSupport(
        $app->make('db'),
        $app->make('request'),
        $app->make(ResponseFactory::class)
      );
    });
  }

  public function boot()
  {
    // Publish config file
  }
}
