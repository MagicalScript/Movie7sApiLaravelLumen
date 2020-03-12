<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTvTable extends Migration {

	public function up()
	{
		Schema::create('tv', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 50);
			$table->string('tmdb', 25);
			$table->string('category');
		});
	}

	public function down()
	{
		Schema::drop('tv');
	}
}