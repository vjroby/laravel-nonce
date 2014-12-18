<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNonceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nonce', function (Blueprint $table){
			$table->string('id',255);
			$table->string('data',255)->nullable();
			$table->nullableTimestamps();

			$table->unique(['id', 'data']);
			$table->index(['id', 'data']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('nonce');
	}

}
