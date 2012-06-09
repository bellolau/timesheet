<?php

class UserController extends My_Controller_Crud_Abstract {

    public function init() {
        $this->_model = new Front_Model_Users();
        $this->_form = new Front_Form_User();
        parent::init();
    }

    public function loginAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->_redirect('/');
            return;
        }

        $form = new Front_Form_User_Login();

        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $isValid = Front_Model_Users::authenticate($form->getValue('email'), $form->getValue('password'));

                if ($isValid) {
                    $this->_redirect('/');
                    return;
                } else {
                    $this->view->error = "Votre email ou mot de passe est invalide.";
                }
            }
        }

        $this->view->form = $form;
    }

    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect('/');
        return;
    }

}
