<?php
function theme_url() {
    global  $path_to_root, $def_theme;
    return "$path_to_root/themes/$def_theme";
}

function mobile_footer() {
    $result = '<div id="footer">
    <p>Copyright &copy; <a href="http://xinix.co.id">Xinix Technology</a> 2011<br/>Version 2.2.11   Build 18.02.2011</p>
</div>';
    return $result;
}

function mobile_header() {
    $result = '<div id="header">
                <div id="logo">
                    <a href="."><img alt="logo" src="'.theme_url().'/mobile_images/logo.jpg"/></a>
                </div>
                <div class="menu">'.
//                    <ul>
//                        <li class="active"><a href="index.html">Home</a></li>
//                        <li><a href="about.html">About</a></li>
//                        <li><a href="services.html">Services</a></li>
//                        <li><a href="support.html">Support</a></li>
//                        <li><a href="contacts.html">Contacts</a></li>
//                    </ul>
                '</div>
            </div>';
    return $result;
}

?>
