# Snowbody Knows

A secret santa wishlist builder.

I’m building a secret Santa app for my family to during the holidays. A user can build a wishlist and everybody else can check things off of it without the user being able to see.

## Installation

Step one is to clone this repo:

```sh
git clone https://github.com/imacrayon/snowbodyknows
cd snowbodyknows
```

If you're looking to get started quickly we recommend using our [Docker setup](#docker-setup). If you already have PHP (>= 7.2.0), PHP Composer, SQLite3, and NPM on your machine you can follow our [basic setup](#basic-setup) steps.

### Docker Setup

1. With Docker installed on your machine, start up a docker container:

```sh
./vendor/bin/sail up
```

Check the [Laravel Sail](https://laravel.com/docs/10.x/sail) documentation for command line details.

### Basic Setup

1. Install PHP dependencies:

    ```sh
    composer install
    ```

2. Install NPM dependencies:

    ```sh
    npm install
    ```

3. Build assets:

    ```sh
    npm run dev
    ```

4. Create a SQLite database: (You can also use another database [MySQL, Postgres], simply [update your configuration accordingly](https://laravel.com/docs/master/database#configuration))

    ```sh
    touch database/database.sqlite
    ```

5. Copy the environment config example and rename it to `.env`:

    ```sh
    cp .env.example .env
    ```

6. Generate an application key:

    ```sh
    php artisan key:generate
    ```

7. Run database migrations:

    ```sh
    php artisan migrate
    ```

8. Start the built-in web server:

    ```sh
    php artisan serve
    ```

You're ready to go! Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.
