<?php

class Model_Sprints extends My_Model_Crud_Abstract {

    protected $_name = 'sprint';
    protected $_primary = 'id';
    protected $_rowClass = 'Model_Db_Table_Row_Sprint';
    protected $_referenceMap = array(
        'project' => array(
            'columns'           => 'projectId',
            'refTableClass'     => 'Model_Projects',
            'refColumns'        => 'id'
        ),
        'task' => array(
            'columns'           => 'id',
            'refTableClass'     => 'Model_Tasks',
            'refColumns'        => 'sprintId'
        ),
    );
    protected $_columns = array(
        'id' => 'Id',
        'name' => 'Nom',
        'startDate' => 'Date de début',
        'endDate' => 'Date de fin'
    );

    public function getAll($projectId) {
        $columnsToDisplay = empty($this->_columns) ? $this->_getCols() : array_keys($this->_columns);
        $where = $this->select()->from($this, $columnsToDisplay);
        $where->where('projectId = ?', $projectId);
        return $this->fetchAll($where);
    }
    
}
