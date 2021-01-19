FROM node:current-alpine

RUN apk update && apk add python make g++

RUN mkdir -p /project/frontend

COPY frontend /project/frontend

RUN cd /project/frontend && npm install

WORKDIR /project/frontend

CMD npm run serve
