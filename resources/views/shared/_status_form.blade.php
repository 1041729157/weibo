<form action="{{ route('statuses.store') }}" method="post">
	@include('shared._errors')
	@csrf <!-- {{ csrf_field() }} -->
	<textarea class="form-control" rows="3" placeholder="聊聊新鲜事..." name="content">{{ old('content') }}</textarea>
	<div class="text-left">
		<button type="submit" class="btn btn-primary mt-3">发布</button>
	</div>
</form>