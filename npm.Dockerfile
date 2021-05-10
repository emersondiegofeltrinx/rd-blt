FROM node:12.22-alpine

RUN npm install

WORKDIR /src

COPY . .
