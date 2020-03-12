<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class UserController extends Controller {
	/**
	 * Register new user
	 *
	 * @param $request Request        	
	 */
// 	public function __construct(){
// 		$this->middleware('auth:api');
// 	}
	
	public function register(Request $request) {
		$this->validate ( $request, [ 
				'email' => 'required|email|unique:users',
				'password' => 'required' 
		] );
		
		$hasher = app ()->make ( 'hash' );
		$email = $request->input ( 'email' );
		$password = $hasher->make ( $request->input ( 'password' ) );
		$name = $request['name'];
		$user = User::create ( [ 
				'email' => $email,
				'password' => $password ,
				'role' =>  Role::SUBSCRIBER,
				'name' => $name,
		] );
		
		$res ['success'] = true;
		$res ['message'] = 'Success register!';
		$res ['data'] = $user;
		return response ( $res );
	}
	/**
	 * Get user by id
	 *
	 * URL /user/{id}
	 */
	
	public function get_user(Request $request, $id) {
		
		$user = User::where ( 'id', $id )->get ()->count ();
		if ($user != 0) {
			$res ['success'] = true;
			$res ['message'] = User::where ( 'id', $id )->get ();
			
			return response ( $res );
		} else {
			$res ['success'] = false;
			$res ['message'] = 'Cannot find user!';
			
			return response ( $res );
        }
    }
}