<?php
function iine_print_users($params)
{
	$targetDirname = trim($params['dirname']);
	$targetId = intval($params['id']);

	$root =& XCube_Root::getSingleton();

	// load language file
	$root->mLanguageManager->loadModuleMessageCatalog('iine');

	if ( empty($targetDirname) or empty($targetId) ) {
		print _MD_IINE_ERROR_PLUGIN;
		if ( empty($targetDirname) ) print _MD_IINE_ERROR_NO_DIR;
		if ( empty($targetId) ) print _MD_IINE_ERROR_NO_ID;
		return;
	}

	// get db
	$db =& $root->mController->mDB;

	// make query to get voted users
	$sql = sprintf("SELECT v.created, v.ip, u.uid, u.uname FROM `%s` v, `%s` u WHERE v.`content_id` = '%u' AND v.`dirname` = '%s' AND u.`level` > 0 AND v.`uid` = u.`uid`",
		$db->prefix('iine_votes'), $db->prefix('users'), intval($targetId), mysql_real_escape_string($targetDirname));
	$voters = array();
	$recource = $db->query($sql);
	while( $voter = $db->fetchArray($recource) ) {
		$voter['uname'] = htmlspecialchars($voter['uname']);
		$voters[] = $voter;
	}

	// also count guests
	$sql = sprintf("SELECT COUNT(*) FROM `%s` WHERE `content_id` = '%u' AND `dirname` = '%s'",
		$db->prefix('iine_votes'), intval($targetId), mysql_real_escape_string($targetDirname));
	list($total) = $db->fetchRow($db->query($sql));
	$guests = $total - count($voters);

	// new template
	$tpl =& new XoopsTpl();

	// assign values
	$tpl->assign('voters', $voters);
	$tpl->assign('guests', $guests);

	// output
	$tpl->display('db:iine_inc_users.tpl');
}

function iine_print_button($params)
{
	$targetDirname = trim($params['dirname']);
	$targetId = intval($params['id']);
	$targetUrl = isset($params['url']) ? trim($params['url']) : null ;

	$root =& XCube_Root::getSingleton();

	// load language file
	$root->mLanguageManager->loadModuleMessageCatalog('iine');

	if ( empty($targetDirname) or empty($targetId) ) {
		print _MD_IINE_ERROR_PLUGIN;
		if ( empty($targetDirname) ) print _MD_IINE_ERROR_NO_DIR;
		if ( empty($targetId) ) print _MD_IINE_ERROR_NO_ID;
		return;
	}

	// get db
	$db =& $root->mController->mDB;

	// make query to get total
	$sql = sprintf("SELECT COUNT(*) FROM `%s` WHERE `content_id` = '%u' AND `dirname` = '%s'",
		$db->prefix('iine_votes'), intval($targetId), mysql_real_escape_string($targetDirname));
	list($total) = $db->fetchRow($db->query($sql));

	// check if voted
	if ( $root->mContext->mUser->isInRole("Site.RegisteredUser") ) {
		$uid = $root->mContext->mXoopsUser->uid();
		$sql = sprintf("SELECT COUNT(*) FROM `%s` WHERE `content_id` = '%u' AND `dirname` = '%s' AND `uid` = '%u'",
			$db->prefix('iine_votes'), intval($targetId), 
			mysql_real_escape_string($targetDirname), intval($uid));
	} else {
		$ip = getenv('REMOTE_ADDR');
		$sql = sprintf("SELECT COUNT(*) FROM `%s` WHERE `content_id` = '%u' AND `dirname` = '%s' AND `ip` = '%s'",
			$db->prefix('iine_votes'), intval($targetId), 
			mysql_real_escape_string($targetDirname), mysql_real_escape_string($ip));
	}
	list($userTotal) = $db->fetchRow($db->query($sql));
	$voted = ( $userTotal > 0 ) ? true : false ;

	// get current url
	$http = isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ;
	$url = empty($targetUrl) ? $http.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] : $targetUrl;

	// new template
	$tpl =& new XoopsTpl();

	// assign values
	$tpl->assign('form_action', XOOPS_MODULE_URL.'/iine/index.php?action=vote');
	$tpl->assign('target', array(
		'dirname' => htmlspecialchars($targetDirname), 
		'id' => $targetId));
	$tpl->assign('url', htmlspecialchars($url));
	$tpl->assign('total', $total);
	$tpl->assign('voted', $voted);

	// output
	$tpl->display('db:iine_inc_button.tpl');
}

function iine_get_total($params)
{
	$targetDirname = trim($params['dirname']);
	$targetId = intval($params['id']);

	$root =& XCube_Root::getSingleton();

	// load language file
	$root->mLanguageManager->loadModuleMessageCatalog('iine');

	if ( empty($targetDirname) or empty($targetId) ) {
		print _MD_IINE_ERROR_PLUGIN;
		if ( empty($targetDirname) ) print _MD_IINE_ERROR_NO_DIR;
		if ( empty($targetId) ) print _MD_IINE_ERROR_NO_ID;
		return;
	}

	// get db
	$db =& $root->mController->mDB;

	// make query to get total
	$sql = sprintf("SELECT COUNT(*) FROM `%s` WHERE `content_id` = '%u' AND `dirname` = '%s'",
		$db->prefix('iine_votes'), intval($targetId), mysql_real_escape_string($targetDirname));
	list($total) = $db->fetchRow($db->query($sql));

	print $total;
}
?>