app = angular.module 'app.controllers', []

app.controller 'MainController', ['$scope', '$xhr', ($scope, $xhr) ->
	# Grab the list of clients
	$xhr.fetch('/clients').then (response) -> $scope.clients = response.data

	# Grab all data and store it in a cached object
	r = {}
	$xhr.fetch('/').then (response) ->
		for _, t of response.data
			base = getBase(t.ClientName, t.Path)
			r[t.ClientName] = {} unless r[t.ClientName]?

			unless r[t.ClientName][base]?
				r[t.ClientName][base] =
					id: t.ID
					Time: 0
					Path: base
					Date: t.Date

			r[t.ClientName][base].children = {} unless r[t.ClientName][base].children?
			r[t.ClientName][base].children[t.Path] = t unless r[t.ClientName][base].children[t.Path]?

			r[t.ClientName][base].Time += t.Time
			r[t.ClientName][base].children[t.Path].Time += t.Time

		$scope.data = r

	getBase = (name, dir) ->
		dir = (->
			if dir.indexOf('/') is -1
				dir.substring 0, dir.lastIndexOf('\\')

			else
				dir.substring 0, dir.LastIndexOf('/')
		)()

		dir.replace "/(.*#{name}.*?\\\\{1}.*?)\\\\{1}(.*)$/i", '$1'

	# Allow for filtering
	$scope.search = {}
	$scope.filterClient = (c) -> $scope.search.client = c
	$scope.deleteFilter = -> delete $scope.search.client

	$scope.hasData = ->
		return true unless $scope.search.client?
		typeof(r[$scope.search.client]) isnt 'undefined'
]