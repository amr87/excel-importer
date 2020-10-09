# The Excel Importer

The Excel Importer is a tiny application for importing mircrosfot excel sheet into database;

## System Requirements

MYSQL & PHP & Laravel 5.7

## Installation

```bash
1- git clone git@github.com:amr87/excel-importer.git
2- cd excel-importer
3- composer install
4- mv .env.example .env
5- php artisan key:generate
6- php artisan migrate
7- php artisan db:seed
8- php artisan serve
```

## Usage

```bash
1- go to: http://localhost:8000
2- login with User: admin@mideastsoft.com & Password: secret
3- php artisan queue:work
```

## Testing

```bash
vendor/bin/phpunit
```
