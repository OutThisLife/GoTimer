package config

import (
	"encoding/json"
	io "io/ioutil"
	s "strings"
)

var (
	Data ConfigData
)

type ConfigData struct {
	DSN string
	Editor string
	ClientFolders []string
}

func (c *ConfigData) GetDSN() string {
	return c.DSN
}

func (c *ConfigData) GetEditor() string {
	return c.Editor
}

func (c *ConfigData) GetClients() []string {
	return c.ClientFolders
}

func (c *ConfigData) ParseClient(t string) string {
	client := string("null")

	for _, cf := range c.ClientFolders {
		if s.Contains(t, cf) {
			client = cf
		}
	}

	return client
}

func init() {
	file, err := io.ReadFile("config.json")

	if err != nil {
		panic(err.Error())
	}

	json.Unmarshal(file, &Data)
}