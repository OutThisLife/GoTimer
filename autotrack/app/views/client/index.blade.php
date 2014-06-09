@extends('layouts.master')

@section('content')

<div class="group">
	<h1>Recent Activity</h1>

	<table class="feed-data full-width" ng-exptable>
		<tbody>
			@foreach ($allClients AS $client)
			@foreach ($client->organizedTrails() AS $group => $trails)

			@foreach ($trails['main'] AS $t)
			<!-- Main folder(s) -->
			<tr ng-click="toggle({{ $t->id }})" ng-class="{active: isShown({{ $t->id }})}">
				<td class="text-center" width="30">
					<i class="fa fa-angle-double-right" ng-hide="isShown({{ $t->id }})"></i>
					<i class="fa fa-angle-double-down" ng-show="isShown({{ $t->id }})" ng-cloak></i>
				</td>

				<td>
					{{ $client->name }}
					&times;
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
			@if (!empty($trails[$t->path] ))
			@foreach ($trails[$t->path] AS $nt)
			<tr class="children" ng-show="isShown({{ $t->id }})" ng-cloak>
				<td></td>
				<td>{{ $nt->nicetime() }}</td>
				<td>{{ $nt->path }}</td>
				<td></td>
			</tr>
			@endforeach
			@endif

			@endforeach
			@endforeach
			@endforeach
		</tbody>
	</table>
</div>

@stop