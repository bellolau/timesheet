<?php

class Form_Task extends My_Form_Crud_Abstract {

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
            'label' => 'Durée estimée',
            'required' => true,
            'decorators' => $this->_elementDecorators,
            'validators' => array('NotEmpty')
        );
        $this->addElement('text', 'estimatedDuration', $elementOptions);

        $elementOptions = array(
            'decorators' => $this->_elementDecorators
        );
        $this->addElement('hidden', 'sprintId', $elementOptions);

        $elementOptions = array(
            'label' => 'Valider',
            'decorators' => $this->_buttonDecorators
        );
        $this->addElement('submit', 'valider', $elementOptions);
    }
    
}
