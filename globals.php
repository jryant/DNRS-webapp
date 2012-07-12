<?php

$debug = TRUE;
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once('lib/FirePHPCore/FirePHP.class.php');
ob_start();
$firephp = FirePHP::getInstance(true);

$GLOBALS['WEBSITE'] = "http://".$_SERVER['SERVER_NAME']."/";
// $GLOBALS['WEBSITE'] = "http://localhost:8888/`BLC/dnrsystem.com/webapp/";

$GLOBALS['EMAIL_SENDER'] = "no-reply@dnrsystem.com";
$GLOBALS['EMAIL_BCC'] = "jason@bluelotuscreative.com";

?>