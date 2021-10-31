# Matcher

## Task
- find all relevant search profiles for the property and return them in the correct order.  
- implement the synchronous Request-Response pattern (No dispatched background jobs)

## Installation

### Install locally on your machine
- Ensure you have installed on your machine:
    - PHP server
    - Apache server
    - Mysql server

#### Clone this repo

```bash
$ git clone https://www.github.com/prince-curie/matcher.git
$ cd matcher
```

#### Move to a service directory
```bash
$ cd matcher-property
```

#### Install dependencies
```bash
composer install
```

#### Update .env file
- Create a .env file
- Copy all contents from the .env.example file into the .env file
- Update the database fields with the appropriate values.

#### App Key
```bash
$ php artisan key: generate
```
#### Run Migration and Seed
```bash
$ php artisan migrate --seed
```

#### Start the server
```bash
$ php artisan serve
```
N.B: Open a new terminal and move into the other service directory and repeat the process again from installing directories.
