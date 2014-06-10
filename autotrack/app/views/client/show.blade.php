@extends('layouts.master')

@section('content')

<div class="group">
	@if (empty($trails))
	<h2>No log data found for <code>{{ $client->name }}</code>.</h2>

	@else
	@foreach ($trails AS $group => $items)

	<h2>
		{{ $group }}
		<small>{{ current($items['main'])->updated_at->format('m.d.y') }}</small>
	</h2>

	<div class="content-section">
		<table class="feed-data full-width" ng-exptable>
			<tbody>
				@include('client.row-data')
			</tbody>
		</table>
	</div>
	@endforeach

	@endif
</div>

@stop