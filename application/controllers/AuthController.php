<?php

class AuthController extends My_Controller_Action {
    
    public function loginAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->_redirect('/');
            return;
        }

        $form = new Form_Auth();

        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $isValid = Model_Users::authenticate($form->getValue('email'), $form->getValue('password'));

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

}

