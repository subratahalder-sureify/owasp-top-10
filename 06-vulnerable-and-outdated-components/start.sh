#!/bin/bash

export GOROOT=/usr/local/go

if [[ "$1" == 'bash' ]]; then
  echo "Build bash command"
  /bin/sh -c bash
fi

if [[ -z "$1" ]]; then
  cd "/go/src/themis"

  export GOFLAGS=-mod=vendor
  bin/CompileDaemon -exclude-dir=.git -build="go build -o ./themis main.go" -command="./themis"
fi
