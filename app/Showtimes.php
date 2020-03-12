<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Showtimes extends Model 
{

    protected $table = 'showtimes';
    public $timestamps = true;
    protected $fillable = [
    		'tmdb',
    		'channel',
    		'day',
    		'time',
    ];

}