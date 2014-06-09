@extends('layouts.master')

@section('content')

<div class="group">
	@if (empty($trails))
	<h2>No log data found for <code>{{ $client->name }}</code>.</h2>

	@else
	@foreach ($trails AS $group => $items)

	<h2>{{ $group }}</h2>

	<table class="feed-data full-width" ng-exptable>
		<tbody>
			@foreach ($items['main'] AS $t)
			<!-- Main folder(s) -->
			<tr ng-click="toggle({{ $t->id }})" ng-class="{active: isShown({{ $t->id }})}">
				<td class="text-center" width="30">
					<i class="fa fa-angle-double-right" ng-hide="isShown({{ $t->id }})"></i>
					<i class="fa fa-angle-double-down" ng-show="isShown({{ $t->id }})" ng-cloak></i>
				</td>

				<td>
					{{ CarbonHelper::humanSeconds($t->time) }}
				</td>

				<td>
					{{ $t->path }}
				</td>

				<td class="text-right" width="150">
					{{ $t->updated_at->diffForHumans() }}
				</td>
			</tr>

			<!-- Subfiles -->
			@if (!empty($items[$t->path] ))
			@foreach ($items[$t->path] AS $nt)
			<tr class="children" ng-show="isShown({{ $t->id }})" ng-cloak>
				<td></td>
				<td>{{ $nt->nicetime() }}</td>
				<td>{{ $nt->path }}</td>
				<td></td>
			</tr>
			@endforeach
			@endif

			@endforeach
		</tbody>
	</table>
	@endforeach

	@endif
</div>

@stop