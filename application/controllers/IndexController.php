<?php

class IndexController extends My_Controller_Action {

    public function indexAction() {
        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {
            $this->_forward('list', 'project');
            return;
        } else {
            $this->_forward('login', 'auth');
            return;
        }
    }

}
