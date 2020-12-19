# zkill_fetcher

zkill fetcher is a backend application written in PHP that gets zkillboard killmail from RedisQ and parse it into a database, for analyzation.

## Requirement

This application require the installation of sqlite3.

Run the schema.sql in the sqlite3 console to create the schema needed for this program. 

## Usage

```bash
php -f zkill_fetch.php
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)
