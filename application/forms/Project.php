<?php

class Form_Project extends My_Form_Crud_Abstract {

    public function init() {
        parent::init();

        $nameOptions = array(
            'label' => 'Nom du projet',
            'required' => true,
            'decorators' => $this->_elementDecorators
        );
        $this->addElement('text', 'name', $nameOptions);

        $nameOptions = array(
            'label' => 'Référence',
            'required' => true,
            'decorators' => $this->_elementDecorators
        );
        $this->addElement('text', 'reference', $nameOptions);

        $nameOptions = array(
            'label' => 'Vendu',
            'required' => true,
            'decorators' => $this->_elementDecorators
        );
        $this->addElement('text', 'sold', $nameOptions);

        $submitOptions = array(
            'label' => 'Valider',
            'decorators' => $this->_buttonDecorators
        );
        $this->addElement('submit', 'valider', $submitOptions);
    }

    public function isValid($data) {
        $valid = parent::isValid($data);

        $controller = Zend_Controller_Front::getInstance();
        $notId = $controller->getRequest()->getParam('id', null);

        if (!$this->getElement('name')->getErrors() && isset($data['name'])) {
            $projectsModel = new Model_Projects();

            if ($projectsModel->getByName($data['name'], $notId) !== null) {
                $this->getElement('name')->addError('Un projet "' . $data['name'] . '" existe déjà !');
                $valid = false;
            }
        }

        if (!$this->getElement('reference')->getErrors() && isset($data['reference'])) {
            $projectsModel = new Model_Projects();

            if ($projectsModel->getByReference($data['reference'], $notId) !== null) {
                $this->getElement('reference')->addError('Un projet "' . $data['reference'] . '" possède déjà cette référence !');
                $valid = false;
            }
        }

        return $valid;
    }

}
