<!doctype html>

<html lang="en">

	<head>
		<meta charset="UTF-8">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="/css/mtgicons.css" /> <!-- Mana Symbols -->
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.8/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="/css/jquery.qtip.min.css">
		<link rel="stylesheet" href="/css/style.css">

		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="//cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
		<script src="/js/jquery.qtip.min.js"></script>

		<title>{{ $titleTag }}MTG Insight</title>
	</head>

	<body>
		<div class="navbar navbar-inverse" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="/">MTG Insight</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="{!! setActive('cards*') !!}"><a href="/cards">Cards</a></li>
						<li class="{!! setActive('scrapers*') !!}"><a href="/scrapers">Scrapers</a></li>
					</ul>
				</div>
			</div>
	    </div>

		<div class="container">
			@yield('content')
		</div>
	</body>

</html>