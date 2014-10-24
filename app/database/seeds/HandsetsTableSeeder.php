<?php

Class HandsetsTableSeeder extends Seeder {

	public function run(){

		$data = [
			[	
			'rator_product_id' => 'SAM-SPHM580',
			'phone_name' => 'Samsung Replenish',
			'price' => 72,
			'ltecapable' => 0
			]
		];

		DB::table('handsets')->insert($data);
	}

}



?>