<?php

/**
 * Description of Controller
 *
 * @author bellolau
 */
abstract class My_Controller_Crud_Abstract extends My_Controller_Action {

    /**
     * Model associated with crud controller
     * @var My_Model_Crud_Abstract
     */
    protected $_model;

    /**
     * Form asoociated with crud controller
     * @var My_Form_Crud_Abstract
     */
    protected $_form;
    protected $_primaryKey;
    protected $_columns;
    protected $_controllerName;
    protected $_baseUrl;
    protected $_controllerUrl;

    public function init() {
        if (!$this->_model instanceof My_Model_Crud_Abstract) {
            throw new Exception('Model must be an instance of My_Model_Crud_Abstract');
        }

        if (!$this->_form instanceof My_Form_Crud_Abstract) {
            throw new Exception('Model must be an instance of My_Form_Crud_Abstract');
        }

        $this->_primaryKey = $this->_model->getPrimaryKey();
        $this->_columns = $this->_model->getColumns();
        $this->_controllerName = $this->_request->getControllerName();
        $this->_baseUrl = $this->getFrontController()->getBaseUrl();
        $this->_controllerUrl = '/' . $this->_baseUrl . $this->_controllerName;
        $this->_form->setAction($_SERVER['REQUEST_URI']);
    }

    public function preDispatch() {
        parent::preDispatch();

        $this->view->primaryKey = $this->_primaryKey;
        $this->view->columns = $this->_columns;
        $this->view->form = $this->_form;
    }

    public function indexAction() {
        $this->_forward('list');
        return;
    }

    public function listAction() {
        $this->view->addUrl = $this->_controllerUrl . '/add/';
        $this->view->editUrl = $this->_controllerUrl . '/edit/' . $this->_primaryKey . '/%s';
        $this->view->deleteUrl = $this->_controllerUrl . '/delete/' . $this->_primaryKey . '/%s';
        $this->view->elements = $this->_model->getAll();
    }

    public function addAction() {
        $this->update();
        $this->render('edit');
    }

    public function editAction() {
        $this->update();
    }

    public function deleteAction() {
        $id = $this->_getParam($this->_primaryKey);

        $text = $this->_primaryKey . ' = ?';
        $where = $this->_model->getAdapter()->quoteInto($text, $id);
        $this->_model->delete($where);

        $this->_redirect($this->_controllerName);
    }

    protected function update() {
        $id = $this->_getParam($this->_primaryKey);

        if ($id === null) {
            $row = $this->_model->createRow();
        } else {
            $row = $this->_model->find($id)->current();
        }

        if ($row === null) {
            $this->_redirect($this->_controllerUrl);
        }

        $this->_form->populate($row->toArray());

        if ($this->_request->isPost()) {
            if ($this->_form->isValid($this->_request->getPost())) {
                $row->setFromArray($this->_form->getValues());
                $row->save();
                $this->_redirect($this->_controllerUrl);
            }
        }
    }

}
