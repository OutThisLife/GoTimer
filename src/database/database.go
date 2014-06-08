package database

import (
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

func GetRows(query string) map[int]string {
	rows, err := db.Query(query)
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
		insert, err := db.Prepare("INSERT INTO testing_table VALUES (?, ?, ?, ?, ?)")
		CheckError(err)

		defer insert.Close()
		insert.Exec(0, p.ClientID, p.Path, p.Time, p.Date)
	}
}

func CheckError(err error) {
	if err != nil {
		panic(err.Error())
	}
}