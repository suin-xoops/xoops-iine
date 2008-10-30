<?php
class Iine_Action
{
	var $mRoot = null;
	var $mByAjax = false;
	var $mVotesHandler = null;

	function Iine_Action()
	{
		$this->mRoot =& XCube_Root::getSingleton();
		$this->mVotesHandler =& $this->_getHandler();
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('votes', 'iine');
		return $handler;
	}

	function vote()
	{
		$voting = ($this->mRoot->mContext->mRequest->getRequest('vote')) ? true : false ;
		$targetDirname = trim($this->mRoot->mContext->mRequest->getRequest('dirname'));
		$targetId = intval($this->mRoot->mContext->mRequest->getRequest('id'));
		$url = trim($this->mRoot->mContext->mRequest->getRequest('url'));

		if ( empty($targetDirname) or empty($targetId) or empty($url) ) {
			$this->_giveResult(XOOPS_URL, 3, _MD_IINE_MESSAGE_MISSING_PRAMS);
		}

		$voted = $this->_hasVoted($targetDirname, $targetId);

		if ( $voted and $voting ) {
			$this->_giveResult($url, 3, _MD_IINE_MESSAGE_UNEXPECTED_ACCESS);
		}

		$uid = $this->_getUid();
		$ip = getenv('REMOTE_ADDR');

		if ( $voting ) {

			// add vote
			$newVote =& $this->mVotesHandler->create();
			$newVote->set('uid', $uid);
			$newVote->set('ip', $ip);
			$newVote->set('created', time());
			$newVote->set('dirname', $targetDirname);
			$newVote->set('content_id', $targetId);

			if ( $this->mVotesHandler->insert($newVote) ) {
				$message = ( $this->mByAjax ) ? 'voted' : _MD_IINE_MESSAGE_VOTED ;
				$this->_giveResult($url, 1, $message);
			} else {
				$this->_giveResult($url, 5, _MD_IINE_ERROR_VOTED);
			}

		} else {

			// delete vote
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('content_id', $targetId));
			$criteria->add(new Criteria('dirname', $targetDirname));
			$criteria->add(new Criteria('uid', $uid));
			if ( !$this->_isXoopsUser() ) $criteria->add(new Criteria('ip', $ip));

			if ( $this->mVotesHandler->deleteAll($criteria) ) {
				$message = ( $this->mByAjax ) ? 'unvoted' : _MD_IINE_MESSAGE_UNVOTED ;
				$this->_giveResult($url, 1, $message);
			} else {
				$this->_giveResult($url, 5, _MD_IINE_ERROR_UNVOTED);
			}
		}

	}

	function voteByAjax()
	{
		$this->mByAjax = true;
		$this->vote();
	}

	function button()
	{
		if ( !function_exists('iine_print_button') ) {
			require XOOPS_IINE_PATH.'/include/function.php';
		}

		$params = array(
			'dirname' => trim($this->mRoot->mContext->mRequest->getRequest('dirname')),
			'id' => intval($this->mRoot->mContext->mRequest->getRequest('id')),
			'url' => trim($this->mRoot->mContext->mRequest->getRequest('url')),
		);

		iine_print_button($params);
	}

	function users()
	{
		if ( !function_exists('iine_print_users') ) {
			require XOOPS_IINE_PATH.'/include/function.php';
		}

		$params = array(
			'dirname' => trim($this->mRoot->mContext->mRequest->getRequest('dirname')),
			'id' => intval($this->mRoot->mContext->mRequest->getRequest('id')),
		);

		iine_print_users($params);
	}

	function jquery()
	{
		$render =& $this->mRoot->mContext->mModule->getRenderTarget();

		$renderSystem =& $this->mRoot->mController->mRoot->getRenderSystem('Legacy_RenderSystem');
		$renderTarget =& $renderSystem->createRenderTarget('main');

		$renderTarget->setTemplateName('iine_jquery.tpl');

		$renderSystem->render($renderTarget);

		if (function_exists('mb_http_output')) {
			mb_http_output('pass');
		}

		header ('Content-Type:text/javascript; charset=utf-8');

		print xoops_utf8_encode($renderTarget->getResult());
	}

	function index()
	{
		$this->mRoot->mController->executeHeader();

		$render =& $this->mRoot->mContext->mModule->getRenderTarget();

		$render->setTemplateName('iine_main_index.tpl');

		$this->mRoot->mController->executeView();
	}

	//
	// private methods
	//

	function _votedUser($dirname, $content_id, $uid)
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('content_id', $content_id));
		$criteria->add(new Criteria('dirname', $dirname));
		$criteria->add(new Criteria('uid', $uid));

		return ( $this->mVotesHandler->getCount($criteria) > 0 ) ? true : false ;
	}

	function _votedGuest($dirname, $content_id, $ip)
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('content_id', $content_id));
		$criteria->add(new Criteria('dirname', $dirname));
		$criteria->add(new Criteria('ip', $ip));

		return ( $this->mVotesHandler->getCount($criteria) > 0 ) ? true : false ;
	}

	function _hasVoted($dirname, $content_id)
	{
		if ( $this->_isXoopsUser() ) {
			// if XoopsUser
			return $this->_votedUser($dirname, $content_id, $this->_getUid());
		} else {
			// if Guest
			return $this->_votedUser($dirname, $content_id, getenv('REMOTE_ADDR'));
		}
	}

	function _isXoopsUser()
	{
		return $this->mRoot->mContext->mUser->isInRole("Site.RegisteredUser");
	}

	function _getUid()
	{
		if ( $this->_isXoopsUser() ) {
			return $this->mRoot->mContext->mXoopsUser->uid();
		} else {
			return 0;
		}
	}

	function _giveResult($url, $sec, $message)
	{
		if ( $this->mByAjax ) exit($message);
		$this->mRoot->mController->executeRedirect($url, $sec, $message);
	}
}
?>