app = angular.module 'app.directives', []

# Quickscope
app.directive 'ngScope', ->
	restrict: 'A'
	scope: true

# Expandable table rows
app.directive 'ngExpandableTable', ->
	restrict: 'A'
	scope: true
	link: (scope, el) ->
		ids = []

		scope.toggle = (id) ->
			if scope.isShown(id)
				ids.splice(ids.indexOf(id), 1)

			else ids.push id

		scope.isShown = (id) -> ids.indexOf(id) > -1