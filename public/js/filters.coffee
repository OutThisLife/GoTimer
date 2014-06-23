app = angular.module 'app.filters', []

# Trust a resource
app.filter 'trust', ['$sce', ($sce) ->
	(src) -> $sce.trustAsResourceUrl src
]

# Newline to <br />
app.filter 'nl2br', -> (text) -> text.replace /\n/g, '<br />' if text?

# Reverse an object
app.filter 'reverse', -> (obj) -> obj.slice().reverse()

# Count an objects length
app.filter 'objLength', -> (obj) ->
	i = 1
	i++ for z of obj
	i

# Converts links to hyperlinkls
app.filter 'parseUrl', ->
	pattern = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/gi

	(text, target = '_blank') ->
		angular.forEach text.match(pattern), (url) ->
			text = text.replace url, "<a target=#{target} href=#{url}>#{url}</a>"
		text

# With key
app.filter 'with', -> (items, f) ->
	result = if f.client? then {} else items

	if f.client?
		for k, v of items
			result[k] = items[k] if k is f.client

	result

# Human seconds
app.filter 'humanSeconds', -> (s) ->
	h = Math.floor(s / 3600).toFixed 0
	m = ((s / 60) % 60).toFixed 0
	s = (s % 60).toFixed 0

	return "#{h}hr #{m}m #{s}s"