<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of mobile_report
 *
 * @author jafar
 */
class Mobile_Report extends Controller {
    function _pre() {
        mobile_header();

    }

    function _post() {
        $f = theme_path('views/'.$_GET['c']);
        if(file_exists($f)) {
            load($f, $this);
        } else {
            load($_GET['c'], $this);
        }

//        mobile_footer();
    }
}
?>
