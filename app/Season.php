<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model 
{

    protected $table = 'season';
    public $timestamps = true;
    protected $fillable = [
    		'tmdb',
    		'title',
    		'num',
    		'tv',
    ];

}