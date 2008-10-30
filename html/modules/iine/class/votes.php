<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class IineVotesObject extends XoopsSimpleObject
{
	function IineVotesObject()
	{
		$this->initVar('id', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('created', XOBJ_DTYPE_INT, time(), true);
		$this->initVar('dirname', XOBJ_DTYPE_STRING, '', false, 50);
		$this->initVar('content_id', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('uid', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('ip', XOBJ_DTYPE_STRING, '', false, 50);
	}
}

class IineVotesHandler extends XoopsObjectGenericHandler
{
	var $mTable = 'iine_votes';
	var $mPrimary = 'id';
	var $mClass = 'IineVotesObject';
}

?>