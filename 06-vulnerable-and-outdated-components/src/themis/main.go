package main

import (
	"encoding/json"
	"io"
	"log"
	"net/http"
	"time"

	_ "github.com/go-sql-driver/mysql"
	"github.com/gorilla/mux"
	ogjson "github.com/tidwall/gjson/164"
	ngjson "github.com/tidwall/gjson/193"
)

func main() {
	r := mux.NewRouter()
	s := r.PathPrefix("/api/v1/themis").Subrouter()
	s.HandleFunc("/join1", joinObjects1)
	s.HandleFunc("/join2", joinObjects2)

	srv := &http.Server{
		Handler:      r,
		Addr:         ":80",
		WriteTimeout: 15 * time.Second,
		ReadTimeout:  15 * time.Second,
	}
	log.Printf("http server Running on http://:80")
	log.Fatal(srv.ListenAndServe())
}

func joinObjects1(rw http.ResponseWriter, r *http.Request) {
	bodyBytes, _ := io.ReadAll(r.Body)
	var m map[string]interface{}
	_ = json.Unmarshal(bodyBytes, &m)
	obj, _ := m["obj"].(string)

	res := ogjson.Get(obj, `@this|@join:{"preserve":true}`)
	v := res.Value()
	j, _ := json.Marshal(v)
	_, _ = rw.Write(j)
}

func joinObjects2(rw http.ResponseWriter, r *http.Request) {
	bodyBytes, _ := io.ReadAll(r.Body)
	var m map[string]interface{}
	_ = json.Unmarshal(bodyBytes, &m)
	obj, _ := m["obj"].(string)

	res := ngjson.Get(obj, `@this|@join:{"preserve":true}`)
	v := res.Value()
	j, _ := json.Marshal(v)
	_, _ = rw.Write(j)
}
