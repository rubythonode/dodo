<?php
namespace App\Traits;

trait Singleton
{
    /**
     * @var mixed
     */
    private static $instance; //The single instance

    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }
}
