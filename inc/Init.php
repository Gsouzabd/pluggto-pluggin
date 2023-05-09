<?php

namespace Inc_PP;



final class Init{

    /**
     * Store all the classes inside an array
     */
    public static function get_services(){
        return[
            Api\SettingsApi::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class,
            Base\Functions::class,
            Pages\Admin::class,

        ];
    }

    /**
     * Loop throug the classes, 
     * initialize them and call the register() method if it exists
     */
    public static function register_services(){

        foreach(self::get_services() as $class){
            $service = self::instantiate($class);
            if(method_exists($service, 'register')){
                $service->register();
            }
        }

    }

    /**
     * Initialize the class
     */
    private static function instantiate($class){
        $service = new $class();
         return $service;
    }
}



