<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table){
			$table->increments('customerID');
			$table->string('firstname');
			$table->string('lastname');
			$table->string('email_address');
			$table->string('phone');
			$table->string('street_address');
			$table->string('city');
			$table->string('zipcode');
			$table->string('state');
			$table->string('country');
			$table->date('dob');
			$table->string('employment');
			$table->string('education');
			$table->string('hometown');
			$table->string('relationship');
			$table->integer('likes');
			$table->string('shipping_address');
			$table->string('shipping_state');
			$table->string('shipping_zip');
			$table->string('username');
			$table->string('password');
			$table->timestamp('subscription_date');
			$table->enum('customerStaatus', array('Pending', 'Active', 'Subscribed'));
			$table->string('cdratorID');
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
		Schema::drop('customers');
	}

}
