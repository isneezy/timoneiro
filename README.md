![Timoneiro Logo](resources/assets/images/logo.png)

Inspired by [django admin](https://github.com/django/django/tree/master/django/contrib/admin)
and [Laravel Voyager](https://voyager.devdojo.com/), Timoneiro is a Laravel Admin Package created to make your life easier.

Website and documentation: [https://timoneiro.vilanculo.me](https://timoneiro.vilanculo.me)

<hr>

## Installation
**1. Require the package via compose**  

```bash
composer require isneezy/timoneiro
```
**2. Register the Service Provider**

In `config/app.php` file of your laravel project, register the `TimoneiroServiceProvider`
```php
<?php
return [
    //... other configuration
    'providers' => [
        //... providers
        \Isneezy\Timoneiro\TimoneiroServiceProvider::class
        //... more providers
    ]
];
```

**3. Run the package installation command**
```bash
php artisan timoneiro:install
```
this will add Timoneiro routes on `routes/web.php` file
and your admin/control panel will be available at `/admin` route

## Development
**1. Fork this project**

**2. Create a fresh laravel application**

```bash
composer create-project --prefer-dist laravel/laravel timoneiro-app
cd timoneiro-app

```

**3. Clone your form into your local machine**

```bash
mkdir packages
cd packages && git clone git@github.com:user/timoneiro.git
```

**4. Register composer development repo in your `composer.json` file as follows:**

```json
{
    "repositories": {
        "timoneiro": {
            "type": "path",
            "url": "packages/timoneiro",
            "options": {
                "symlink": true
            }
        }
    }
}
```

**5. Follow the instructions in the [installation](#installation) section**

**6. Happy coding** :man_technologist:


