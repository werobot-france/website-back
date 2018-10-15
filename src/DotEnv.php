<?php

namespace App;

class DotEnv
{
    public static function load(): void
    {
        if (file_exists(dirname(__DIR__) . '/.env')) {
            $dotEnv = new \Dotenv\Dotenv(dirname(__DIR__));
            $dotEnv->load();
        }
    }
}