<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Episode;
use App\Infos;
use App\Movies;
use App\Season;
use App\Server;
use App\Showtimes;
use App\Tv;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Application;

class APIController extends Controller {
	/**
	 * Get root url.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex(Application $app) {
		return new JsonResponse ( [ 
				'message' => $app->version () 
		] );
	}
	public function addServer(Request $request) {
		$response = array ();
		// return $request;
		$parameters = $request;
		try {
			$createdView = Server::create ( array (
					'Title' => $parameters ['name'],
					'url' => $parameters ['url'],
					'tmdb' => $parameters ['tmdb'],
					'type' => $parameters ['type']
			) );
		} catch ( Exception $e ) {
			return response ()->json ( $e->all () );
		}
	}
	
	public function addTvShow(Request $parameters) {
		$find = Tv::where ( 'tmdb', $parameters['tmdb'])->get ()->count ();
		if ($find == 0) {
			$this.deleteTv($parameters['tmdb']);
		}
		
		Tv::create ( array (
				'title' => $parameters['title'],
				'tmdb' => $parameters['tmdb'],
				'category' => $parameters['category'],
		) );
	}
	public function addSeason(Request $parameters) {
		$find = Season::where ( 'tmdb', $parameters['tmdb'])->get ()->count ();
		if ($find == 0) {
			Season::create ( array (
					'title' => $parameters['title'],
					'tmdb' => $parameters['tmdb'],
					'num' => $parameters['num'],
					'tv' => $parameters['tv']
			) );
		}
	}
	public function addEpisode(Request $parameters) {
		$find = Episode::where ( 'tmdb', $parameters['tmdb'])->get ()->count ();
		if ($find == 0) {
			Episode::create ( array (
					'title' => $parameters['title'],
					'tmdb' => $parameters['tmdb'],
					'num' => $parameters['num'],
					'metadata' => $parameters['metadata'],
					'season' => $parameters['season']
			) );
		}
	}
	public function addMovies(Request $parameters) {
		$find = Movies::where ( 'tmdb', $parameters['tmdb'])->get ()->count ();
		if ($find == 0) {
			Movies::create ( array (
					'title' => $parameters['title'],
					'tmdb' => $parameters['tmdb'],
					'metadata' => $parameters['metadata'],
					'category' => $parameters['category'],
			) );
		}
	}
	public function addCategory(Request $parameters) {
		header('Access-Control-Allow-Origin: *');
		$find = Category::where ('name', $parameters['name'])->get ()->count ();
		if ($find == 0) {
			Category::create ( array (
					'name' => $parameters['name'],
			) );
		}
	}
	public function addComment(Request $parameters) {
		Comment::create ( array (
				'user' => $parameters['user'],
				'tmdb' => $parameters['tmdb'],
				'comment' => $parameters['comment'],
				'approved' => 'no',
		) );
	}
	public function addInfo(Request $parameters) {
		$find = Infos::where ('tmdb', $parameters['tmdb'])->get ()->count ();
		if ($find != 0) {
			$this->deleteInfos($parameters['tmdb']) ;
		}
		Infos::create ( array (
				'tmdb' => $parameters['tmdb'], 
				'overview' => $parameters['overview'],
				'name' => $parameters['name'],
				'first_air_date' => $parameters['first_air_date'],
				'genre_ids' => $parameters['genre_ids'],
				'original_language' => $parameters['original_language'],
				'backdrop_path' => $parameters['backdrop_path'],
				'origin_country' => $parameters['origin_country'],
				'poster_path' => $parameters['poster_path']
		) );
	}
	public function getMovies($page) {
		// $page = $request['page'];
		$page = $page * 10;
		$data = DB::table ( 'infos' )->take ( 10 )->skip ( $page )
		->rightjoin ( 'movies', 'infos.tmdb', '=', 'movies.tmdb' )
		->get ();
		// Season::where('',$tv)->take(10)->skip($page)->get();
		return $data;
	}
	public function getMoviesByCate($page,$Cate) {
		// $page = $request['page'];
		$page = $page * 10;
		$data = DB::table ( 'movies' )->take ( 10 )->skip ( $page )
		->join('category','category.id','=','movies.category')
		->where ( 'category', $Cate)
		->get ();
		// Season::where('',$tv)->take(10)->skip($page)->get();
		return $data;
	}
	public function getTVsByCat($page, $Cate) {
		$page = $page * 10;
		$data = DB::table ( 'tv' )->where ( 'category', $Cate)->take ( 10 )->skip ( $page )->get ();
		// Season::where('',$type)->take(10)->skip($page)->get();
		return $data;
	}
	public function getTVs($page) {
		$page = $page * 10;
		$data = DB::table ( 'tv' )->take ( 10 )->skip ( $page )->get ();
		// Season::where('',$type)->take(10)->skip($page)->get();
		return $data;
	}
	public function getComment($tmdb) {
		$page = $page * 10;
		$data = DB::table ( 'comment' )->where ( 'tmdb', $tmdb)->get ();
		// Season::where('',$type)->take(10)->skip($page)->get();
		return $data;
	}
	public function getAllComment($tmdb) {
		$page = $page * 10;
		$data = DB::table ( 'comment' )->where ( 'tmdb', $tmdb)
		->join('movies','movies.tmdb','=','comment.tmdb')
		->join('category','category.id','=','comment.tmdb')
		->get ();
		// Season::where('',$type)->take(10)->skip($page)->get();
		return $data;
	}
	public function getSeasonByTV($tv, $page) {
		$page = $page * 10;
		$data = DB::table ( 'tv' )->join ( 'season', 'tv.tmdb', '=', 'season.tv' )
		->join('episode','season.tmdb','=', 'episode.season')
		->select('season.*',DB::raw("'season' as type"),DB::raw("COUNT(episode.id) as Epi"))
		->where ( 'tv.tmdb', $tv )
		->groupBy('episode.season')
		->take ( 10 )->skip ( $page )->get ();
		// Season::where('',$tv)->take(10)->skip($page)->get();
		return $data;
	}
	public function getEpisodeBySeason($Season, $page) {
		$page = $page * 100;
		$data = DB::table ( 'season' )->select('episode.*','season.num as seasonNum','season.tv as tv')
		->join ( 'episode', 'episode.season', '=', 'season.tmdb' )
		//->join ( 'infos', 'infos.tmdb', '=', 'season.tmdb' )
		->where ( 'season.tmdb', $Season )->take ( 100 )->skip ( $page )->get ();
		// Season::where('',$tv)->take(10)->skip($page)->get();
		return $data;
	}
	public function getAnimeBySeason($Season, $page) {
		$page = $page * 10;
		$data = DB::table ( 'season' )->join ( 'anime', 'anime.season', '=', 'season.tmdb' )->where ( 'season.tmdb', $Season )->take ( 10 )->skip ( $page )->get ();
		// Season::where('',$tv)->take(10)->skip($page)->get();
		return $data;
	}
	public function getAnimeTv($page, $type) {
		$page = $page * 10;
		$data = DB::table ( 'tv' )->where ( 'type', $type )->take ( 10 )->skip ( $page )->get ();
		// Season::where('',$type)->take(10)->skip($page)->get();
		return $data;
	}
	public function getServerByTmdb($tmdb, $page) {
		$page = $page * 100;
		$data = DB::table ( 'server' )->where ( 'tmdb', $tmdb )->take ( 100 )->skip ( $page )->get ();
		// Season::where('',$tv)->take(10)->skip($page)->get();
		return $data;
	}
	public function getShowTime($page) {
		$page = $page * 10;
		$data = DB::table ( 'showtimes' )->
		// ->where('type',$type)
		take ( 10 )->skip ( $page )->get ();
		// Season::where('',$type)->take(10)->skip($page)->get();
		return $data;
	}
	public function getCategory() {
		$data = DB::table ( 'category' )->get ();
		// Season::where('',$type)->take(10)->skip($page)->get();
		return $data;
	}
	public function getShowTimeByTmdb($tmdb, $page) {
		$page = $page * 100;
		$data = DB::table ( 'showtimes' )->where ( 'tmdb', $tmdb )->take ( 100 )->skip ( $page )->get ();
		// Season::where('',$tv)->take(10)->skip($page)->get();
		return $data;
	}
	
	public function deleteServer($id) {
		Server::where ( 'id', $id )->delete ();
	}
	public function deleteTime($id) {
		Showtimes::where ( 'id', $id )->delete ();
	}
	public function deleteComment($tmdb) {
		Comment::where ( 'id', $tmdb)->delete ();
	}
	public function deleteCategory($name) {
		Category::where ( 'name', $name)->delete ();
	}
	public function deleteEpisode($tmdb) {
		Episode::where ( 'tmdb', $tmdb)->delete ();
	}
	public function deleteEpisodesBySeason($tmdb) {
		try {
			Episode::where ( 'season', $tmdb)->delete ();
			$this->deleteInfos($tmdb);
		} catch (Exception $e) {
			return response ()->json ( $e->all () );
		}
		
	}
	public function deleteInfos($tmdb) {
		Infos::where ( 'tmdb', $tmdb)->delete ();
	}
	public function deleteMovies($tmdb) {
		try {
			$this->deleteInfos($tmdb);
			Movies::where ( 'tmdb', $tmdb)->delete ();
		} catch (Exception $e) {
			return response ()->json ( $e->all () );
		}
	}
	public function deleteSeason($tmdb) {
		try {
			$this->deleteEpisodesBySeason($tmdb);
			Season::where ( 'tmdb', $tmdb)->delete ();
		} catch (Exception $e) {
			return response ()->json ( $e->all () );
		}
	}
	public function deleteTv($tmdb) {
		try {
			$this->deleteSeason($tmdb);
			Tv::where ( 'tmdb', $tmdb)->delete ();
		} catch (Exception $e) {
			return response ()->json ( $e->all () );
		}
	}
	
	
	public function sayhello() {
		return 'hello Crazy Dev ;)';
	}
	public function sayhellow(Request $request) {
		$response = array ();
		// return $request;
		$parameters = $request;
		$res ['success'] = $request->header('api_token');
		$res ['result'] = 'Hello world with lumen';
		return response ( $res );
	}
	
	// public function addShowTime(Request $request){
	// $response = array ();
	// // return $request;
	// $parameters = $request;
	// ShowTime::create( array (
	// 'tmdb' => $parameters ['tmdb'],
	// 'channel' => $parameters ['channel'],
	// 'day' => $parameters ['day'],
	// 'time' => $parameters ['time'],
	// ) );
	// }
	public function addShowTime(Request $request) {
		$response = array ();
		// return $request;
		$parameters = $request;
		try {
			$createdView = Showtimes::create ( array (
				'tmdb' => $parameters ['tmdb'],
				'channel' => $parameters ['channel'],
				'day' => $parameters ['day'],
				'time' => $parameters ['time']
		) );
			//return response ()->json ( $parameters );
		} catch ( Exception $e ) {
			return response ()->json ( $e->all () );
		}
	}
	public function getnews($page){
		
		$page = $page * 10;
		
		$epi = DB::table('episode')->select('episode.title','episode.tmdb','episode.created_at','season.tmdb as seasonTmdb','season.num as season','episode.num as num','tv.tmdb as tv',DB::raw("'epi' as type"))
		->join('season','season.tmdb','=', 'episode.season')
		->join('tv','tv.tmdb','=','season.tv')->groupBy('season.tmdb')->orderBy('created_at', 'desc');
		$mov = DB::table('movies')->select('title','tmdb', 'created_at',DB::raw("'' as seasonTmdb"),DB::raw("'' as season"),DB::raw("'' as num"),DB::raw("'' as tv"),DB::raw("'mov' as type"))
		->union($epi)->orderBy('created_at', 'desc')
		->take ( 10 )->skip ( $page )->get();
		
// 		$data = DB::select('SELECT tmdb,created_at FROM episode UNION SELECT tmdb,created_at FROM movies ORDER BY created_at', [])
// 		->get ();
		return response ()->json ( $mov);
	}
	public function getSeasonsByCategory($page,$cate){
		
		$page = $page * 10;
		
		$season = DB::table('season')->select('season.*',DB::raw("COUNT(episode.id) as Epi"),DB::raw("'season' as type"))
		->join('episode','season.tmdb','=', 'episode.season')
		->join('tv','tv.tmdb','=','season.tv')
		->where('tv.category','=',$cate)->groupBy('episode.season')
		->take ( 10 )->skip ( $page )->get();
		
		// 		$data = DB::select('SELECT tmdb,created_at FROM episode UNION SELECT tmdb,created_at FROM movies ORDER BY created_at', [])
		// 		->get ();
		return response ()->json ( $season);
	}
	public function getInfo($tmdb){
		$data = DB::table ( 'infos' )->where ( 'tmdb', $tmdb)->get ();
		// Season::where('',$tv)->take(10)->skip($page)->get();
		return $data;
	}
	
	
}
