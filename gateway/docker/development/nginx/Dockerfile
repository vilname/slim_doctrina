FROM nginx:1.19-alpine

RUN apk add --no-cache curl

COPY ./development/nginx/conf.d /etc/nginx/conf.d

WORKDIR /app
