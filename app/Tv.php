<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tv extends Model 
{

    protected $table = 'tv';
    public $timestamps = true;
    protected $fillable = [
    		'tmdb',
    		'title',
    		'category',
    ];

}