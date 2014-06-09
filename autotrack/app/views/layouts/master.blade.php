<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />

	<title>GoTracker</title>

	<link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/4.1.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="//cdn.jsdelivr.net/normalize/3.0.1/normalize.min.css" />
	<link rel="stylesheet" href="//cdn.jsdelivr.net/foundation/5.2.3/css/foundation.min.css" />

	<link rel="stylesheet" href="{{ asset('css/core.css') }}" />
	<link rel="shortcut icon" href="{{ asset('favicon.jpg') }}" />

	<script src="//cdn.jsdelivr.net/modernizr/2.8.2/modernizr.min.js"></script>

	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body ng-controller="MainController" itemscope itemtype="http://schema.org/WebPage">

<!-- HEADER -->
<div id="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
	<nav itemscope itemtype="http://schema.org/SiteNavigationElement">
		<ul>
			<li {{ Nav::isActive('/') }}>
				<a href="{{ URL::route('home') }}">
					<form><i class="fa fa-trash-o invisible"></i></form>All
				</a>
			</li>

			@foreach (Client::all() AS $client)
			<li {{ Nav::isActive("client/{$client->id}") }}>
				{{ Form::open(['route' => ['client.destroy', $client->id], 'method' => 'delete']) }}
					<button type="submit" href="{{ URL::route('client.destroy', $client->id) }}">
						<i class="fa fa-trash-o"></i>
					</button>
				{{ Form::close() }}

				<a class="client-name" href="{{ URL::route('client.show', $client->id) }}">
					{{ $client->name }}
				</a>
			</li>
			@endforeach
		</ul>
	</nav>

	<br />

	<form action="{{ URL::route('client.store') }}" method="post" class="add-client" ng-init="showForm = {{ $errors->has() ? 'true' : 'false' }}">
		<a href="javascript:;" class="button-standard" ng-hide="showForm" ng-click="showForm = true">
			<i class="fa fa-plus"></i>New Client
		</a>

		<div ng-show="showForm" ng-cloak>
			<input
				autocomplete="off"
				type="text"
				name="client_name"
				value="{{ Input::old('client_name') }}"
				placeholder="Type name &amp; press enter&hellip;" />

			<small>
				<a href="javascript:;" ng-click="showForm = false">
					&times; Cancel
				</a>
			</small>
		</div>

		@if ($errors->has())
		<div class="notification error">
			@foreach ($errors->all() AS $err)
			<div>{{ $err }}</div>
			@endforeach
		</div>
		@endif
	</form>
</div>

<!-- CONTENT -->
<div id="content" itemscope itemtype="http://schema.org/MainContentOfPage">
	<div id="inner-content">
		@yield('content')
	</div>
</div>

<!-- Scripts -->
<script data-main="{{ asset('js/core') }}" src="//cdn.jsdelivr.net/requirejs/2.1.11/require.min.js"></script>

</body>
</html>