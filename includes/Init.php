<?php

namespace ABP;

class Init {

    const first_flush_option = "first_flush_permalinks";
    
    public $namespace;

    public $slug;
    public $version;

    public function __construct($version, $slug) {
        $this->slug = $slug;
        $this->version = $version;
        $this->load_modules();

        add_action("init", array($this, "add_rewrite_rule"));
        add_action("admin_notices", array($this, "first_flush_notice"));
        add_action("update_option_permalink_structure", function() {
            update_option(self::first_flush_option, true);
        });
        add_action("template_redirect", array($this, "template_redirect"));
    }

    public function add_rewrite_rule() {
        add_rewrite_rule("^{$this->slug}/([^/]*)/?([^/]*)/?([^/]*)/?$", 'index.php?abp_module=$matches[1]&abp_action=$matches[2]&abp_params=$matches[3]', "top");
        add_rewrite_tag("%abp_module%", "([^/]*)");
        add_rewrite_tag("%abp_action%", "([^/]*)");
        add_rewrite_tag("%abp_params%", "([^/]*)");
    }

    public function first_flush_notice() {
        if (get_option(self::first_flush_option)) {
            return;
        }
        ?>
        <div class="error">
            <p>
                <?php esc_html_e("To make the api-boilerplate plugin worked Please first "); ?>
                <a href="<?php echo get_admin_url(); ?>/options-permalink.php" title="<?php esc_attr_e("Permalink Settings") ?>" ><?php esc_html_e("Flush rewrite rules"); ?></a>
            </p>
        </div>
        <?php
    }

    public function template_redirect() {
        $module = get_query_var("abp_module");
        if(empty($module)){
            return;
        }
        $action = get_query_var("abp_action");
        $params = get_query_var("abp_params");
        header('Content-Type: application/json');
        $class = $this->namespace[$module] . $module;
        if(!class_exists($class)){
            wp_send_json(['error' => "Class {$class} not exist"]);
            return;
        }        
        $controller = new $class;
        if(!isset($action)){
            $controller->index();
            return;
        }
        $controller->{$action}($params);
    }

    public function load_modules() {
        $this->namespace = array(
            "Product" => "ABP\Api\Controllers\\",
        );
        require_once trailingslashit(__DIR__) . "Api/Controllers/Product.php";
    }

}