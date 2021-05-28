# MyCart for Laravel

An open source, simple syntax, and ready to use package for manage Shopping Carts with Sessions from Backend with Laravel.

## Requirements

- Laravel 8 or above

## Installation

```sh
composer require sebacarrasco93/mycart
```

## Example

You can find a Laravel implementation [here](https://github.com/sebacarrasco93/example-mycart)

## Default configuration

MyCart uses 3 names:

| Name         | Default value | What does it                 |
|--------------|---------------|------------------------------|
| SESSION_NAME | mycart        | Name of the mycart's session |
| ITEMS_NAME   | items         | Name of the key's session    |
| PRICE_NAME   | price         | Name of an item's price      |

## Custom configuration

Depending on what you need, you can prefer one or another solution. However, there are two ways to do this:

### By setting .env keys

You need to copy and change these values:

```sh
MYCART_SESSION_NAME=your_custom_session_name
MYCART_ITEMS_NAME=your_custom_items_name
MYCART_PRICE_NAME=your_custom_price_field_name
```

### By publishing a config file

Simply run:

```sh
php artisan vendor:publish --provider="SebaCarrasco93\MyCart\MyCartServiceProvider"
```

Laravel will publish configuration file in `config/mycart.php`, so you can change the values by opening it.
```php
'session_name' => env('MYCART_SESSION_NAME', 'your_custom_session_name'),

'items_name' => env('MYCART_ITEMS_NAME', 'your_custom_items_name'),

'price_name' => env('MYCART_PRICE_NAME', 'your_custom_price_field_name'),
```
