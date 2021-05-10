# RD BLT

This is a incidents CRUD, a simple project.

## Installation

Clone this repository into any folder on your computer.

```
git clone https://github.com/emersondiegofeltrin/rd-blt.git
```
If you are using linux, make sure grant permission to write on folder where the project has been cloned.

Run the following commands:

### Create containers

```
docker-compose up --build -d
```
It takes a couple of minutes, depending of your computer's resources

### Copy environment file

#### Powershell
```
cp .env.example .env
```

#### Prompt
```
copy .env.example .env
```

### Install dependencies
```
docker exec rd-blt-app composer install
```

### Initialize database

```
docker exec rd-blt-app composer run initialize-database
```

### Run unit tests

```
docker exec rd-blt-app composer run run-php-unit
```

### Run lint

```
docker exec rd-blt-app composer run run-php-lint
```

## Access the project

After containers got up, access http://localhost:8000.
