<?php
namespace Inc_PP\Classes;

use Automattic\WooCommerce\Client;
use Inc_PP\Database\Db;

require_once('../../vendor/autoload.php');

class Stock{

    public function update($sku, $quantity){
        $db = new Db();
        $keys = $db->selectAll();
        /*
        ** Generate refresh token and store on $bearerToken
        */
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', "https://api.plugg.to/oauth/token/", [
            'form_params' => [
                'client_id' => $keys[0]->client_id,
                'client_secret' => $keys[0]->client_secret,
                'username' => $keys[0]->username,
                'password' => $keys[0]->pass,
                'grant_type' => 'password'
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'accept' => 'application/json',
            ],
        ]);

        $token = json_decode($response->getBody(), true);
        $bearerToken = $token['access_token'];


        $response = $client->request('PUT', "https://api.plugg.to/skus/{$sku}/stock", [
            'body' => '{"action":"update","quantity":'.$quantity.',"sku":'.$sku.'}',
            'headers' => [
              'Accept' => 'application/json',
              'Authorization' =>"Bearer {$bearerToken}",
              'Content-Type' => 'application/json',
            ],
          ]);
        
          echo $response->getBody();
  


    }
}