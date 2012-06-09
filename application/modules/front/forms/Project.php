<?php

class Front_Form_Project extends My_Form_Crud_Abstract {

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

        $submitOptions = array(
            'label' => 'Valider',
            'decorators' => $this->_buttonDecorators
        );
        $this->addElement('submit', 'valider', $submitOptions);
    }

    public function isValid($data) {
        $valid = parent::isValid($data);

        if (!$this->getElement('name')->getErrors() && isset($data['name'])) {
            $projectsModel = new Front_Model_Projects();

            if ($projectsModel->getByName($data['name']) !== null) {
                $this->getElement('name')->addError('Un projet "' . $data['name'] . '" existe déjà !');
                $valid = false;
            }
        }

        if (!$this->getElement('reference')->getErrors() && isset($data['reference'])) {
            $projectsModel = new Front_Model_Projects();

            if ($projectsModel->getByReference($data['reference']) !== null) {
                $this->getElement('reference')->addError('Un projet "' . $data['reference'] . '" possède déjà cette référence !');
                $valid = false;
            }
        }

        return $valid;
    }

}
