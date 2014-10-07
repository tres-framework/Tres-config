Tres config
=============

This is the configuration package used for the [Tres Framework](https://github.com/pedzed/Tres). 
It can be used without the main framework.

## Example usage
```php
<?php 

require_once('packages/Tres/config/Config.php');

use packages\Tres\config\Config;

Config::$errors = true;

Config::add('db', '/var/www/secure-config/database.php');
Config::add('app', 'config/app.php');

echo '<h1>'.Config::get('app/name').'</h1>';

echo 'Host: '.Config::get('db/host').'<br />';
echo 'User: '.Config::get('db/user').'<br />';
echo 'Password: '.Config::get('db/password').'<br />';
echo 'Database: '.Config::get('db/name').'<br />';
```
