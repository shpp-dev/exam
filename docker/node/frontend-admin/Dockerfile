FROM node:14

RUN npm install -g http-server

WORKDIR /project/frontend-admin

COPY site/frontend-admin ./

RUN npm install && npm run build

EXPOSE 8080

CMD [ "http-server", "dist" ]
