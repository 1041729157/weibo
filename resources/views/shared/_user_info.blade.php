<ul class="section-ul center">
	<a href="{{ route('users.show', $user->id) }}">
		<img src="{{ $user->gravatar('140') }}" alt="{{ $user->name }}" class="gravatar"/>
	</a>
	<h1 class="text-center">{{ $user->name }}</h1>
</ul>
