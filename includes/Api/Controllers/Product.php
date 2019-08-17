<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ABP\Api\Controllers;

/**
 * Description of Product
 *
 * @author asabagh
 */
class Product {
    public function all($params){
        $array = array(
            "Class" => "Product",
            "Method" => "all",
            "params" => $params
        );
        wp_send_json($array);
    }
}
