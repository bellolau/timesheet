<?php

class Form_Auth extends My_Form {

    public function init() {
        parent::init();
        
        $emailOptions = array(
            'label' => 'Adresse mail',
            'required' => true,
            'decorators' => $this->_elementDecorators,
            'validators' => array(
                'EmailAddress'
            )
        );
        $this->addElement('text', 'email', $emailOptions);

        $passwordOptions = array(
            'label' => 'Mot de passe',
            'required' => true,
            'decorators' => $this->_elementDecorators
        );
        $this->addElement('password', 'password', $passwordOptions);
        
        $submitOptions = array(
            'label' => 'Valider',
            'decorators' => $this->_buttonDecorators
        );
        $this->addElement('submit', 'valider', $submitOptions);
    }

}
