<?php
require '../../mainfile.php';

define('XOOPS_IINE_PATH', dirname(__FILE__));

if ( !class_exists('Iine_Action') ) require XOOPS_IINE_PATH . '/actions/index.php';

$actionName = isset($_GET['action']) ? trim($_GET['action']) : 'index' ;

$action = new Iine_Action();

if ( !method_exists($action, $actionName) ) exit('Invalid request.');

$action->$actionName();

?>