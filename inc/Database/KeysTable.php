<?php

namespace Inc_PP\Database;

class KeysTable{
    public static function create_pp_table() {
        global $wpdb;
        $table_name = TABLENAME;
        $charset_collate = $wpdb->get_charset_collate();
        
        //Table definition
        $sql =  "CREATE TABLE $table_name (
        id int(10) unsigned NOT NULL AUTO_INCREMENT,
        api_url varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        api_ck varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        api_cs varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        client_id varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        client_secret varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        username varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        pass varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 
        PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        
        $res = dbDelta($sql);
        
    }


}