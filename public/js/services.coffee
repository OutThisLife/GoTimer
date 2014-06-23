app = angular.module 'app.services', []

app.service '$xhr', ['$http', '$q', ($http, $q) ->
	fetch: (uri) ->
		deferred = $q.defer()

		$http
			method: 'GET'
			url: "http://localhost:8080#{uri}"
			cache: true

		.success (response, status, headers, config) ->
			results = []
			results.data = response
			results.headers = headers()

			deferred.resolve results

		.error (data, status) -> deferred.reject data, status

		deferred.promise
]