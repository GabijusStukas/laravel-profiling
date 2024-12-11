<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Profiling

### Technology used

- PHP 8.4 (composer requires ^8.2)
- Laravel 11
- Composer 2.8.3
- Docker 27.3.1

### Installation

1. Clone the repository
2. Run `make install`
3. Run `cp .env.example .env`
4. Populate `PROXYCHECK_API_KEY` field in `.env` file with your [Proxycheck.io](https://proxycheck.io/) API key
5. Run `make up`
6. Run `make migrate`


### Documentation

Docs are powered by [Swagger](https://swagger.io/).

Run `make docs` to generate the docs and access them via `/api/documentation` route

### Testing

Tests can be run using `make test` or `make test-coverage` to generate a coverage report

