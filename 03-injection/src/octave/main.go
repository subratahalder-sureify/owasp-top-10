package main

import (
	"database/sql"
	"encoding/json"
	"fmt"
	"log"
	"net/http"
	"os"
	"time"

	_ "github.com/go-sql-driver/mysql"
	"github.com/gorilla/mux"
)

type Customer struct {
	CustCode       string  `json:"cust_code"`
	CustName       string  `json:"cust_name"`
	CustCity       string  `json:"cust_city"`
	WorkingArea    string  `json:"working_area"`
	CustCountry    string  `json:"cust_country"`
	Grade          int64   `json:"grade"`
	OpeningAmt     float64 `json:"opening_amt"`
	ReceiveAmt     float64 `json:"receive_amt"`
	PaymentAmt     float64 `json:"payment_amt"`
	OutstandingAmt float64 `json:"ourstanding_amt"`
	PhoneNo        string  `json:"phone_no"`
}

var db *sql.DB

func main() {
	r := mux.NewRouter()
	s := r.PathPrefix("/api/v1/octave").Subrouter()
	s.HandleFunc("/customers", getCustomerByID)
	s.HandleFunc("/scustomers", getSecureCustomerByID)

	srv := &http.Server{
		Handler:      r,
		Addr:         ":80",
		WriteTimeout: 15 * time.Second,
		ReadTimeout:  15 * time.Second,
	}
	log.Printf("http server Running on http://:80")
	log.Fatal(srv.ListenAndServe())
}

func getCustomerByID(w http.ResponseWriter, r *http.Request) {
	_ = r.ParseForm()
	id := r.Form.Get("id")
	log.Println(id)

	q := fmt.Sprintf("SELECT * FROM customers WHERE cust_code = %s", id)
	log.Println(q)
	rows, err := db.Query(q)
	if err != nil {
		log.Fatal(err)
	}

	customers := make([]*Customer, 0)
	//if rows.NextResultSet() {
	for rows.Next() {
		c := new(Customer)
		if err := rows.Scan(&c.CustCode, &c.CustName, &c.CustCity, &c.WorkingArea, &c.CustCountry, &c.Grade, &c.OpeningAmt, &c.ReceiveAmt, &c.PaymentAmt, &c.OpeningAmt, &c.PhoneNo); err != nil {
			log.Fatal(err)
		}
		customers = append(customers, c)
	}
	//}

	j, _ := json.MarshalIndent(customers, "", "  ")
	w.Header().Set("Content-Type", "application/json")
	_, _ = w.Write(j)
}

func getSecureCustomerByID(w http.ResponseWriter, r *http.Request) {
	_ = r.ParseForm()
	id := r.Form.Get("id")
	log.Println(id)

	rows, err := db.Query("SELECT * FROM customers WHERE cust_code = ?", id)
	if err != nil {
		log.Fatal(err)
	}

	customers := make([]*Customer, 0)
	//if rows.NextResultSet() {
	for rows.Next() {
		c := new(Customer)
		if err := rows.Scan(&c.CustCode, &c.CustName, &c.CustCity, &c.WorkingArea, &c.CustCountry, &c.Grade, &c.OpeningAmt, &c.ReceiveAmt, &c.PaymentAmt, &c.OpeningAmt, &c.PhoneNo); err != nil {
			log.Fatal(err)
		}
		customers = append(customers, c)
	}
	//}

	j, _ := json.MarshalIndent(customers, "", "  ")
	w.Header().Set("Content-Type", "application/json")
	_, _ = w.Write(j)
}

func init() {
	var err error
	if db, err = sql.Open("mysql", fmt.Sprintf("%v:%v@tcp(%v)/%v?multiStatements=true", os.Getenv("DB_USER"), os.Getenv("DB_PWD"), os.Getenv("DB_HOST"), os.Getenv("DB_DB"))); err != nil {
		log.Fatalf("failed to connect to db\n")
	}
}
