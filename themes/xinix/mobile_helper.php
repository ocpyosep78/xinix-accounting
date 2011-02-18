<?php
function mobile_footer() {
    global $path_to_root;
    include $path_to_root.'/themes/'.user_theme().'/views/common/mobile_footer.php';
}

function mobile_header() {
    global $app_config, $path_to_root;

    $app = $_SESSION['App'];

    if (!empty($app)) {
        $menu .= '<ul>';

        $applications = $app->applications;
        $sel_app = $app->get_selected_application();

        foreach($applications as $app) {
            $acc = access_string($app->name);
            $menu .= '<li '.($sel_app == $app->id ? ('class="active"') : '').'>
                    <a href="'.$app_config['base_url'].'/index.php?application='.$app->id.'" '.$acc[1].'>'.$acc[0].'</a></li>';
        }

        $menu .= '<li><a href="'.$app_config['base_url'].'/access/logout.php?">logout</a></li>';
        $menu .= '</ul>';
    }
//
    include $path_to_root.'/themes/'.user_theme().'/views/common/mobile_header.php';
}

?>
