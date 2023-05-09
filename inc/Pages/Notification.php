<?php

use Inc_PP\Classes\Order;
use Inc_PP\Classes\Stock;

require_once('../../vendor/autoload.php');

class notification{
    public function __construct()
    {       
       
        $data = file_get_contents("php://input");
        $events = json_decode($data, true);

        //Add timestamps on notification
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $currentDate = $date->format('Y-m-d H:i:s');
        $events['date_notification'] = $currentDate;



        //save JSON BODY in debug
        ob_start();
        var_dump($events);
        $input = ob_get_contents();
        ob_end_clean();


        //Save notification on log
        file_put_contents('notification.log', $input . PHP_EOL, FILE_APPEND);
    }

}

$notification = new notification();

$data = file_get_contents("php://input");
$events = json_decode($data, true);

/*
** If Order, create Order
*/
if($events['type'] == 'orders'){
    $order = new Order;
    $order->create($events['id']);
}


/*
** If stock, update stock 
*/
if($events['type'] == 'stock'){
    $stock = new Stock;
    $stock->update($events['sku'], strval($events['quantity']));
}





