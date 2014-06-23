This is a simple Go and Laravel app that logs your usage of Sublime Text. It tracks your time that you spend per client, per project and displays it in an interface powered by Laravel.

# Installation

Installation is fairly simple. You will want to configure `config.json` for your DSN, editor and client names to watch.

Once set, do `go run src/main.go` or `go build src/main.go` and add it to your startup, or just run it as is. It will then begin watching and timing your activity.

You can then go to public/index.html to view the results in a UI powered by AngularJS.
