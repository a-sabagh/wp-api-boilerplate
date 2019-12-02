<?php

namespace ABP\Controllers\Api;

defined('ABSPATH') || exit;

class Product {

    public function search() {
        global $wpdb;
        $search = $_POST['s'];
        $posts = $wpdb->prefix . "posts";
        $sql_search = "SELECT ID , post_title FROM {$posts} WHERE post_title LIKE '%{$search}%' AND post_type = 'product'";
        $products = $wpdb->get_results($sql_search, ARRAY_A);
        $data = array();
        if (!empty($products)) {
            foreach ($products as $product) {
                $data[] = array(
                    'id' => $product->ID,
                    'text' => $product->post_title
                );
            }
        }
        wp_send_json($data);
    }

    public function get($params) {
        global $wpdb;
        parse_str($params);
        $posts = $wpdb->prefix . "posts";
        $sql_get = "SELECT ID , post_title FROM {$posts} WHERE ID={$id}";
        $product = $wpdb->get_results($sql_get, ARRAY_A);
        $data = array();
        if (!empty($product)) {
            $data = array(
                'id' => $product['ID'],
                'text' => $product['post_title']
            );
        }
        wp_send_json($data);
    }
    
}
