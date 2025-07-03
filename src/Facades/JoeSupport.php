<?php

namespace Jauhar\Support\Facades;

use Illuminate\Support\Facades\Facade;

class JoeSupport extends Facade
{
  protected static function getFacadeAccessor()
  {
    return 'joe-support'; // Harus sama dengan nama di Service Provider
  }
}
