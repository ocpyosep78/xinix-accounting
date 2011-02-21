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
    var $view;

    function _pre() {
        mobile_header();

    }

    function _post() {
        
        if (empty($this->view)) {
            $this->view = $_GET['c'];
        }
        $f = theme_path('views/'.$this->view);
        if(file_exists($f)) {
            load($f, $this);
        } else {
            load($this->view, $this);
        }

//        mobile_footer();
    }
}
?>
