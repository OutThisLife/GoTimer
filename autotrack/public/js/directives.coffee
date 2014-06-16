app = angular.module 'app.directives', []

# Quickscope
app.directive 'ngScope', ->
	restrict: 'A'
	scope: true

# Expandable table rows
app.directive 'ngExptable', ->
	restrict: 'A'
	scope: true
	link: (scope, el) ->
		ids = []

		scope.toggle = (id) ->
			if scope.isShown(id)
				ids.splice(ids.indexOf(id), 1)

			else ids.push id

		scope.isShown = (id) -> ids.indexOf(id) > -1

# ngFocus fix.
app.directive 'ngAltFocus', ->
	restrict: 'A'
	scope: ngAltFocus: '='
	link: (scope, el, attrs) ->
		scope.$watch 'ngAltFocus', (nv) -> el[0].focus() if nv