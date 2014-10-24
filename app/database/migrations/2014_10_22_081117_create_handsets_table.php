<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHandsetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('handsets', function(Blueprint $table){
			$table->increments('id');
			$table->string('rator_product_id');
			$table->string('phone_name');
			$table->double('price');
			$table->double('shipping_fee');
			$table->enum('customer_care_only', array(0, 1))->default(0);
			$table->enum('ltecapable', array(0, 1))->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('handsets');
	}

}
