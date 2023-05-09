<?php
namespace Inc_PP\Base;


class Deactive{
    public static function deactivate(){

        flush_rewrite_rules();
    }


}