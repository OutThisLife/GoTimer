app = angular.module 'app.filters', []

app.filter 'objLength', -> (obj) ->
	i = 0
	i++ for z of obj
	i

app.filter 'with', -> (items, f) ->
	result = if f.client? then {} else items

	if f.client?
		for k, v of items
			result[k] = items[k] if k is f.client

	result

app.filter 'humanSeconds', -> (s) ->
	h = Math.floor(s / 3600).toFixed 0
	m = ((s / 60) % 60).toFixed 0
	s = (s % 60).toFixed 0

	"#{h}hr #{m}m #{s}s"

app.filter 'dateToISO', -> (d) -> d.replace /(.+) (.+)/, "$1T$2Z"