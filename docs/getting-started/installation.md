## Installation
At your terminal go to your project folder and require timoneiro package:
```bash
cd path/to/project
composer require isneezy/timoneiro
```

In `conf/app.php` file of your laravel project, register the `TimoneiroServiceProvider`
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

Next make sure to create a new database and add your database credentials to your `.env` file.
```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

And we are good to go!


