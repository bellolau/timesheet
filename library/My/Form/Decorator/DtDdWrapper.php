<?php

/**
 * Description of DtDdWrapper
 *
 * @author bellolau
 */
class My_Form_Decorator_DtDdWrapper extends Zend_Form_Decorator_Abstract
{
    public function render($content) {
        $elementName = $this->getElement()->getName();
        Zend_Debug::dump($elementName);
        $dtLabel = $this->getOption('dtLabel');
        if ($dtLabel === null) {
            $dtLabel = '&#160;';
        }
        Zend_Debug::dump($dtLabel);

        $field = '<div class="">' .
                 $dtLabel .
                 $content .
                 '</div>';

        return $field;
    }
}
