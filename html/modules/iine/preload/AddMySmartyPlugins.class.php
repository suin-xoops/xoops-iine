<?php
if ( !defined('XOOPS_ROOT_PATH') ) exit();

class Iine_AddMySmartyPlugins extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		$this->mRoot->mDelegateManager->add('XoopsTpl.New', array($this, 'addMySmartyPlugins'));
		  $this->mRoot->mDelegateManager->add('Legacy_RenderSystem.SetupXoopsTpl', array(&$this, 'hook'));
	}

	function addMySmartyPlugins(&$xoopsTpl)
	{
		$xoopsTpl->plugins_dir[] = dirname(dirname(__FILE__)).'/include/smartyplugins';
	}
}
?>