<?php

/**
 * Description of Form
 *
 * @author bellolau
 */
class My_Form extends Zend_Form
{
    protected $_formDecorators = array(
        'FormElements',
        'Form'
    );

    protected $_elementDecorators = array(
        'ViewHelper',
        'Errors',
        array('Label', array('requiredSuffix' => ' *')),
        array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'field'))
    );

    protected $_buttonDecorators = array(
        'ViewHelper',
        array(array('label' => 'HtmlTag'), array('tag' => 'td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'button'))
    );

    public function  __construct($options = null) {
        parent::__construct($options);
        $this->setDecorators($this->_formDecorators);
    }
}
