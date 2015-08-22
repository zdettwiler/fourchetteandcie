{{-- Admin - Login --}}
@extends('admin_layout')

@section('page_title', 'Admin // Login')

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/admin_forms.css" type="text/css" media="all"/>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
@stop

@section('notification-bar')

	@if($errors->has())
		<div id="notification-bar">
			<p>
			@foreach ($errors->all() as $error)
				{{ $error }}{!! '<br>' !!}
			@endforeach
			</p>
		</div>
	@endif

@stop

@section('content')
	<div style="margin: auto; width: 215px; margin-top: 20%;">
		<h2>Please Log In</h2>

		{{-- @foreach ($users as $user)
			{{ $user['id'] }} {{ $user['username'] }} {{ $user['password'] }}{!! '<br>' !!}
		@endforeach --}}

		{!! Form::open() !!}
			{!! Form::text('username', 'username') !!}<br>
			{!! Form::password('password') !!}<br><br>

			{!! Form::submit('LOGIN'); !!}
		{!! Form::close() !!}
	</div>
@stop
