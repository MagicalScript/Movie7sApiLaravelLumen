<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It is a breeze. Simply tell Lumen the URIs it should respond to
 * | and give it the Closure to call when that URI is requested.
 * |
 */
$api = $app->make ( Dingo\Api\Routing\Router::class );

$api->version ( 'v1', function ($api) {
	$api->post ( '/auth/login', [ 
			'as' => 'api.auth.login',
			'uses' => 'App\Http\Controllers\Auth\AuthController@postLogin' 
	] );
	
	$api->group ( [ 
			'middleware' => 'api.auth' 
	], function ($api) {
		$api->get ( '/', [ 
				'uses' => 'App\Http\Controllers\APIController@getIndex',
				'as' => 'api.index' 
		] );
		$api->get ( '/auth/user', [ 
				'uses' => 'App\Http\Controllers\Auth\AuthController@getUser',
				'as' => 'api.auth.user' 
		] );
		$api->patch ( '/auth/refresh', [ 
				'uses' => 'App\Http\Controllers\Auth\AuthController@patchRefresh',
				'as' => 'api.auth.refresh' 
		] );
		$api->delete ( '/auth/invalidate', [ 
				'uses' => 'App\Http\Controllers\Auth\AuthController@deleteInvalidate',
				'as' => 'api.auth.invalidate' 
		] );
	} );
} );

// $app->get ('/', 'APIController@sayhellow');
$app->get ( '/mov/{page}', 'APIController@getMovies' );
$app->get ( '/movByCate/{page}&{Cate}', 'APIController@getMoviesByCate' );
$app->get ( '/tv/{page}&{Cate}', 'APIController@getTVsByCat' );
$app->get ( '/tv/{page}', 'APIController@getTVs' );

$app->get ('/news/{page}','APIController@getnews');
$app->get ('/newseasons/{page}&{cate}','APIController@getSeasonsByCategory');
$app->get ('/info/{tmdb}','APIController@getInfo');
$app->get ( '/ani/{page}&{type}', 'APIController@getAnimeTv' ); // canceled
$app->get ( '/sea/{tv}&{page}', 'APIController@getSeasonByTV' );
$app->get ( '/epi/{Season}&{page}', 'APIController@getEpisodeBySeason' );
$app->get ( '/aniEpi/{Season}&{page}', 'APIController@getAnimeBySeason' ); // canceled
$app->get ( '/link/{tmdb}&{page}', 'APIController@getServerByTmdb' );
$app->get ( '/getCategory/', 'APIController@getCategory' );
$app->get ( '/getComment/{tmdb}&{page}', 'APIController@getComment' );
$app->get ( '/showtimes/{page}', 'APIController@getShowTime' );
$app->get ( '/showtimesTmdb/{tmdb}&{page}', 'APIController@getShowTimeByTmdb' );
$app->get ( '/showtimes/{page}', 'APIController@getShowTime' );
$app->get ( '/showtimesTmdb/{tmdb}&{page}', 'APIController@getShowTimeByTmdb' );

$app->post ( '/sayhellow', 'APIController@sayhellow' ); // test request
$app->post ( '/addComment', 'APIController@addComment' );
$app->post ( '/addCategory', 'APIController@addCategory' );
$app->post ( '/addEpisode', 'APIController@addEpisode' );
$app->post ( '/addInfo', 'APIController@addInfo' );
$app->post ( '/addMovies', 'APIController@addMovies' );
$app->post ( '/addSeason', 'APIController@addSeason' );
$app->post ( '/addServer', 'APIController@addServer' );
$app->post ( '/addShowTime', 'APIController@addShowTime' );
$app->post ( '/addTvShow', 'APIController@addTvShow' );
$app->post ( '/updateTvShow', 'APIController@updateTvShow' );
$app->post ( '/updateMovies', 'APIController@updateMovies' );

$app->delete ( '/deleteserver/{id}', 'APIController@deleteServer' );
$app->delete ( '/deletetime/{id}', 'APIController@deleteTime' );

$app->delete ( '/deleteComment/{tmdb}', 'APIController@deleteComment' );
$app->delete ( '/deleteCategory/{name}', 'APIController@deleteCategory' );
$app->delete ( '/deleteEpisode/{tmdb}', 'APIController@deleteEpisode' );
$app->delete ( '/deleteInfos/{tmdb}', 'APIController@deleteInfos' );
$app->delete ( '/deleteMovies/{tmdb}', 'APIController@deleteMovies' );
$app->delete ( '/deleteSeason/{tmdb}', 'APIController@deleteSeason' );
$app->delete ( '/deleteTv/{tmdb}', 'APIController@deleteTv' );

$app->get ( '/', function () use ($app) {
	$res ['success'] = true;
	$res ['result'] = 'Hello world with lumen';
	return response ( $res );
} );

$app->post ( '/login', 'LoginController@index' );
$app->post ( '/register', 'UserController@register' );
// $app->get ( '/user/{id}', [
// 		'middleware' => 'login',
// 		'uses' => 'UserController@get_user'
// ] );
	
//                                                           ADMIN roots
// $app->post('login', 'AuthController@login');
// $app->post('signup', 'AuthController@signup');
// $app->post('forgot-password', 'AuthController@forgotPassword');
// $app->post('password/email', 'PasswordController@postEmail');
// $app->post('password/reset', 'PasswordController@postReset');
$app->get('/userslist/{page}', 'AdminUserController@index');
$app->get('users/{id}', 'AdminUserController@get');
$app->patch('users/{id}', 'AdminUserController@update');
$app->delete('users/{id}', 'AdminUserController@delete');

$app->group(['middleware' => 'login'], function($app)  {
	/* Profile API */
// 	$app->get('me', 'UserController@getProfile');
// 	$app->post('me', 'UserController@saveProfile');
	//$app->get ( '/user/{id}', 'UserController@get_user' );
	//$app->get ('/', 'APIController@sayhello');
	$app->delete ( '/logOut', 'LoginController@logOut' );
	
	/* Admin API */
	$app->group(['middleware' => 'admin'], function($app) {
		/* Users API */
		
		//$app->get ('/', 'APIController@sayhello');
		//$app->get ('/', 'APIController@sayhello');
// 		$app->get('users', 'AdminUserController@index');
// 		$app->post('users', 'UserController@create');
//		$app->get('/users', 'AdminUserController@index');
//		$app->get('users/{id}', 'AdminUserController@get');
//		$app->patch('users/{id}', 'AdminUserController@update');
//		$app->delete('users/{id}', 'AdminUserController@delete');
	});
});
	
