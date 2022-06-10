# Quick Start Project

### Step by step
Clone this Repository
```sh
git clone https://github.com/huseynvsal/Bonds-and-Orders.git task-project
```

Create the .env file
```sh
cd task-project/
cp .env.example .env
```


Update environment variables in .env
```dosini
APP_NAME="Name Your Project"
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=name_you_want_db
DB_USERNAME=root
DB_PASSWORD=root
```


Create tables
```sh
php artisan migrate
```


Seed data to tables
```sh
php artisan db:seed
```


Install project dependencies
```sh
composer install
```


Generate the Laravel project key
```sh
php artisan key:generate
```

Start the project
```sh
php artisan serve
```

Access the project
[http://localhost:8080](http://localhost:8080)
