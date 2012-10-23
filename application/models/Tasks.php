<?php

class Model_Tasks extends My_Model_Crud_Abstract {

    protected $_name = 'task';
    protected $_primary = 'id';
    protected $_rowClass = 'Model_Db_Table_Row_Task';
    protected $_referenceMap = array(
        'sprint' => array(
            'columns'           => 'sprintId',
            'refTableClass'     => 'Model_Sprints',
            'refColumns'        => 'id'
        ),
        'tracking' => array(
            'columns'           => 'id',
            'refTableClass'     => 'Model_Trackings',
            'refColumns'        => 'taskId'
        ),
    );
    protected $_columns = array(
        'id' => 'Id',
        'name' => 'Nom',
        'estimatedDuration' => 'Durée estimée'
    );

    public function getAll($sprintId) {
        $columnsToDisplay = empty($this->_columns) ? $this->_getCols() : array_keys($this->_columns);
        $where = $this->select()->from($this, $columnsToDisplay);
        $where->where('sprintId = ?', $sprintId);
        return $this->fetchAll($where);
    }
    
}
