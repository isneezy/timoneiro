# Configuration
After you finish the installation of Timoneiro, you'll find a new confiuration file at `config/timoneiro.php`.
This is the file were you can change/configure the behaviour of your package installation.

## Models
Todo document
## Controllers
Todo document
## Dashboard
Todo document
### Widgets
Todo document
### Settings
```php
<?php
return [
    'settings' => [
        'Exchange Rates' => [
          'exchange-rate-usd' => ['type' => 'text', 'display_name' => 'USD'],
          'exchange-rate-zar' => ['type' => 'text',  'display_name' => 'ZAR'],
        ],
    ],
];
```
You can configure some variables/settings that your application will need to use and a panel with 
editing capabilities will be generated so you can manage your settings.  
`type` the data type of the setting  
`display_name` the name that will be used to display the input label
