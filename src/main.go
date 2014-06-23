package main

import (
	"time"

	cfg "./config"
	serv "./server"
	win "./window"
	db "./database"
)

func TitleListener(ch *chan string) {
	var lastT string

	for {
		valid, t := win.GetForegroundTitle()

		if valid && lastT != t {
			*ch <- t
			lastT = t
		}
	}
}

func main() {
	chTitle := make(chan string, 1)
	p := &db.Trail{}

	go TitleListener(&chTitle)
	go serv.BeginRest()

	for { select {
		// New path timer, save current
		case t := <-chTitle:
			if len(p.Path) > 0 {
				db.SavePath(p)
			}

			p = &db.Trail{
				ClientName: cfg.Data.ParseClient(t),
				Path: t,
				Time: 1,
				Date: time.Now().Format("2006-01-02 15:04:05"),
			}

		// Add time to currently read path
		default:
			if len(p.Path) > 0 {
				p.Time += 1
			}

			time.Sleep(time.Second)
	} }
}