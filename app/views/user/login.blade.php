@extends('layouts.master')

@section('head')
    @parent
    <title>Login</title>
@stop

@section('content')
	<div class="container">
		<h1>Login</h1>
		@if(Session::has('success'))
			<div class="alert alert-success">{{ Session::get('success') }}</div>
		@elseif ( Session::has('fail'))
			<div class="alert alert-danger">{{ Session::get('fail') }}</div>
		@endif
		<form role="form" method="post" action="{{ URL::route('postLogin') }}">
			{{ Form::token() }}
			<div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
				<label for="username"> Username:</label>
				<input id="username" name="username" type="text" class="form-control">
				@if($errors->has('username'))
					{{ $errors->first('username') }}
				@endif
			</div>
			<div class="form-group {{ $errors->has('pass1') ? 'has-error' : '' }}">
				<label for="pass1"> Password:</label>
				<input id="pass1" name="pass1" type="password" class="form-control">
				@if($errors->has('pass1'))
					{{ $errors->first('pass1') }}
				@endif
			</div>
			<div class="form-group">
				<label for="remember"> Remember:</label>
				<input id="remember" name="remember" type="checkbox" >
			</div>

			<div class="form-group">
				<input type="submit" value="Register" class="btn btn-default" >
			</div>

		</form>
	</div>
@stop