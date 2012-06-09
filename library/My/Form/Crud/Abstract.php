<?php

abstract class My_Form_Crud_Abstract extends My_Form {

    public function init() {
        $this->setMethod('post');
    }

}
