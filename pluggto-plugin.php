<?php

/*
    **Plugin Name: Pluggto
    **Description: Mlovi - Pluggto plugin for woocommerce
    **Version: 1.0.0
    **Text Tomain: pluggto_plugin
*/

/*ALWAYS SET PREFIX WITH PLUGIN NAME FIRST LETTERS OF EACH WORD. (ex.: PLUGGTO PLUGIN = PP   ->   PP_path, PP_url) */

defined('ABSPATH') or die("You can't acess directly");

if(file_exists((dirname(__FILE__) . '/vendor/autoload.php'))){
    require_once((dirname(__FILE__) . '/vendor/autoload.php'));
}

/*
**Define main path and url
*/
define( 'PP_BASENAME', plugin_basename(__FILE__));
define( 'PP_PATH', plugin_dir_path((__FILE__)));
define( 'PP_URL', plugin_dir_url(__FILE__));
define( 'TABLENAME', 'wp_pluggto_plugin');
use Inc_PP\Init;
use Inc_PP\Base\Activate;
use Inc_PP\Base\Deactive;
use Inc_PP\Database\KeysTable;

function activate_pp_plugin(){
    Activate::activate();
}

function deactivate_pp_plugin(){

    Deactive::deactivate();
}
function create_pp_table(){
    KeysTable::create_pp_table();
}

register_activation_hook(__FILE__, 'activate_pp_plugin');
register_deactivation_hook(__FILE__, 'deactivate_pp_plugin');
register_activation_hook(__FILE__, 'create_pp_table');




if(class_exists('Inc_PP\\Init')){

    Init::register_services();


}