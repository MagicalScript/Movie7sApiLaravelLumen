<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInfosTable extends Migration {

	public function up()
	{
		Schema::create('infos', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('overview');
			$table->string('name');
			$table->date('first_air_date');
			$table->string('genre_ids');
			$table->string('original_language');
			$table->string('backdrop_path');
			$table->string('origin_country');
			$table->string('poster_path');
			$table->string('tmdb');
		});
	}

	public function down()
	{
		Schema::drop('infos');
	}
}