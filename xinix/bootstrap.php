<?php
/**
 * Description of bootstrap.php
 *
 * @author jafar
 */
include_once($path_to_root . '/xinix/helpers.php');

function execute_controller() {
    $c = $_GET['c'];
    $cm = strrchr($c, '/');
    preg_match('/((\w+\/)+)(\w+)/', $c, $r);
    $f = substr($r[1], 0, -1);
    $c = substr($r[2], 0, -1);
    $m = $r[3];
    
    load($f);
    
    $_c = new $c();
    if (empty ($_c)) {
        $line = 'Controller `'.$c.'` not found';
        echo $line;
        throw new Exception($line);
    }
    
    if (!method_exists($_c, $m)) {
        $line = 'Method `'.$c.'::'.$m.'` not found';
        echo $line;
        throw new Exception($line);
    }

    $_c->$m();
}

class Controller {
    
}
?>
