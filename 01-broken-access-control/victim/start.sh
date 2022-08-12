#!/bin/bash

export GOROOT=/usr/local/go

if [[ "$1" == 'bash' ]]; then
  echo "Build bash command"
  /bin/sh -c bash
fi

if [[ -z "$1" ]]; then
  cd "/go/src/durga"

  export GOFLAGS=-mod=vendor
  bin/bee generate routers
  bin/bee run -runmode dev -e pkg
fi
