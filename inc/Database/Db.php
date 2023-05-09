<?php

namespace Inc_PP\Database;

require_once(__FILE__.'../../../../../../../wp-load.php');

class Db{

    public function selectAll(){
            
            global $wpdb;
            $max_id = $wpdb->get_var( 'SELECT MAX(id) FROM ' . TABLENAME );
            $result = $wpdb->get_results( "SELECT * FROM ". TABLENAME." WHERE id =  '". $max_id ."'");

            return $result;
        }


    public function insert($api_url, $api_ck, $api_cs, $client_id, $client_secret, $username, $password){
        global $wpdb;
        $tablename = TABLENAME;
        $sql = $wpdb->prepare(
            "INSERT INTO $tablename (`api_url`, `api_ck`, `api_cs`, `client_id`, `client_secret`, `username`, `pass`) values (%s, %s,%s, %s, %s,%s, %s)", $api_url, $api_ck, $api_cs, $client_id, $client_secret, $username, $password
        );
        
        $wpdb->query($sql);
        
        if($wpdb->last_error){
            echo $wpdb->last_error;
        }      
    }
}