<!doctype html>

<html lang="en">

	<head>
		<meta charset="UTF-8">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

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