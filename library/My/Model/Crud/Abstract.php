<?php

abstract class My_Model_Crud_Abstract extends Zend_Db_Table_Abstract {

    protected $_columns = array();

    public function getPrimaryKey() {
        if (is_array($this->_primary)) {
            return $this->_primary[1];
        } else {
            return $this->_primary;
        }
    }

    public function getColumns() {
        if (empty($this->_columns)) {
            return $this->_getCols();
        } else {
            return $this->_columns;
        }
    }

    public function getAll() {
        $columnsToDisplay = empty($this->_columns) ? $this->_getCols() : array_keys($this->_columns);
        $where = $this->select()->from($this, $columnsToDisplay);
        return $this->fetchAll($where);
    }

    public function count() {
        $where = $this->select()->from($this, 'COUNT(' . $this->getPrimaryKey() . ') AS nbElements');
        $row = $this->fetchRow($where);

        return $row !== null ? $row->nbElements : 0;
    }

}