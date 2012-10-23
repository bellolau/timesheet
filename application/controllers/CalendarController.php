<?php

class CalendarController extends My_Controller_Crud_Abstract {

    public function init() {
        $this->_model = new Model_Calendar();
        $this->_form = new Form_Calendar();
        parent::init();
    }

    public function listAction() {
        $projectId = $this->_getParam('projectId');

        $this->view->addUrl = $this->_controllerUrl . '/add/projectId/' . $projectId;
        $this->view->editUrl = $this->_controllerUrl . '/edit/' . $this->_primaryKey . '/%s';
        $this->view->deleteUrl = $this->_controllerUrl . '/delete/' . $this->_primaryKey . '/%s';
        $this->view->elements = $this->_model->getAll($projectId);
    }

    public function addAction() {
        $projectId = $this->_getParam('projectId');
        $this->update($projectId);

        if ($this->_helper->viewRenderer->getNoRender() === false) {
            $this->render('edit');
        }
    }

    protected function update($projectId = null) {
        $id = $this->_getParam($this->_primaryKey);

        if ($id === null) {
            $data = array();
            if ($projectId !== null) {
                $data['projectId'] = $projectId;
            }
            $row = $this->_model->createRow($data);
        } else {
            $row = $this->_model->find($id)->current();
        }

        if ($row === null) {
            $this->_redirect($this->_controllerUrl);
        }

        $this->_form->populate($row->toArray());

        if ($this->_request->isPost()) {
            if ($this->_form->isValid($this->_request->getPost())) {
                $values = $this->_form->getValues();
                $row->setFromArray($this->_form->getValues());
                $row->save();
                if ($this->_request->isXmlHttpRequest() !== true) {
                    $this->_redirect($this->_controllerUrl . '/index/projectId/' . $row->projectId);
                } else {
                    $this->_helper->viewRenderer->setNoRender(true);
                    $response = new stdClass();
                    $response->result = 'ok';
                    $this->_response->setHeader('Content-type', 'application/json');
                    echo Zend_Json::encode($response);
                }
            }
        }

    }

}
