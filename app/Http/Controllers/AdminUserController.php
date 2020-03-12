<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Carbon\Carbon;

class AdminUserController extends Controller {
	
	// public function saveProfile(Request $request) {
	// $user = User:: where("email", "=", $email)->first();
	// if ($user) {
	// $user2 = User:: where("email", "=", $request->input('email'))->where("id", "!=", $user->id)->first();
	// if($user2) {
	// return response(['error' => 'Your email has already been registered.'], 422);
	// }
	// else {
	// $user->username = $request->input('username');
	// $user->email = $request->input('email');
	// if($user->save()){
	// $token = $jwt->createToken($user);
	// return response(['token' => $token->token(), 'user' => $user]);
	// } else {
	// return response(['error' => 'Failed to save profile'], 404);
	// }
	// }
	// } else {
	// return response(['error' => 'User not found'], 404);
	// }
	// }
	public function index($page) {
		$page = $page * 50;
		$users = User::where('email','!=','kald201099@gmail.com')
		->take ( 50 )->skip ( $page )
		->get ();
		
// 		User::select(array(
// 				'*',
// 				"DATEDIFF(date_from,date_to)AS Days")
// 		))->where('email','!=','dqz@mail.com')
// 		->get ();
		
				return response ( $users);
	}
	
	
	public function get(Request $request,$id) {
		$user = User::query ()->find ( $id );
		$updated_at= new Carbon($user->updated_at);
		$now = Carbon::now();
		$difference = ($updated_at->diff($now)->days < 1)
		? 'today'
				: $updated_at->diffForHumans($now);
		if ($user) {
			return response ( $difference);
		} else {
			return response ( [ 
					'error' => 'Not found user for ID ' . $id 
			], 404 );
		}
		
// 		$user = User::where ( 'api_token', $request->header('api_token') )
// 		->where('email','!=','dqz@mail.com')->get();
// // 		$updated_at = new Carbon($user->updated_at);
// // 		$now = Carbon::now();
// // 		$difference = $updated_at->diff($now);
// // 		if ($difference >= 2) {
// // 			$user->role = Role::SUBSCRIBER;
// // 			$user->save ();
// // 		}
// 		return $user[0];
	}
	public function update(Request $request, $id) {
		$user = User::query ()->find ( $id );
		if ($user) {
			$user2 = User::where ( "email", "=", $request->input ( 'email' ) )->where ( "id", "!=", $id )->first ();
			if ($user2) {
				return response ( [ 
						'error' => 'User email has already been registered.' 
				], 422 );
			} else {
				$role = $request->input ( 'role' ) ? $request->input ( 'role' ) : Role::SUBSCRIBER;
				$user->role = $role;
				$user->save ();
				
				return response ( $user );
			}
		} else {
			return response ( [ 
					'error' => 'Not found user for ID ' . $id 
			], 404 );
		}
	}
	public function delete($id) {
		$user = User::query ()->find ( $id )->get ()->count ();
		if ($user != 0) {
			User::query ()->findOrFail ( $id )->delete ();
			return response ( [ 
					'id' => $id 
			] );
		} else {
			return response ( [ 
					'error' => 'Not found user for ID ' . $id 
			], 404 );
		}
	}
}