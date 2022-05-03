<?php

namespace App\Controllers;

use Lefuturiste\LocalStorage\LocalStorage;
use Slim\Http\Response;

class CacheController extends Controller {

    public function clear($_, ResponseInterface $response, LocalStorage $localStorage) {
        $localStorage->clear();
        $localStorage->save();
        
        return $response->withJson([
            'success' => true
        ]);
    }
    
}
