# zkill_fetcher

zkill fetcher is a backend application written in PHP that gets zkillboard killmail from RedisQ and parse it into a database, for analyzation.

## Installation

1. It is recommended to run this program on a linux environment, so I will only put linux instruction here
2. This application require the installation of mysql database, php-mysql and screen.
```bash
sudo apt-get install screen mysql php-mysql
```
3. Run the schema.sql in the mysql console to create the schema, users, and databases needed for this program. 
```bash
sudo mysql -h 'localhost' -u 'root' -p < schema.sql
```

## Usage

- After that, run this command in "screen" to start the program 
```bash
./start.sh
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://github.com/maxxie114/zkill_fetcher/blob/main/LICENSE)
