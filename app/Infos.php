<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Infos extends Model 
{

    protected $table = 'infos';
    public $timestamps = true;
    protected $fillable = [
    		'tmdb',
    		'overview',
    		'name',
    		'first_air_date',
    		'genre_ids',
    		'original_language',
    		'backdrop_path',
    		'origin_country',
    		'poster_path',
    		
    ];

}