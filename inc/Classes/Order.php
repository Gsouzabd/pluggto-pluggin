<?php

namespace Inc_PP\Classes;

use Automattic\WooCommerce\Client;
use Automattic\WooCommerce\HttpClient\HttpClientException;
use Inc_PP\Database\Db;

require_once('../../vendor/autoload.php');
class Order{

    public function create($orderId){
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

        // $woocommerce = new Client(
        //     'http://localhost/woocommerce/',
        //     'ck_813ce4f6976c8609999ced4a0687d42249e963f6',
        //     'cs_0e28952d65014ec8980b608569993832b3f2987d',
        //     [
        //         'version' => 'wc/v3',
        //         'wp_api' => true,
        //         'timeout' => 300
        //     ]
        // );
        $woocommerce = new Client(
            $keys[0]->api_url,
            $keys[0]->api_ck,
            $keys[0]->api_cs,
            [
                'version' => 'wc/v3',
                'wp_api' => true,
                'timeout' => 300
            ]
        );



        /*get orders from woocommerce*/
        $ordersWC = ($woocommerce->get('orders'));
        $transactionsId = [];
        foreach ($ordersWC as $orderWC) {
            array_push($transactionsId, $orderWC->transaction_id);
        }


        /*
        ** Get orders from plugg.to
        */
        $responseOrder = $client->request('GET', "https://api.plugg.to/orders/{$orderId}", [
            'headers' => [
                'Authorization' =>"Bearer {$bearerToken}",
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
            ],
        ]);
        $order = json_decode($responseOrder->getBody(), true);

        $transactionId = $order['Order']['id'];


        if(in_array($transactionId, $transactionsId)){
            echo "<pre>";
            echo $transactionId . " já existe no pedido: " . $orderWC->id;
            echo "</pre>";
        }
        else {

            if ($order['Order']['status'] == 'approved') {
                /*datas order*/
                $payment = $order['Order']['payments'][0]["payment_type"];

                /*billing datas*/
                $name = $order['Order']["payer_name"];
                $lastname = $order['Order']["payer_lastname"];
                $addressCustomer = $order['Order']["payer_address"] . ", " . $order['Order']["payer_address_number"];
                $addressComplementCustomer = $order['Order']["payer_address_complement"];
                $cityCustomer = $order['Order']["payer_city"];
                $stateCustomer = $order['Order']["payer_state"];
                $postcodeCustomer = $order['Order']["payer_zipcode"];
                $neighborhoodCustomer = $order['Order']["payer_neighborhood"];
                $addressNumberCustomer = $order['Order']["payer_address_number"];
                $email = $order['Order']["payer_email"];
                $ddd = $order['Order']["payer_phone_area"];
                $number = $order['Order']["payer_phone"];
                $phone = "({$ddd}) {$number}";
                $cpf = $order['Order']['payer_cpf'];

                /*shipping datas*/
                $addressShipping = $order['Order']["receiver_address"] . ", " . $order['Order']["receiver_address_number"];;
                $addressComplementShipping = $order['Order']["receiver_address_complement"];
                $neighborhoodShipping = $order['Order']["receiver_neighborhood"];
                $cityShipping = $order['Order']["receiver_city"];
                $stateShipping = $order['Order']["receiver_state"];
                $postcodeShipping = $order['Order']["receiver_zipcode"];


                /*products datas*/
                $sku = $order['Order']['items'][0]['sku'];
                $quantity = $order['Order']['items'][0]['quantity'];
                $subtotal = strval($order['Order']['items'][0]['total']);


                /*shipping_lines datas*/
                $method_id = $order['Order']["shipments"][0]["shipping_company"];
                $method_title = $order['Order']["shipments"][0]["shipping_company"];
                parse_str($order['Order']['shipping'], $totalShipping);
                $total = strval($order['Order']['shipping']);

                /*
                ** WOOCOMMERCE create order
                */
                $productsWC = $woocommerce->get('products', array('sku' => $sku));
                foreach ($productsWC as $productWC) {
                    $productId = $productWC->id;

                    try {
                        $data = [
                            'payment_method' => $payment,
                            'payment_method_title' => $payment,
                            'set_paid' => true,
                            'billing' => [
                                'first_name' => $name,
                                'last_name' => $lastname,
                                'address_1' => $addressCustomer,
                                'address_2' => ($addressComplementCustomer == null ? " " : $addressComplementCustomer),
                                'city' => $cityCustomer,
                                'state' => $stateCustomer,
                                'postcode' => $postcodeCustomer,
                                'country' => 'BR',
                                'email' => $email,
                                'phone' => $phone,
                            ],

                            'shipping' => [
                                'first_name' => $name,
                                'last_name' => $lastname,
                                'address_1' => $addressShipping,
                                'address_2' => ($addressComplementShipping == null ? " " : $addressComplementShipping),
                                'city' => $cityShipping,
                                'state' => $stateShipping,
                                'postcode' => $postcodeShipping,
                                'country' => 'BR'
                            ],
                            'line_items' => [
                                [
                                    'product_id' => $productId,
                                    'quantity' => $quantity,
                                    "total" => $subtotal
                                ]
                            ],
                            'meta_data' => [
                                [
                                    'key' => 'billing_persontype',
                                    'value' => 2    // 2 = PF (CPF)
                                ],
                                [
                                    'key' => 'billing_cpf',
                                    'value' => $cpf // sem pontuacao
                                ],
                                [
                                    'key' => 'billing_addressNumber',
                                    'value' => $addressNumberCustomer

                                ],
                                [
                                    'key' => 'billing_neighborhood',
                                    'value' => $neighborhoodCustomer
                                ],
                                [
                                    'key' => 'plugg_id',
                                    'value' => $transactionId
                                ]
                            ],
                            'shipping_lines' => [
                                [
                                    'method_id' => $method_id,
                                    'method_title' => $method_title,
                                    'total' => $total
                                ]
                            ],
                            "transaction_id" => $transactionId

                        ];


                        print_r($woocommerce->post('orders', $data));
                    } catch (HttpClientException $th) {
                        throw $th;
                    }
                }
            }
        }
    }
}
