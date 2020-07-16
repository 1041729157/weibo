@extends('layouts.default')

@section('title', '登陆')

@section('content')
<div class="offset-md-2 col-md-8">
	<div class="card">
		<div class="card-header">
			<h5>登陆</h5>
		</div>
		<div class="card-body">
			@include('shared._errors')

			<form action="{{ route('login') }}" method="POST">
				@csrf
				<div class="form-group">
					<label for="email">邮箱</label>
					<input class="form-control" type="text" name="email" value="{{ old('email') }}">
				</div>
				<div class="form-group">
					<label for="password">密码</label>
					<input class="form-control" type="password" name="password" value="{{ old('password') }}">
				</div>

				<div class="form-group">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="remember" id="exampleCheck1">
						<label class="form-check-label" for="exampleCheck1">记住我</label>
					</div>
				</div>

				<button type="submit" class="btn btn-primary">登陆</button>
			</form>
			<hr>
			<p><a href="{{ route('signup') }}">新用户注册</a></p>
		</div>
	</div>
</div>
@stop