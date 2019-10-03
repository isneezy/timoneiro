![Timoneiro Logo](resources/assets/images/logo.png)

Inspired by [django admin](https://github.com/django/django/tree/master/django/contrib/admin)
and [Laravel Voyager](https://voyager.devdojo.com/), Timoneiro is a Laravel Admin Package to make your life easier.

Website and documentation: [Todo]()

<hr>

## Installation
**1. Require the package via compose**  

```bash
composer require isneezy/timoneiro
```
**2. Register the Service Provider**  

In `conf/app.php` file of your laravel project register the `TimoneiroServiceProvider`
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

**4. Register composer development repo in your `package.json` file as follow:**

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

**6. Happy codding** :man_technologist:


