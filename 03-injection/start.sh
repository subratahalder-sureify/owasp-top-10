#!/bin/bash

export GOROOT=/usr/local/go

if [[ "$1" == 'bash' ]]; then
  echo "Build bash command"
  /bin/sh -c bash
fi

if [[ "$1" == 'init' ]]; then
  until mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PWD" -e "SELECT 1"; do
    >&2 echo "Waiting for mysql. This may take few more seconds ..."
    sleep 3
  done

  >&2 echo "mysql is up - executing command"

  echo "create database $DB_DB"
  mysql -v -u "$DB_USER" -p"$DB_PWD" -h "$DB_HOST" -e "CREATE DATABASE IF NOT EXISTS ${DB_DB}"

  echo "import base"
  mysql -v -u "$DB_USER" -p"$DB_PWD" -h "$DB_HOST" -D "$DB_DB" < base.sql
fi

if [[ -z "$1" ]]; then
  cd "/go/src/octave"

  export GOFLAGS=-mod=vendor
  bin/CompileDaemon -exclude-dir=.git -build="go build -o ./octave main.go" -command="./octave"
fi
