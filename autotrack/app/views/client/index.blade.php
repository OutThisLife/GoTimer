@extends('layouts.master')

@section('content')

<div class="group">
	@if (Client::all()->count() === 0)
	<h1>No clients found.</h1>
	<p>Add some clients to the left to begin tracking data.</p>

	@elseif (Trail::all()->count() === 0)
	<h1>No log data yet.</h1>
	<p>Give it time. Go work on a project and refresh this page to see the data coming in.</p>

	@else
	<h1>Latest Activity</h1>

	<div class="content-section">
		<table class="feed-data full-width" ng-exptable>
			<tbody>
				@foreach ($allClients AS $client)
				@foreach ($client->organizedTrails() AS $group => $items)

				@include('client.row-data')

				@endforeach
				@endforeach
			</tbody>
		</table>
	</div>
	@endif
</div>

@stop