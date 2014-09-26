<?php

class UserController extends BaseController
{   
    


    public function getCreate()
    {
        //do our login mechanisms herere
        return View::make('user.register');
    }


    public function getLogin()
    {
        //do our login mechanisms here
        return View::make('user.login');
    }


    public function postCreate(){
        $validate = Validator::make(Input::All(), array(
            'username' => 'required:unique:users:min:4',
            'pass1' => 'required:min:6',
            'pass2' => 'required|same:pass1',

        ));


        if($validate->fails()){
            return Redirect::route('getCreate')->withErrors($validate)->withInput();
        }else{
            $user = new User();
            $user->username = Input::get('username');
            $user->password = Hash::make(Input::get('pass1'));

            if($user->save()){
                return Redirect::route('home')->with('success', 'You registered successfully. You can now login');
            }else{
                return Redirect::route('home')->with('fail', 'An error occured');
            }
        }
    }


    public function postLogin(){
    	$validate = Validator::make(Input::All(), array(
    		'username' => 'required',
    		'pass1' => 'required'

    	));


    	if($validate->fails()){
    		return Redirect::route('getLogin')->withErrors($validate)->withInput();
    	}else{
    		$remember = (Input::has('remember')) ? true : false;

            $auth = Auth::attempt(array(
                'username' => Input::get('username'),
                'password' => Input::get('pass1'),
                ), $remember);

            if($auth){
                return Redirect::intended('/');
            }else{
                return Redirect::route('getLogin')->with('fail', 'Incorrect Login');
            }
    	}
    }



    public function getLogout(){
        Auth::logout();
        return Redirect::route('home');
    }
}

?>