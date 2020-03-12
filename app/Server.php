<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model 
{

    protected $table = 'server';
    public $timestamps = true;
    protected $fillable = [
    		'tmdb',
    		'url',
    		'Title',
    		'type',
    ];

}