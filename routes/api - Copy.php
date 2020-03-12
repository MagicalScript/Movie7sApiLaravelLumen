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

// $app->get('/', 'APIController@sayhello');
$app->get ( '/mov/{page}', 'APIController@getMovies' );
$app->get ( '/tv/{page}&{type}', 'APIController@getTVs' );

$app->get ( '/ani/{page}&{type}', 'APIController@getAnimeTv' ); // canceled
$app->get ( '/sea/{tv}&{page}', 'APIController@getSeasonByTV' );
$app->get ( '/epi/{Season}&{page}', 'APIController@getEpisodeBySeason' );
$app->get ( '/aniEpi/{Season}&{page}', 'APIController@getAnimeBySeason' ); // canceled
$app->get ( '/link/{tmdb}&{page}', 'APIController@getServerByTmdb' );
$app->get ( '/getCategory/', 'APIController@getCategory' );
$app->get ( '/getComment/{tmdb}', 'APIController@getComment' );
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
$app->post ( '/register', 'Controller@register' );
$app->get ( '/user/{id}', [ 
		'middleware' => 'auth',
		'uses' => 'UserController@get_user' 
] );
	
	
