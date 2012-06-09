<?php

class Form_Tracking extends My_Form_Crud_Abstract {

    public function init() {
        parent::init();

        $elementOptions = array(
            'label' => 'Durée',
            'required' => true,
            'decorators' => $this->_elementDecorators,
            'validators' => array('NotEmpty')
        );
        $this->addElement('text', 'duration', $elementOptions);

        $elementOptions = array(
            'label' => 'Nouvelle durée estimée',
            'required' => true,
            'decorators' => $this->_elementDecorators,
            'validators' => array('NotEmpty')
        );
        $this->addElement('text', 'newEstimatedDuration', $elementOptions);

        $elementOptions = array(
            'decorators' => $this->_elementDecorators
        );
        $this->addElement('hidden', 'userId', $elementOptions);

        $elementOptions = array(
            'decorators' => $this->_elementDecorators
        );
        $this->addElement('hidden', 'taskId', $elementOptions);

        $elementOptions = array(
            'label' => 'Valider',
            'decorators' => $this->_buttonDecorators
        );
        $this->addElement('submit', 'valider', $elementOptions);
    }
    
}
