@extends('layouts.default')

@section('title', '注册')

@section('content')
	<div class="offset-md-2 col-md-8">
		<div class="card">
			<div class="card-header"><!-- 卡片按钮效果 -->
				<h5>注册</h5>
			</div>
			<div class="card-body">

				@include('shared._errors')

				<!-- form表单 -->
				<form method="POST" action="{{ route('users.store') }}">

					<!-- 提供一个 token（令牌）来防止应用受到 CSRF（跨站请求伪造）的攻击 -->
					@csrf <!-- 或者{{ csrf_field() }} -->
					<!-- 等同于<input type="hidden" name="_token" value="fhcxqT67dNowMoWsAHGGPJOAWJn8x5R5ctSwZrAq"> -->


					<div class="form-group">
						<label for="name">名称：</label>
						<input type="text" name="name" class="form-control" value="{{ old('name') }}"><!-- {{ old('name') }}页面进行重定向访问时，输入框将自动填写上最后一次输入过的数据 -->
					</div>
					<div class="form-group">
						<label for="email">邮箱：</label>
						<input type="text" name="email" class="form-control" value="{{ old('email') }}">
					</div>
					<div class="form-group">
						<label for="password">密码：</label>
						<input type="text" name="password" class="form-control" value="{{ old('password') }}">
					</div>
					<div class="form-group">
						<label for="password_confirmation"></label>
						<input type="txet" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
					</div>
					<button type="submit" class="btn btn-primary">注册</button>
				</form>
			</div>
		</div>
	</div>
@stop