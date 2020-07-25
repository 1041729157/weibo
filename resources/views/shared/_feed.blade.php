@if ($feed_itm->count() > 0)
<ul class="list-unstyled">
	@foreach($feed_itm as $status)
		<!-- $status->user 获取当前微博对应的用户数据 -->
		@include('statuses._status', ['user' => $status->user])
	@endforeach
</ul>
<div class="mt-5">
	{!! $feed_itm->links() !!}
</div>
@else
<p>没有数据</p>
@endif