<!DOCTYPE html>
<html>
	<head>
	<title>Resumable.js - Multiple simultaneous, stable and resumable uploads via the HTML5 File API</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<style type="text/css">
	body{
		padding-top: 20px;
	}
	.btn-file {
	    position: relative;
	    overflow: hidden;
	}
	.btn-file input[type=file] {
	    position: absolute;
	    top: 0;
	    right: 0;
	    min-width: 100%;
	    min-height: 100%;
	    font-size: 999px;
	    text-align: right;
	    filter: alpha(opacity=0);
	    opacity: 0;
	    outline: none;
	    background: white;
	    cursor: inherit;
	    display: block;
	}
	</style>
	</head>

	<body>

		@yield('content')

	</body>
</html>