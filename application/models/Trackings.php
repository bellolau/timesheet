<?php

class Model_Trackings extends My_Model_Crud_Abstract {

    protected $_name = 'tracking';
    protected $_primary = 'id';
    protected $_referenceMap = array(
        'task' => array(
            'columns'           => 'taskId',
            'refTableClass'     => 'Model_Tasks',
            'refColumns'        => 'id'
        ),
        'user' => array(
            'columns'           => 'userId',
            'refTableClass'     => 'Model_Users',
            'refColumns'        => 'id'
        ),
    );
    protected $_columns = array(
        'id' => 'Id',
        'duration' => 'Durée',
        'newEstimatedDuration' => 'Reste à faire'
    );

    public function getAll($sprintId) {
        $columnsToDisplay = empty($this->_columns) ? $this->_getCols() : array_keys($this->_columns);
        $where = $this->select()->from($this, $columnsToDisplay);
        $where->where('taskId = ?', $sprintId);
        return $this->fetchAll($where);
    }
    
}
