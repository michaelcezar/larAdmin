<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="Michael Cezar">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link href='/images/favicon.png' rel='shortcut icon' />
		<title>{{ App\ExtraClass\appInfo::returnAppInfo()->appName }} | @yield('pageTitle')</title>
		<link href="/js/bootstrap/css/bootstrap.css"      rel="stylesheet">
		<link href="/js/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="/css/custom.css"                      rel="stylesheet">
		@yield('extraCSS')
	</head>
	<body>
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" id="mainNavBar">
			<a class="navbar-brand" href="#">{{ App\ExtraClass\appInfo::returnAppInfo()->appName }}</a>
		</nav>
		<main role="main" class="container-fluid">
			<div class='container-fluid'>
				<div class="content">
				@yield('pageContent')
				</div>
			</div>
		</main>
		<br/>
		<footer class="footer">
			<div class="container text-center">
				<span class="text-muted">Copyright © Michael Cezar - {{ App\ExtraClass\appInfo::returnAppInfo()->appYear }}</span>
			</div>
		</footer>
		<script src="/js/jquery/jquery.min.js"                 type="text/javascript"></script>
		<script src="/js/popper/popper.min.js"                 type="text/javascript"></script>
		<script src="/js/bootstrap/js/bootstrap.js"            type="text/javascript"></script>
		<script src="/js/bootstrap-notify/bootstrap-notify.js" type="text/javascript"></script>
		<script src="/js/validator/validator.js"               type="text/javascript"></script>
		<script src="/js/custom.js"                            type="text/javascript"></script>
		@yield('extraJavaScript')
	</body>
</html>