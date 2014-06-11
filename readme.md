# GoTracker

This is a simple Go and Laravel app that logs your usage of Sublime Text. It tracks your time that you spend per client, per project and displays it in an interface powered by Laravel.

## Installation

First, you will need to run this on a server with a MySQL server. You'll also need to create a database dedicated for this app, and then configure the database information in:

```
src/database/database.go:21
app/config/database.php
```

Once that's done, you should also run a `composer update` in the root. Then run `go build src/tracker/tracker.go && ./tracker` to begin tracking your time.

## Setting up the clients

You'll need to add a few clients based on their path directory. For example:

"Client ABC" would count towards paths that look like `/var/www/Client ABC/project-name/...` it will take the folder next to the client name as the project name. It'll then log all the time you spend there per file under the project, adding up to the total in the interface.