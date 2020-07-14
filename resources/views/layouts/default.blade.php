<!DOCTYPE html>
<html>
<head>
	<title>@yield('title','Weibo App')</title>
	<link rel="stylesheet" type="text/css" href="{{  mix('css/app.css') }}">
	<link rel="stylesheet" type="text/css" href="/css/home.css">
	@yield('link')
</head>
<body>
	@include('layouts._header')
    <div class="container">
    	<div class="offset-md-1 col-md-10">
    		@include('shared._messages')
    		@yield('content') 
    		@include('layouts._footer')
    	</div>
	</div>
</body>
</html>