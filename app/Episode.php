<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model 
{

    protected $table = 'episode';
    public $timestamps = true;
    protected $fillable = [
    		'tmdb',
    		'metadata',
    		'title',
    		'num',
    		'season',
    ];

}