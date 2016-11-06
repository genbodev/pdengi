<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $tbl) {
			$tbl->increments('id', 10);
			$tbl->string('name', 255);
			$tbl->decimal('balance', 10, 2);
			$tbl->dateTime('published_at');
			$tbl->dateTime('updated_at');
			$tbl->dateTime('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
