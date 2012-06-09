<?php

class Front_Form_User extends My_Form_Crud_Abstract {

    public function init() {
        parent::init();

        $firstnameOptions = array(
            'label' => 'Prénom',
            'required' => true,
            'decorators' => $this->_elementDecorators
        );
        $this->addElement('text', 'firstname', $firstnameOptions);

        $lastnameOptions = array(
            'label' => 'Nom',
            'required' => true,
            'decorators' => $this->_elementDecorators
        );
        $this->addElement('text', 'lastname', $lastnameOptions);

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

        $passwordOptions = array(
            'label' => 'Confirmez votre mot de passe',
            'required' => true,
            'decorators' => $this->_elementDecorators
        );
        $this->addElement('password', 'confirmPassword', $passwordOptions);

        $submitOptions = array(
            'label' => 'Valider',
            'decorators' => $this->_buttonDecorators
        );
        $this->addElement('submit', 'valider', $submitOptions);

        $submitOptions = array(
            'label' => 'Annuler',
            'decorators' => $this->_buttonDecorators
        );
        $this->addElement('button', 'annuler', $submitOptions);
    }

    public function isValid($data) {
        /**
         * Add identical password validator
         */
        if (isset($data['password']) && !empty($data['password'])
                && $this->getElement('confirmPassword')) {
            $validator = new Zend_Validate_Identical($data['password']);
            $validator->setMessage("Les deux mots de passe sont différents !", Zend_Validate_Identical::NOT_SAME);
            $this->getElement('confirmPassword')->addValidator($validator);
        }

        $valid = parent::isValid($data);

        if (!$this->getElement('email')->getErrors() && $data['email']) {
            $usersModel = new Front_Model_Users();

            if ($usersModel->getByEmail($data['email'])) {
                $this->getElement('email')->addError("Cette adresse mail est déjà utilisée !");
                $valid = false;
            }
        }

        return $valid;
    }

    private static function _emailUsed($email) {
        $user = new Front_Model_Users();
        $result = $user->fetchRow(array('email = ?' => $email));
        if ($result !== null) {
            return true;
        }
        return false;
    }

}
