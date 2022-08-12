module themis

go 1.16

require (
	github.com/go-sql-driver/mysql v1.6.0
	github.com/gorilla/mux v1.8.0
	github.com/tidwall/gjson/164 v0.0.0-00010101000000-000000000000
	github.com/tidwall/gjson/193 v0.0.0-00010101000000-000000000000
)

replace github.com/tidwall/gjson/164 => github.com/tidwall/gjson v1.6.4

replace github.com/tidwall/gjson/193 => github.com/tidwall/gjson v1.9.3
