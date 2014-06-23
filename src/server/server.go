package server

import (
	"github.com/ant0ine/go-json-rest/rest"
	"log"
	"net/http"

	cfg "../config"
	db "../database"
)

func BeginRest() {
	h := rest.ResourceHandler{}

	err := h.SetRoutes(
		&rest.Route{"GET", "/", func (w rest.ResponseWriter, req *rest.Request) {
			w.Header().Set("Access-Control-Allow-Origin", "*")
			w.WriteJson(db.DumpData())
		}},

		&rest.Route{"GET", "/clients", func (w rest.ResponseWriter, req *rest.Request) {
			w.Header().Set("Access-Control-Allow-Origin", "*")
			w.WriteJson(cfg.Data.GetClients())
		}},
	)

	if err != nil {
		log.Fatal(err)
	}

	log.Fatal(http.ListenAndServe(":8080", &h))
}