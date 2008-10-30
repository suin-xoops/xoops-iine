<?php
require_once XOOPS_MODULE_PATH."/iine/include/function.php";

function smarty_function_iine_total($params)
{
	print iine_get_total($params);
}
?>