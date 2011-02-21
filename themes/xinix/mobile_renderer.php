<?php
include_once($path_to_root . '/themes/'.user_theme().'/mobile_helper.php');

class renderer {
    var $data;

    function view($uri) {
        global $path_to_root;
        include $path_to_root . '/themes/'.user_theme().'/views/'.$uri.'.php';
    }

    function wa_header() {
//			add_js_ufile("themes/default/renderer.js");
//        page(_($help_context = "Main Menu"), false, true);
        mobile_header();
    }

    function wa_footer() {
//        end_page(false, true);
        mobile_footer();
    }

    function display_applications(&$waapp) {
        global $path_to_root, $app_config;
        
        $selected_app = $waapp->get_selected_application();

        $this->data['modules'] = $selected_app->modules;

        $this->view($selected_app->id);

//        echo '<pre>|';
//        print_r($waapp->applications);
//        echo '|</pre>';


    }
}

?>