<?php

class ProjectController extends My_Controller_Crud_Abstract {
    
    public function init() {
        $this->_model = new Front_Model_Projects();
        $this->_form = new Front_Form_Project();
        parent::init();
    }
}
