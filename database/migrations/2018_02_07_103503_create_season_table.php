<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeasonTable extends Migration {

	public function up()
	{
		Schema::create('season', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('tmdb', 25);
			$table->string('title', 25);
			$table->string('num');
			$table->string('tv');
		});
	}

	public function down()
	{
		Schema::drop('season');
	}
}