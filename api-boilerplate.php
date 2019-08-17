<?php

/*
 * Plugin Name: api-boilerplate
 * Description: WordPress api boilerplate
 * Version: 1.0
 * Author: Abolfazl Sabagh
 * Author URI: https://asabagh.ir
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define("ABP_FILE", __FILE__);                   
define("ABP_PRU", plugin_basename(__FILE__));   
define("ABP_PDU", plugin_dir_url(__FILE__));    
define("ABP_PRT", basename(__DIR__));   
define("ABP_PDP", plugin_dir_path(__FILE__));   
define("ABP_TMP", ABP_PDP . "public/");         
define("ABP_ADM", ABP_PDP . "admin/");          


require_once trailingslashit(__DIR__) . "includes/Init.php";
$init = new ABP\Init(1.0, 'api-boilerplate');
