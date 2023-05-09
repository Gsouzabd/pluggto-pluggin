<?php

namespace Inc_PP\Base;

class Functions{

    public function register(){
        add_action( 'woocommerce_variation_before_set_stock',  array($this, 'stock_about_to_change'));
        add_action( 'woocommerce_product_set_stock',  array($this, 'stock_about_to_change'));

    }

    function stock_about_to_change( $product ) {
        $body = wp_json_encode( array(
            "type" => "stock",
            "id" => $product->id,
            "sku" => $product->sku,
            "quantity" => $product->stock_quantity
        ) );
    
        $url = PP_URL . 'inc/Pages/Notification.php';
        $response = wp_remote_post( $url, array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => $body,
            )
        );
    
        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();

            $body = wp_json_encode( array(
                "error" => $error_message
            ));  
            $url = PP_URL . 'inc/Pages/Notification.php';
            $response = wp_remote_post( $url, array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(),
                'body' => $body,
                )
            );
        }
    }


}