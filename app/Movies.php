<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movies extends Model 
{

    protected $table = 'movies';
    public $timestamps = true;
    protected $fillable = [
    		'tmdb',
    		'metadata',
    		'title',
    		'category',
    ];
    

}