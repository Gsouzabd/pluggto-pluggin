<?php

use Inc_PP\Database\Db;

$db = new Db();
$keys = $db->selectAll();

if(array_key_exists('submit', $_POST)){
   
    if($_POST['api_url'] != null && $_POST['api_ck'] != null && $_POST['api_cs'] != null 
    && $_POST['client_id'] != null && $_POST['client_secret'] != null && $_POST['username'] != null &&
    $_POST['password'] != null){
        $tablename = 'wp_mailer_plugin';
        $api_url = $_POST['api_url'];
        $api_ck = $_POST['api_ck'];
        $api_cs = $_POST['api_cs']; 
        $client_id = $_POST['client_id'];
        $client_secret = $_POST['client_secret'];
        $username = $_POST['username']; 
        $password = $_POST['password']; 

        $db->insert($api_url,$api_ck,$api_cs,$client_id, $client_secret, $username, $password);
 
        
        echo "<div class='notice notice-success is-dismissible'> 
        <p><strong>Keys sucessfully saved!</strong></p>
            <button type='button' class='notice-dismiss'>
                <span class='screen-reader-text'>Fechar</span>
            </button>
        </div>";
        
    }else{
        echo "<div class='notice notice-error is-dismissible'> 
        <p><strong>Fill in the fields! Empty values are not accepted.</strong></p>
            <button type='button' class='notice-dismiss'>
                <span class='screen-reader-text'>Fechar</span>
            </button>
        </div>";
    }
}


?>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="wrap">
    <form method="post">
        <h3>Api Keys - Woocommerce</h3>
        
        <div class="form-group">
            <label for="exampleInputEmail1">Api URL</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="api_url" aria-describedby="emailHelp" placeholder="<?=$keys[0]->api_url;?>">
            <small id="emailHelp" class="form-text text-muted">generate your keys in woocommerce->settings->Advanced.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Api CK</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="api_ck" aria-describedby="emailHelp" placeholder="<?=$keys[0]->api_ck;?>">
            <small id="emailHelp" class="form-text text-muted">generate your keys in woocommerce->settings->Advanced.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Api CS</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="api_cs" aria-describedby="emailHelp" placeholder="<?=$keys[0]->api_cs;?>">
            <small id="emailHelp" class="form-text text-muted">generate your keys in woocommerce->settings->Advanced.</small>
        </div>
        </br>
        <hr>
        </br>
        <h3>Plugin Keys - Pluggto</h3>
        <div class="form-group">
            <label for="exampleInputEmail1">Client Id</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="client_id" aria-describedby="emailHelp" placeholder="<?=$keys[0]->client_id;?>">
            <small id="emailHelp" class="form-text text-muted">generate your keys in pluggto->menu->developer->plugin</small>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Client Secret</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="client_secret" aria-describedby="emailHelp" placeholder="<?=$keys[0]->client_secret;?>">
            <small id="emailHelp" class="form-text text-muted">generate your keys in pluggto->menu->developer->plugin</small>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="username" aria-describedby="emailHelp" placeholder="<?=$keys[0]->username;?>">
            <small id="emailHelp" class="form-text text-muted">generate your keys in pluggto->menu->developer->plugin</small>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Password</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="password" aria-describedby="emailHelp" placeholder="<?=$keys[0]->pass;?>">
            <small id="emailHelp" class="form-text text-muted">generate your keys in pluggto->menu->developer->plugin</small>
        </div>
 


        <input type="submit" name="submit" value="Submit">
    </form>
    <div style="margin: 3% 1%">
        <img src="<?=PP_URL . 'assets/imgs/mlovi-logo.png'?>" style="width: 200px">|  <img src="<?=PP_URL . 'assets/imgs/pluggto.png'?>" style="width: 200px; margin-left: 2%">
        </br>
        <span>Desenvolvido por <a href='https://mlovi.com.br/'>Mlovi - Desenvolvimento e Soluções Web.</a></span>
    </div>
</div>
</body>