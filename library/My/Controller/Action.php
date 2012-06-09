<?php

class My_Controller_Action extends Zend_Controller_Action {

    public function preDispatch() {
        $this->view->xmlHttpRequest = $this->_request->isXmlHttpRequest();

        if ($this->view->xmlHttpRequest === true) {
            $this->_helper->layout->disableLayout();
        }

        $user = new Zend_Session_Namespace('user');

        $this->user = $user;
        $this->view->user = $user;

        $logoutUrl = array(
            'controller' => 'user',
            'action' => 'logout',
        );

        $this->view->logoutUrl = $this->view->url($logoutUrl);
    }

}
