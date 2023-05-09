<?php

namespace Inc_PP\Base;

class Enqueue{
    
    public function register(){
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));

    }

    function enqueue(){
        //enqueue all our scripts
        wp_enqueue_style('pp-style', PP_URL . '/assets/style.css', __FILE__);
        wp_enqueue_script('pp-script', PP_URL . '/assets/script.js', __FILE__);
    }

}