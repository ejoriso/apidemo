<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
use Artisan;
use Config;
class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $flag = false;
        if(!$request->input('name')||!$request->input('key'))
            $flag = false;
        else
            if($request->input('name')==Config::get('app.admu')&&$request->input('key')==Config::get('app.admp'))
                $flag = true;

        if(!$flag){
            if($request->ajax())
                return response()->json(['status' => 401, 'message' => "No posee los privilegios suficientes para realizar esta acción", "redirect" => '']);
            else
                return response()->view('errors.401');
        }
        else
            return $next($request);
        
    }
}