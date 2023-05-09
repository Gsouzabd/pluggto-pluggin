<?php

namespace Inc_PP\Pages;

use Inc_PP\Api\SettingsApi;

class Admin{

    public $settings;

    public $pages = [];
    public $subpages = [];

    
    public function __construct()
    {
        $this->settings = new SettingsApi;

        $this->pages = array(
            array(
                'page_title' => 'Pluggto Plugin',
                'menu_title' =>'Pluggto',
                'capability' =>'manage_options',
                'menu_slug' =>'pluggto_plugin',
                'callback' => array($this, 'admin_index'),
                'icon_url' => 'dashicons-store'                ,
                'position' => 111
            ),  
        // $this->subpages = array(
        //     array(
        //         'parent_slug' => 'pluggto_plugin',
        //         'page_title' => 'subpage',
        //         'menu_title' =>'subpage',
        //         'capability' =>'manage_options',
        //         'menu_slug' =>'subpage',
        //         'callback' => function(){echo "submenu";},
    
        //     ),
        //     )
            
        );
    }

    public function register(){


        $this->settings->addPages($this->pages)->withSubPage()->addSubPages($this->subpages)->register();

    }


    public function admin_index(){
        require_once PP_PATH . 'templates/admin.php';
    }

}