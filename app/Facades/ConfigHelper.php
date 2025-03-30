<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get(string $key, mixed $default = null)
 * @method static void set(string $key, mixed $value)
 * @method static void clearCache()
 * @method static array getByPrefix(string $prefix)
 * @method static \Illuminate\Database\Eloquent\Collection getAll()
 *
 * @see \App\Helpers\ConfigHelper
 */
class ConfigHelper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'config-helper';
    }
}
