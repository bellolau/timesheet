<?php

/**
 * Description of Project
 *
 * @author bellolau
 */
class Model_Db_Table_Row_Sprint extends Zend_Db_Table_Row_Abstract {

    public function __construct(array $config = array()) {
        parent::__construct($config);

        if (isset($this->startDate) && $this->startDate !== null) {
            $this->startDate = new Zend_Date($this->startDate, 'yyyy-MM-dd');
        }

        if (isset($this->endDate) && $this->endDate !== null) {
            $this->endDate = new Zend_Date($this->endDate, 'yyyy-MM-dd');
        }
        
        $this->_data['estimatedDuration'] = 0;
        $this->_data['consumed'] = 0;
        $this->_data['toBeDone'] = 0;
        $this->_data['newEstimatedDuration'] = 0;
        $this->_data['gap'] = 0;
        $this->_data['progress'] = 0;

        if (!empty($this->id)) {
            $this->_data['tasks'] = $this->findDependentRowset('Model_Tasks');
        } else {
            $this->_data['tasks'] = new Zend_Db_Table_Rowset(array());
        }

        $this->_calculation();
    }

    public function _calculation() {
        if ($this->tasks->count() > 0) {
            foreach ($this->tasks as $task) {
                $this->estimatedDuration+= $task->estimatedDuration;
                $this->consumed+= $task->consumed;
                $this->toBeDone+= $task->toBeDone;
                $this->newEstimatedDuration+= $task->newEstimatedDuration;
            }

            $this->_data['gap'] = $this->newEstimatedDuration - $this->estimatedDuration;
        }

        if ($this->newEstimatedDuration > 0) {
            $this->_data['progress'] = $this->consumed / $this->newEstimatedDuration;
        }
    }

}
