<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Http\Request;

class AdminMiddleware
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
//     	$user = User::where ( 'api_token', $request->header('api_token') )->get ()->count ();
    	if($this->chackAdmin($request)){
    		return $next($request);
    	}
    	
    }
    public function chackAdmin(Request $request){
    	$user = User::where ( 'api_token', $request->header('api_token'))
    	->where('role','9')
    	->get()->count ();
    	if($user != 0){
    		return true;
    	}else{
    		return false;
    	}
    }
}
