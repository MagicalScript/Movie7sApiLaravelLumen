<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServerTable extends Migration {

	public function up()
	{
		Schema::create('server', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('Title', 50);
			$table->text('url');
			$table->string('type');
			$table->string('tmdb');
		});
	}

	public function down()
	{
		Schema::drop('server');
	}
}