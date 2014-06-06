<?php

class Create_Pictures {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pictures', function($table) {
			$table->increments('id');
			$table->string('file_name', 128);
			$table->integer('author_id');
			$table->integer('gallery_id');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pictures');
	}

}