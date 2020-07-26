@can('follow', $user)
<div class="text-center mt-2 mb-4">
	@if (Auth::user()->isFollowing($user->id))
	<form method="post" action="{{ route('followers.destroy', $user->id) }}">
		@csrf
		@method('DELETE')
		<button type="submit" class="btn btn-sm btn-primary">取消关注</button>
	</form>
	@else
	<form method="post" action="{{ route('followers.store', $user->id) }}">
		@csrf
		<button type="submit" class="btn btn-sm btn-primary">关注</button>
	</form>
	@endif
</div>
@endcan