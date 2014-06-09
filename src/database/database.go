package database

import (
	"time"
	"database/sql"
	_ "github.com/go-sql-driver/mysql"
)

var (
	db **sql.DB
)

type Path struct {
	ClientID int
	Path string
	Time int
	Date int64
}

func init() {
	con, err := sql.Open("mysql", "root@/gotest")
	CheckError(err)

	db = &con
}

func GetClients() map[int]string {
	rows, err := db.Query("SELECT id, name FROM clients")
	CheckError(err)
	defer rows.Close()

	data := make(map[int]string)

	for rows.Next() {
		var id int
		var name string

		err = rows.Scan(&id, &name)
		CheckError(err)

		data[id] = name
	}

	return data
}

func SavePath(p *Path) {
	if p.ClientID != -1 {
		insert, err := db.Prepare("INSERT INTO trails (client_id, path, time, created_at, updated_at) VALUES (?, ?, ?, ?, ?)")
		CheckError(err)

		defer insert.Close()

		tstamp := time.Now().Format("2006-01-02 15:04:05")
		insert.Exec(p.ClientID, p.Path, p.Time, tstamp, tstamp)
	}
}

func CheckError(err error) {
	if err != nil {
		panic(err.Error())
	}
}