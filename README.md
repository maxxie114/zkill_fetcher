# zkill_fetcher

zkill fetcher is a backend application written in PHP that gets zkillboard killmail from RedisQ and parse it into a database, for analyzation.

## Requirement

1. It is recommended to run this program on a linux environment
2. This application require the installation of mysql database, php-mysql and screen.
3. Run the schema.sql in the mysql console to create the schema needed for this program. 

## Usage
- First edit these four lines in zkill_fetch.php your database's username and password. 
```php
$host = "localhost";
$db_name = "killmail";
$username = "fetcher";
$password = "Password!_35";
```

- After that, run this command in screen on start the program 
```bash
php -f zkill_fetch.php
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://github.com/maxxie114/zkill_fetcher/blob/main/LICENSE)
