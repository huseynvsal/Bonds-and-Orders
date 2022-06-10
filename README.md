# API usage

### 1. Bond Interest Maturity Dates
Route
```sh
GET http://localhost:8000/api/bond/{id}/payouts
```
Put bond id as the number for {id} field.

### 2. Creating a Bond Purchase Order
Route
```sh
POST http://localhost:8000/api/bond/{id}/order
```
For this URL u need to set key value pair in ```Headers``` like:
```sh
key: Accept 
value: application/json
```
Put bond id as the number for {id} field.

### 3. Interest payments on the bond order
Route
```sh
POST http://localhost:8000/api/bond/order/{order_id}
```
Put order id as the number for {order_id} field.


### Possible issues
If you are having some problem to access API routes follow these steps:

1. Autoload Classmap
```sh
composer dump-autoload
```

2. Clear caches
```sh
php artisan optimize:clear
```

2. If your project is not running at all try to change host or port
```sh
php artisan serve --host=127.0.0.1 --port=8080
```
