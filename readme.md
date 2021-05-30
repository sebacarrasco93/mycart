# MyCart for Laravel

An open source, simple in syntax, and ready to use package for Shopping Carts managing with Sessions from Backend, with Laravel.

### Requirements

- Laravel 8 or above

### Installation

```bash
composer require sebacarrasco93/mycart
```

### Usage

Adding item(s):

```php
$itemOne = [
    'uuid' => '111AAA',
    'name' => "Lemon Waffle by SoloWaffles",
    'price' => '8.99'
];
$itemTwo = [
    'uuid' => '222BBB',
    'name' => "Mixed Waffle by SoloWaffles",
    'price' => '9.95'
];

MyCart::add($itemOne);
MyCart::add($itemTwo);
```

Getting item(s):

```php
return MyCart::get(); // returns an array [$itemOne, $itemTwo]
```

Counting item(s):

```php
return MyCart::count(); // returns 2
```

Calculating total:

```php
return MyCart::total(); // returns 18.94
```

Finding by UUID:

```php
return MyCart::findByUuid('222BBB'); // returns $itemOne
```

### Example

You can find a Laravel implementation [here](https://github.com/sebacarrasco93/example-mycart)

### Default configuration

MyCart uses 3 names:

| Name         | Default value | What does it                 |
|--------------|---------------|------------------------------|
| SESSION_NAME | mycart        | Name of the mycart's session |
| ITEMS_NAME   | items         | Name of the key's session    |
| PRICE_NAME   | price         | Name of an item's price      |

### Custom configuration

Depending on what you need, you can prefer one or another solution. However, there are two ways to do this:

#### By setting .env keys

You need to copy and change these values:

```bash
MYCART_SESSION_NAME=your_custom_session_name
MYCART_ITEMS_NAME=your_custom_items_name
MYCART_PRICE_NAME=your_custom_price_field_name
```

#### By publishing a config file

Simply run:

```bash
php artisan vendor:publish --provider="SebaCarrasco93\MyCart\MyCartServiceProvider"
```

Laravel will publish a configuration file in `config/mycart.php`, so you can change the values by opening it.
```php
'session_name' => env('MYCART_SESSION_NAME', 'your_custom_session_name'),

'items_name' => env('MYCART_ITEMS_NAME', 'your_custom_items_name'),

'price_name' => env('MYCART_PRICE_NAME', 'your_custom_price_field_name'),
```

### Changing My Cart's lifetime

Since behind the scenes it works with Laravel's sessions, MyCart will work as another Laravel session.

So, for example, if you want to increase the maximum lifetime from default, 2 hours (120 minutes) to 24 hours (1440 minutes), the only thing you need to change is the `SESSION_LIFETIME` value in your project's `.env` file

Before (2 hours):

```bash
SESSION_LIFETIME=120
```

After (one day):

```bash
SESSION_LIFETIME=1440
```

Easy Peasy!

### Testing

```bash
./vendor/bin/pest
```
