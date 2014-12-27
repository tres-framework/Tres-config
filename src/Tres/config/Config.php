<?php

namespace Tres\config {
    
    use Exception;
    
    class ConfigException extends Exception {}
    
    /*
    |-------------------------------------------------------------------------
    | Configuration management
    |-------------------------------------------------------------------------
    | 
    | This class gives the option to get some configurations and make it 
    | accessible throughout the application.
    | 
    */
    class Config {
        
        /**
         * The path delimiter.
         */
        const DELIMITER = '/';
        
        /**
         * Whether to show config related errors or not.
         * 
         * @var bool
         */
        public static $errors = false;
        
        /**
         * The paths to the configuration files.
         * 
         * @var array
         */
        protected static $_paths = [];
        
        // Prevents instantiation.
        private function __construct(){}
        private function __clone(){}
        
        /**
         * Adds a configuration set to the list of configurations.
         * 
         * @param string $alias An alias for the configuration.
         * @param string $path  The path to the configuration.
         */
        public static function add($alias, $path){
            self::$_paths = array_merge(self::$_paths, [$alias => $path]);
        }
        
        /**
         * Gets the requested configuration.
         * 
         * @param  string $path The path to the configuration.
         * @return mixed        On success: configuration value.
         *                      On failure: null.
         */
        public static function get($path){
            $path = trim($path, self::DELIMITER);
            $configName = explode(self::DELIMITER, $path)[0];
            $value = null;
            
            if(isset(self::$_paths[$configName])){
                if(is_readable(self::$_paths[$configName])){
                    $config = require(self::$_paths[$configName]);
                    $value = $config;
                    $splitPath = explode(self::DELIMITER, $path);
                    
                    foreach($splitPath as $part){
                        if(isset($value[$part])){
                            $value = $value[$part];
                        }
                    }
                } else {
                    if(self::$errors){
                        throw new ConfigException('Config file is not readable. Does it exist?');
                    }
                    
                    //TODO: Log error
                }
            } else {
                if(self::$errors){
                    throw new ConfigException('Config "'.$configName.'" not found.');
                }
                
                //TODO: Log error
            }
            
            return $value;
        }
        
    }
    
}
