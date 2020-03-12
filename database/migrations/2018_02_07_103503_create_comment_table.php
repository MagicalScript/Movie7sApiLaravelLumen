<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentTable extends Migration {

	public function up()
	{
		Schema::create('comment', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user');
			$table->string('tmdb');
			$table->string('comment');
			$table->string('approved');
		});
	}

	public function down()
	{
		Schema::drop('comment');
	}
}