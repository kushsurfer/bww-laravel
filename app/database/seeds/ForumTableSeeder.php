<?php

Class ForumTableSeeder extends Seeder {

	public function run(){

		ForumGroup::create(array(
			'title' => 'General Discussion',
			'author_id' => 1
		));

		ForumCategory::create(array(
			'group_id' => 1,
			'title' => 'Category 1',
			'author_id' => 1
		));

		ForumCategory::create(array(
			'group_id' => 1,
			'title' => 'Category 2',
			'author_id' => 1
		));
	}

}



?>