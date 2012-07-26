<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

class Iine_AssignXoopsModuleHeader extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		$this->mRoot->mDelegateManager->add('Legacy_RenderSystem.SetupXoopsTpl', array(&$this, 'hook'));
	}

	function hook(&$xoopsTpl)
	{
		$jQueryLink = '<script type="text/javascript" src="'.XOOPS_URL.'/modules/iine/jquery-1.2.6.min.js"></script>'."\n";
		$jQueryLink .= '<script type="text/javascript" src="'.XOOPS_URL.'/modules/iine/jquery.php"></script>'."\n";
		$xoopsTpl->assign('xoops_module_header', $jQueryLink.$xoopsTpl->get_template_vars('xoops_module_header'));
	}
}

?>