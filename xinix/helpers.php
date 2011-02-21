<?php
function base_url() {
    return $GLOBALS['app_config']['base_url'];
}

function theme_url($uri = '') {
    return base_url(). "/themes/".user_theme().'/'.$uri;
}

function base_path() {
    return $GLOBALS['path_to_root'];
}

function theme_path($path = '') {
    return base_path().'/themes/'.user_theme().'/'.$path;
}

function load($uri, $arg = '') {
//    echo base_path().'/'.$uri.'.php<br/><br/><br/>';
    require(base_path().'/'.$uri.'.php');
}
?>
