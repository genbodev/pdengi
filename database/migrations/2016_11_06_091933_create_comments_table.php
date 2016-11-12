<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function($tbl) {
			$tbl->increments('id', 10);
			$tbl->integer('user_id', false, true)->length(10);
			$tbl->text('text');
			$tbl->dateTime('published_at');
			$tbl->dateTime('updated_at');
			$tbl->dateTime('created_at');
			$tbl->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropForeign('user_id');
		Schema::drop('comments');
	}

}
