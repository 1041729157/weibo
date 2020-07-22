@extends('layouts.default')

@section('title', '用户列表')

@section('content')
<div class="offset-md-2 col-md-8">
	<h2 class="mb-4 text-center">所有用户</h2>
	<div class="list-gtoup list-group-flush">
		@foreach($users as $user)
		<div class="list-group-item">
			<img class="mr-3" src="{{ $user->gravatar() }}" alt="{{ $user->name }}" width="32">
			<a href="{{ route('users.show', $user->id) }}">
				{{ $user->name }}
			</a>
            @can('destroy', $user)
            <form class="float-right" method="POST" action="{{ route('users.destroy', $user->id) }}">
                @csrf <!-- {{ csrf_field() }} -->
                @method('DELETE') <!-- {{ @method_field('DELETE') }} -->
                <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
            </form>
            @endcan
		</div>
		@endforeach
	</div>
	<div class="mt-3">

		<!-- {!! $users->render() !!} -->
		<!-- {!! $users->links() !!} -->
		{!! $users->appends(['title'=>'article','price'=>10])->render() !!}

<!-- <ul class="pagination  no-margin pull-right">

        @if ($users->onFirstPage())
            <li class="disabled">
                <span>首页</span>
            </li>
        @else
            <li>
                <a href="{{ $users->url(1) . '&limit=' . $users->perPage() }}">首页</a>
            </li>
        @endif

        @if ($users->onFirstPage())
            <li class="disabled">
                <span>上一页</span>
            </li>
        @else
            <li>
                <a href="{{ $users->previousPageUrl() . '&limit=' . $users->perPage() }}">上一页</a>
            </li>
        @endif

        @foreach ($users as $user)

            @if (is_string($user))
                <li class="disabled"><span>{{ $user }}</span></li>
            @endif

            @if (is_array($user))
                @foreach ($user as $page => $url)
                    @if ($page == $users->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url . '&limit=' . $users->perPage() }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($users->hasMorePages())
            <li>
                <a href="{{ $users->nextPageUrl() . '&limit=' . $users->perPage() }}">下一页</a>
            </li>
        @else
            <li class="disabled">
                <span>下一页</span>
            </li>
        @endif

        {{-- 尾页 --}}
        @if ($users->hasMorePages())
            <li>
                <a href="{{ $users->url($users->lastPage()) . '&limit=' . $users->perPage() }}">尾页</a>
            </li>
        @else
            <li class="disabled">
                <span>尾页</span>
            </li>
        @endif
    </ul> -->
    <ul class="clearfix"></ul>

    {{-- 增加输入框，跳转任意页码和显示任意条数 --}}
    <ul class="pagination pagination-sm no-margin no-padding pull-right">
        <li>
            <span data-toggle="tooltip" data-placement="bottom" title="输入页码，按回车快速跳转">
                第 {{ $users->currentPage() }} 页 / 共 {{ $users->lastPage() }} 页
            </span>
        </li>
        <li>
            <!-- <span data-toggle="tooltip" data-placement="bottom" title="输入每页条数，按回车快速跳转">
                每页 <input type="text" class="text-center no-padding" value="{{ $users->perPage() }}" id="customLimit" data-total="{{ $users->total() }}" style="width: 50px;"> 条 / 共 {{ $users->total() }} 条
            </span> -->
            <span data-toggle="tooltip" data-placement="bottom" title="输入每页条数，按回车快速跳转" class="text-center no-padding">
            	<p style="margin-left: 10px">
                每页 {{ $users->perPage() }} 条 / 共 {{ $users->total() }} 条
                </p>
            </span>
        </li>
        <!-- <li>
        <span data-toggle="tooltip" data-placement="bottom" title="输入页码，按回车快速跳转">
                第 <input type="text" class="text-center no-padding" data-jump="{{$users->url(1)}}" value="{{ $users->currentPage() }}" id="customPage" data-total-page="{{ $users->lastPage() }}" style="width: 50px;"> 页 / 共 {{ $users->lastPage() }} 页
            </span>
        </li> -->
	</ul>

<!-- <ul class="pagination pagination-sm no-margin no-padding pull-right">
        <li>
            <span data-toggle="tooltip" data-placement="bottom" title="输入页码，按回车快速跳转">
                第 <input type="text" class="text-center no-padding" value="{{ $users->currentPage() }}" id="customPage" data-total-page="{{ $users->lastPage() }}" style="width: 50px;"> 页 / 共 {{ $users->lastPage() }} 页
            </span>
        </li>
        <li>
            <span data-toggle="tooltip" data-placement="bottom" title="输入每页条数，按回车快速跳转">
                每页 <input type="text" class="text-center no-padding" value="{{ $users->perPage() }}" id="customLimit" data-total="{{ $users->total() }}" style="width: 50px;"> 条 / 共 {{ $users->total() }} 条
            </span>
        </li>
    </ul> -->


	</div>
</div>
<script>
	/*$("#submit").keydown(function(e){
        if(e.keyCode == 13){
            var jump = $("#submit").attr('data-jump');
            jump = jump.substring(0, jump.length-1);
            var page = $('#submit').val();
            location.href= jump + page;
        }
    });*/

    /*$("#customPage").keydown(function(e){
        if(e.keyCode == 13){
            var page = $('#customPage').val();
            var total= <?php echo $users->lastPage()?>;
            if (page*1 > total*1 || page*1 < 1) {
                alert('页数不符合要求');
                return false;
            }
            location.href= 'http://'+window.location.host+window.location.search;
        }
    });*/

</script>
@stop