<?php

class Admin_ErrorController extends Zend_Controller_Action
{
	private $_notifier;
	private $_error;
	private $_environment;

	public function errorAction() {
		switch ($this->_error->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->message = 'Uh oh, we can\'t seem to find that page you wanted!';
				$this->_applicationError();
				break;

			default:
				$this->getResponse()->setHttpResponseCode(500);
				$this->view->message = 'Looks like something\'s gone wrong! Please refresh the page - '
						. 'if the problem persists please report the error';
				$this->_applicationError();
				break;
		}

		$this->view->headTitle()->prepend($this->view->code . ' Error');
	}

	private function _applicationError() {
		$fullMessage = $this->_notifier->getFullErrorMessage();
		$this->view->stack = nl2br($fullMessage);
		$this->_notifier->notify();
	}

}
