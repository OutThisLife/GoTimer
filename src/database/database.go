package database

import (
	"database/sql"
	_ "github.com/go-sql-driver/mysql"

	cfg "../config"
)

var (
	db **sql.DB
)

type Trail struct {
	ID int
	ClientName string
	Path string
	Time int
	Date string
}

func init() {
	con, err := sql.Open("mysql", cfg.Data.GetDSN())
	CheckError(err)

	db = &con
}

func SavePath(p *Trail) {
	if p.ClientName != "null" {
		insert, err := db.Prepare("INSERT INTO `trails` (client, path, time, created_at) VALUES (?, ?, ?, ?)")
		CheckError(err)

		defer insert.Close()
		insert.Exec(p.ClientName, p.Path, p.Time, p.Date)
	}
}

func DumpData() []Trail {
	rows, err := db.Query("SELECT * FROM `trails`")
	CheckError(err)
	defer rows.Close()

	got := []Trail{}

	for rows.Next() {
		var r Trail

		err = rows.Scan(&r.ID, &r.ClientName, &r.Time, &r.Date, &r.Path)
		CheckError(err)

		got = append(got, r)
	}

	return got
}

func CheckError(err error) {
	if err != nil {
		panic(err.Error())
	}
}