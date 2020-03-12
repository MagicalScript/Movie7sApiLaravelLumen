<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEpisodeTable extends Migration {

	public function up()
	{
		Schema::create('episode', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('tmdb', 25);
			$table->text('metadata');
			$table->string('title');
			$table->string('num');
			$table->string('season');
		});
	}

	public function down()
	{
		Schema::drop('episode');
	}
}