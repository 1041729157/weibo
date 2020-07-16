@foreach(['danger', 'warning', 'success', 'info'] as $msg)
	@if(session()->has($msg))<!-- 判断会话中 $msg 键对应的值是否为空 -->
	<div class="flash-message">
		<p class="alert alert-{{ $msg }}">
			{{ session()->get($msg) }}
		</p>
	</div>
	@endif
@endforeach