<?php
require_once XOOPS_MODULE_PATH."/iine/include/function.php";

function smarty_function_iine_users($params, &$smarty)
{
	iine_print_users($params);
}
?>