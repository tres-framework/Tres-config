<?php

namespace Tres\config {
    
    use Exception;
    
    class PackageException extends Exception {}
    class ConfigException extends Exception {}
    
    /**
     * Configuration class.
     * 
     * Gets the configuration from a certain file.
     */
    class Config {
        
        /**
         * The minimum required PHP version.
         */
        const MIN_PHP_VERSION = 5.4;
        
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
        
        // Prevent instantiation
        private function __construct(){}
        private function __clone(){}
        
        /**
         * Checks the PHP version.
         */
        protected static function _checkPHPVersion(){
            if(!version_compare(PHP_VERSION, self::MIN_PHP_VERSION, '>=')){
                throw new PackageException('PHP version must be greater than '.self::MIN_PHP_VERSION.'.');
            }
        }
        
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
            self::_checkPHPVersion();
            
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
