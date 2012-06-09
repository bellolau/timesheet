<?php

class TrackingController extends My_Controller_Crud_Abstract {

    public function init() {
        $this->_model = new Model_Trackings();
        $this->_form = new Form_Tracking();
        parent::init();
    }

    public function listAction() {
        $taskId = $this->_getParam('taskId');

        $this->view->addUrl = $this->_controllerUrl . '/add/taskId/' . $taskId;
        $this->view->editUrl = $this->_controllerUrl . '/edit/' . $this->_primaryKey . '/%s';
        $this->view->deleteUrl = $this->_controllerUrl . '/delete/' . $this->_primaryKey . '/%s';
        $this->view->elements = $this->_model->getAll($taskId);
    }

    public function addAction() {
        $taskId = $this->_getParam('taskId');
        $this->update($taskId);

        if ($this->_helper->viewRenderer->getNoRender() === false) {
            $this->render('edit');
        }
    }

    protected function update($taskId = null) {
        $id = $this->_getParam($this->_primaryKey);

        if ($id === null) {
            $data = array();
            if ($taskId !== null) {
                $data['taskId'] = $taskId;
                $data['userId'] = 1;
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
                    $this->_redirect($this->_controllerUrl . '/index/taskId/' . $row->taskId);
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
