<?php
$mydirname = basename(dirname(__FILE__));
$modversion['name'] = _MI_IINE_NAME;
$modversion['description'] = _MI_IINE_DESC;
$modversion['dirname'] = $mydirname;
$modversion['version'] = '1.03';
$modversion['credits'] = '';
$modversion['author'] = 'Suin';
$modversion['license'] = 'GPL see LICENSE';
$modversion['image'] = 'iine_logo.png';

//Admin things
$modversion['hasAdmin'] = 0;
$modversion['hasMain'] = 1;

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

$modversion['templates'][1]['file'] = 'iine_inc_button.tpl';
$modversion['templates'][1]['description'] = 'Display Iine button.';

$modversion['templates'][2]['file'] = 'iine_inc_users.tpl';
$modversion['templates'][2]['description'] = 'Display the users who voted.';

//$modversion['templates'][3]['file'] = 'iine_jquery.tpl';
//$modversion['templates'][3]['description'] = 'Display javascript code for jQuery.';

$modversion['templates'][4]['file'] = 'iine_main_index.tpl';
$modversion['templates'][4]['description'] = 'Template to debug.';

?>