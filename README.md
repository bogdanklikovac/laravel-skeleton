Laravel skeleton app
=====================

## Docker & General setup

- Laravel uses native "Laravel Sail" package for dockerized environment.

```
$ composer install-dev
```
Check composer.json scripts section for exact procedure of `install-dev`.

Now run
```
$ composer sail
```
to boot up the docker containers

NOTE:
- If you need to add custom arguments you can also run it as
```
./vendor/bin/sail up ARG1 ARG2 ...
```

## Database setup
First, run them migrations to create tables, foreign keys etc. Sail should create a database on the first run (build), 
so skip to the next command.
```
$ php artisan migrate
```
Then, you can load the seeders(fixtures) like this:
```
$ php artisan db:seed
```

# 2. Coding guidelines

## phpstan
Git hooks will run phpstan check on all staged files on every commit and on every push. You will not be allowed
to push or commit stuff that does not match our standards. This is the way. If you want to run it manually,
just use the composer settings.
```
$ ./vendor/bin/phpstan analyse --memory-limit=2G
```
See `composer.json` for more details.
## csfixer
Git hooks will also run CodeStyle Fixer to make you follow our code style standars as well,
and you can always run it manually to fix things.
```
$ vendor/bin/php-cs-fixer fix --config=php-cs-fixer.php -v
```
Again, see `composer.json` for more details.
Also to make this 2 commands easier to run make bash aliases:
```
alias sailphpstan="./vendor/bin/phpstan analyse --memory-limit=2G"
alias sailcs="./vendor/bin/php-cs-fixer fix --config=php-cs-fixer.php -v"
```
and reload your .bashrc or .zshrc file like so:
```
$ source ~/.bashrc
```

## Tools
You can use Laravel Telescope to make performance metrics or debug your requests, exceptions, databases, cache, events and much more
in real time by accessing a specific route in your local environment
```
http://localhost/telescope
```
