# Learn Laravel Passport

## How to run this crap

Build and run containers

```
docker compose up --build -d
```

Install composer dependencies

```
docker exec -it app composer install
```

Enjoy your application on `localhost:89`

## Passport setup

Add laravel/passport as a dependency with composer

```
docker exec app composer require laravel/passport
```

Install passport

```
docker exec app composer require php artisan passport:install
```

Set the following enviroment variables accordingly with the clients secrets

```
PASSPORT_CLIENT_SECRET_1=
PASSPORT_CLIENT_SECRET_2=
```

## Reference

- [Laravel Passport](https://laravel.com/docs/8.x/passport)