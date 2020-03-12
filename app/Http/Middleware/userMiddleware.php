<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;

class userMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param \Closure $next        	
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$_user = User::where ( 'api_token', $request->header ( 'api_token' ) )->get ()->count ();
		if ($_user != 0) {
			$buser = User::where ( 'api_token', $request->header ( 'api_token' ) )->where ( 'email', '!=', 'kald201099@gmail.com' )->get () -> count ();
			if ($buser != 0) {
				$user = User::where ( 'api_token', $request->header ( 'api_token' ) )->where ( 'email', '!=', 'kald201099@gmail.com' )->get ();
				$updated_at = new Carbon ( $user [0]->updated_at );
				$now = Carbon::now ();
				$difference = $updated_at->diff ( $now )->days;
				if ($difference >= 30) {
					$user [0]->role = Role::SUBSCRIBER;
					$user [0]->save ();
				}
			}
			
			return $next ( $request );
		} else {
			// return $request->header('api_token');
			// return $next($request);
		}
	}
}
