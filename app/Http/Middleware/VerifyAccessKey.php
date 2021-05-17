<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use Config;

class VerifyAccessKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
        if (strpos($request->server()['REQUEST_URI'],'seguimiento')!=false){
            return $next($request);
        }*/
        //cuando en la ruta sea para log-viewer no preguntara si trae en el header el token
        if(strpos($request->server()['REQUEST_URI'],'log-viewer')===false){
            // Obtenemos el api-key que el usuario envia
            $key = Request::header('tk');

            // Si coincide con el valor almacenado en la aplicacion
            // la aplicacion se sigue ejecutando
            if ($key == Config::get('app.token')) {
                return $next($request);
            } else {
                // Si falla devolvemos el mensaje de error
                return response()->json(['status' => 401, 'message' => 'unauthorized' ], 401);
            }
        }
        else{
            return $next($request);
        }

    }
}
