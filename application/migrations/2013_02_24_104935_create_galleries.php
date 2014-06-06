<?php

class Create_Galleries {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('galleries', function($table) {
			$table->increments('id');
			$table->string('title', 128);
			$table->text('body');
			$table->integer('author_id');
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('galleries');
	}

}