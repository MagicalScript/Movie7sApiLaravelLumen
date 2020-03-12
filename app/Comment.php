<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model 
{

    protected $table = 'comment';
    public $timestamps = true;
    protected $fillable = [
    		'user',
    		'tmdb',
    		'comment',
    		'approved',
    ];

}