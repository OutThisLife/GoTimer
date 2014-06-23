package main

import (
	"fmt"
	"time"
	"reflect"
)

func main() {
	fmt.Println(reflect.TypeOf(time.Now().Format("2006-01-02 15:04:05")))
}