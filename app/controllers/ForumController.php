<?php

class ForumController extends BaseController
{   
    
    public function index(){
        
        $groups = ForumGroup::all();
        $categories = ForumCategory::all();
        return View::make('forum.index')->with('groups', $groups)->with('categories' , $categories);

    }


    public function category($id){

    }

    public function thread($id){

    }

}

?>