FROM node:12.22-alpine

WORKDIR /src

RUN npm install -g npm

COPY . .
