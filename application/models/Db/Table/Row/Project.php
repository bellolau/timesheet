<?php

/**
 * Description of Project
 *
 * @author bellolau
 */
class Model_Db_Table_Row_Project extends Zend_Db_Table_Row_Abstract {

    public function __construct(array $config = array()) {
        parent::__construct($config);

        $this->_data['startDate'] = null;
        $this->_data['endDate'] = null;
        $this->_data['estimatedDuration'] = 0;
        $this->_data['consumed'] = 0;
        $this->_data['toBeDone'] = 0;
        $this->_data['newEstimatedDuration'] = 0;
        $this->_data['gap'] = 0;
        $this->_data['progress'] = 0;

        if (!empty($this->id)) {
            $this->_data['sprints'] = $this->findDependentRowset('Model_Sprints');
            $this->_data['users'] = $this->findManyToManyRowset('Model_Users', 'Model_ProjectUser');
        } else {
            $this->_data['sprints'] = new Zend_Db_Table_Rowset(array());
            $this->_data['users'] = new Zend_Db_Table_Rowset(array());
        }
        $this->_calculation();
    }

    public function _calculation() {
        if ($this->sprints->count() > 0) {
            $startDate = $this->sprints->current()->startDate;
            $endDate = $this->sprints->current()->endDate;

            foreach ($this->sprints as $sprint) {
                $sprintStartDate = new Zend_Date($sprint->startDate, 'yyyy-MM-dd');
                if ($startDate->compare($sprintStartDate) === 1) {
                    $startDate = $sprintStartDate;
                }
                $sprintEndDate = new Zend_Date($sprint->endDate, 'yyyy-MM-dd');
                if ($endDate->compare($sprintEndDate) === -1) {
                    $endDate = $sprintEndDate;
                }
                $this->estimatedDuration+= $sprint->estimatedDuration;
                $this->consumed+= $sprint->consumed;
                $this->toBeDone+= $sprint->toBeDone;
                $this->newEstimatedDuration+= $sprint->newEstimatedDuration;
            }

            $this->startDate = $startDate;
            $this->endDate = $endDate;
            $this->gap = $this->newEstimatedDuration - $this->estimatedDuration;
        }

        if ($this->newEstimatedDuration > 0) {
            $this->_data['progress'] = $this->consumed / $this->newEstimatedDuration;
        }
    }

}
