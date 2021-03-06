<?php

use Tres\config\Config;
use Tres\config\PackageInfo;

error_reporting(-1);
ini_set('display_errors', 1);

spl_autoload_register(function($class){
    $dirs = [
        dirname(__DIR__).'/src/'
    ];
    
    foreach($dirs as $dir){
        $file = str_replace('\\', '/', rtrim($dir, '/').'/'.$class.'.php');
        
        if(is_readable($file)){
            require_once($file);
            break;
        }
    }
});

Config::$errors = true;

Config::add('config', 'config/config-one.php');
Config::add('config 2', 'config/config2.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8" />
        
        <title>Tres Config package</title>
        
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        <style type="text/css">
        body {
            font: 12pt Arial;
        }
        </style>
    </head>
    <body>
        <?php
        echo '<h1>'.Config::get('config/name').'</h1>';
        
        echo '<pre>';
            print_r(Config::get('config'));
            echo '<br /><br />';
            print_r(Config::get('config 2'));
            echo '<br /><br />';
            print_r(PackageInfo::get());
        echo '</pre>'
        ?>
    </body>
</html>
