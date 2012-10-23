<?php

class Form_Sprint extends My_Form_Crud_Abstract {

    public function init() {
        parent::init();

        $elementOptions = array(
            'label' => 'Nom',
            'required' => true,
            'decorators' => $this->_elementDecorators,
            'validators' => array('NotEmpty')
        );
        $this->addElement('text', 'name', $elementOptions);

        $elementOptions = array(
            'label' => 'Date de début',
            'required' => true,
            'decorators' => $this->_elementDecorators,
            'validators' => array('NotEmpty', 'Date')
        );
        $this->addElement('text', 'startDate', $elementOptions);

        $elementOptions = array(
            'label' => 'Date de fin',
            'required' => true,
            'decorators' => $this->_elementDecorators,
            'validators' => array('NotEmpty', 'Date')
        );
        $this->addElement('text', 'endDate', $elementOptions);

        $elementOptions = array(
            'decorators' => $this->_elementDecorators
        );
        $this->addElement('hidden', 'projectId', $elementOptions);

        $elementOptions = array(
            'label' => 'Valider',
            'decorators' => $this->_buttonDecorators
        );
        $this->addElement('submit', 'valider', $elementOptions);
    }

}
