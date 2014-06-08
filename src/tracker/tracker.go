package main

import (
	"time"
	s "strings"

	win "../window"
	db "../database"
)

func Listen(ch *chan string) {
	var lastT string

	for {
		valid, t := win.ForegroundTitle()

		if valid && lastT != t {
			*ch <- t
			lastT = t
		}
	}
}

func ExtractClient(t string) int {
	client := int(-1)

	for id, name := range db.GetRows("SELECT * FROM clients") {
		if s.Contains(t, name) {
			client = id
		}
	}

	return client
}

func main() {
	chTitle := make(chan string, 1)
	p := &db.Path{}

	go Listen(&chTitle)

	for { select {
		// New path timer, save current
		case t := <-chTitle:
			if len(p.Path) > 0 {
				db.SavePath(p)
			}

			p = &db.Path{
				ClientID: ExtractClient(t),
				Path: t,
				Time: 1,
				Date: time.Now().Unix(),
			}

		// Add time to current read path
		default:
			if len(p.Path) > 0 {
				p.Time += 1
			}

			time.Sleep(time.Second)
	} }
}