@extends('layouts.default')

@section('title',$user->name)

@section('content')
	<div class="row">
		<div class="offset-md-2 col-md-8">
			<section class="user_info">
				<!-- ['user' => $user]用户数据以关联数组的形式传送到 _user_info 局部视图上 -->
				<!-- @include('shared._user_info',['user' => $user]) -->
				@include('shared._user_info')
			</section>

			@if (Auth::check())
				@include('users._follow_form')
			@endif

			<section class="stats mt-2">
				@include('shared._stats')
			</section>
			<hr>
			<section class="status">
				<!-- count() 函数返回数组中元素的数目 -->
				@if ($statuses->count() > 0)
				<ul class="list-unstyled">
					@foreach($statuses as $status)
						@include('statuses._status')
					@endforeach
				</ul>
				<div class="mt-5">
					{!! $statuses->links() !!}
				</div>
				@else
				<p>暂无微博数据！</p>
				@endif
			</section>
		</div>
	</div>
@stop