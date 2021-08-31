<?php
/*
|--------------------------------------------------------------------------
| Debug mode
|--------------------------------------------------------------------------
|
| If debug mode is enabled, we can enable tracy debugger
|
*/
/*
|--------------------------------------------------------------------------
| Debug and die function
|--------------------------------------------------------------------------
|
| Many time you need a simple function for debugging your application.
| This function will show to you the value parsed in html with Tracy Debugger library.
| This function is ignored is debug mode is not enabled
|
*/
function di($value = 'Die and Debug ! ;)')
{
	if (getenv('APP_DEBUG')){
		Tracy\Debugger::dump($value);
		die();
	}
};

function debug($value = 'Die and Debug ! ;)')
{
    return call_user_func_array("di", func_get_args());
}

function d($value = 'Die and Debug ! ;)')
{
    return call_user_func_array("di", func_get_args());
}

/*
|--------------------------------------------------------------------------
| Get environment var and default is is null
|--------------------------------------------------------------------------
*/
function envOrDefault($key, $default = NULL){
  if (getenv($key) == false || getenv($key) == '' || empty(getenv($key))){
    return $default;
  } else {
    return getenv($key);
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
