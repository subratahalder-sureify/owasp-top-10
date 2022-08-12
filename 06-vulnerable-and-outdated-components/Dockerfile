FROM golang:1.16-alpine AS gobase

RUN apk -v --update add \
	bash \
	build-base \
	pkgconfig && rm -rf /var/cache/apk/*

ENV GO111MODULE=on
ENV GOSUMDB=sum.golang.org
ENV GOPROXY=https://proxy.golang.org,direct

WORKDIR /go

ADD . .

ENTRYPOINT ["./start.sh"]
