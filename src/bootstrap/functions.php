<?php

use Carbon\Carbon;

function dd(...$args)
{
    foreach ($args as $arg) {
        dump($arg);
    }
    die();
}

function envOrDefault($key, $default = NULL){
  if (!isset($_ENV[$key])){
    return $default;
  } else {
    return $_ENV[$key];
  }
}

function getEnvBoolean($key, $default = false) {
  return envOrDefault($key, $default) === 'true' || envOrDefault($key, $default) === '1';
}

function getAllowedOrigins($default = []) {
  $additionnalsOriginsRaw = envOrDefault('CORS_ALLOWED_ORIGINS');
  $additionnals = [];
  if ($additionnalsOriginsRaw != '') {
    $additionnals = explode(',', $additionnalsOriginsRaw);
  }

  return array_merge($default, $additionnals);
}

function parseDateTime(string $fromDatabaseDriver): string {
    return Carbon::createFromTimeString($fromDatabaseDriver)->toDateTimeString();
}
