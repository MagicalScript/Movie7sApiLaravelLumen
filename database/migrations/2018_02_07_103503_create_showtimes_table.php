<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShowtimesTable extends Migration {

	public function up()
	{
		Schema::create('showtimes', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('tmdb');
			$table->string('channel');
			$table->string('day');
			$table->time('time');
		});
	}

	public function down()
	{
		Schema::drop('showtimes');
	}
}