requirejs.config
	baseUrl: '/golang/autotrack/public/js' # Talasan [dev]
	urlArgs: "bust=#{(new Date()).getTime()}"

	paths:
		# CDN powered
		jquery: ['//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min']
		angular: ['//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular']

		# Local
		controllers: ['controllers']
		services: ['services']
		directives: ['directives']
		filters: ['filters']

	shim:
		angular: exports: 'angular'
		jquery: exports: '$'
		controllers: ['angular']
		services: ['angular']
		directives: ['angular']
		filters: ['angular']

	priority: ['angular', 'jquery']

require [
	'angular',
	'controllers',
	'directives',
	'services',
], (angular) ->
	angular.element(document).ready ->
		angular.module 'app', [
			'app.controllers',
			'app.directives',
			'app.services',
		]

		angular.bootstrap document, ['app']