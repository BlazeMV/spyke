<?php

namespace Blaze\Spyke\Services;

use Blaze\Spyke\Exceptions\ConfigException;

class ConfigService
{
    /**
     * returns telegram bot api url
     *
     * @return string
     */
    public static function getOmdbApiUrl()
    {
        return 'https://omdbapi.com';
    }
    
    /**
     * validates a config array
     *
     * @param array $config
     * @throws ConfigException
     */
    public static function validateConfig(array $config)
    {
        $required = [
            'api_key'
        ];
        $string = [
            'api_key',
        ];
        $boolean = [

        ];
        $array = [

        ];
        $regex = [

        ];
        
        foreach ($required as $item) {
            if (!array_has($config, $item)) {
                throw new ConfigException("Required config value $item is missing from the config array.");
            }
        }
        
        foreach ($string as $item) {
            if (!array_has($config, $item)) {
                continue;
            }
            
            if (!is_string(array_get($config, $item)) || strlen(array_get($config, $item)) < 1) {
                throw new ConfigException("$item is expected to be a string.");
            }
        }
        
        foreach ($boolean as $item) {
            if (!array_has($config, $item)) {
                continue;
            }
            
            if (!is_bool(array_get($config, $item))) {
                throw new ConfigException("$item is expected to be a boolean true or false.");
            }
        }
        
        foreach ($array as $item) {
            if (!array_has($config, $item)) {
                continue;
            }
            
            if (!is_array(array_get($config, $item))) {
                throw new ConfigException("$item is expected to be an array.");
            }
        }
        
        foreach ($regex as $item => $pattern) {
            if (!array_has($config, $item)) {
                continue;
            }
            
            if (preg_match($pattern, array_get($config, $item)) !== 1) {
                throw new ConfigException("$item does not match the required pattern");
            }
        }
    }
}
