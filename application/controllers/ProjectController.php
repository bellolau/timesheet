<?php

class ProjectController extends My_Controller_Crud_Abstract {

    public function init() {
        $this->_model = new Model_Projects();
        $this->_form = new Form_Project();
        parent::init();
    }

    public function addAction() {
        $row = $this->_model->createRow();

        if ($this->_request->isPost()) {
            if ($this->_form->isValid($this->_request->getPost())) {
                $row->setFromArray($this->_form->getValues());
                $row->save();

                if ($this->_request->isXmlHttpRequest() !== true) {
                    $this->_redirect($this->_controllerUrl . '/index/projectId/' . $row->projectId);
                    return;
                } else {
                    $this->_helper->viewRenderer->setNoRender(true);
                    $response = new stdClass();
                    $response->result = 'ok';
                    $this->_response->setHeader('Content-type', 'application/json');
                    echo Zend_Json::encode($response);
                    return;
                }
            }
        }

        $this->render('edit');
    }

    public function detailAction() {
        $id = $this->_getParam('id');

        if ($id === null) {
            return $this->_forward('list');
        }

        $project = $this->_model->find($id)->current();

        if ($project === null) {
            return $this->_forward('list');
        }

        $this->view->project = $project;
    }

}
