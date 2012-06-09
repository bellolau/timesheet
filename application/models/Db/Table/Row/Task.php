<?php

/**
 * Description of Project
 *
 * @author bellolau
 */
class Model_Db_Table_Row_Task extends Zend_Db_Table_Row_Abstract {

    public function __construct(array $config = array()) {
        parent::__construct($config);

        $this->_data['consumed'] = 0;
        $this->_data['gap'] = 0;
        $this->_data['progress'] = 0;
        if (!empty($this->id)) {
            $this->_data['trackings'] = $this->findDependentRowset('Model_Trackings');
        } else {
            $this->_data['trackings'] = new Zend_Db_Table_Rowset(array());
        }
        $this->_calculation();
    }

    public function _calculation() {
        if ($this->trackings->count() > 0) {
            foreach ($this->trackings as $tracking) {
                $this->consumed+= $tracking->duration;
            }

            $this->_data['toBeDone'] = $tracking->newEstimatedDuration;
            $this->_data['newEstimatedDuration'] = $this->consumed + $this->toBeDone;
            $this->_data['gap'] = $this->newEstimatedDuration - $this->estimatedDuration;
        } else {
            $this->_data['toBeDone'] = $this->estimatedDuration;
            $this->_data['newEstimatedDuration'] = $this->estimatedDuration;
        }

        if ($this->newEstimatedDuration > 0) {
            $this->_data['progress'] = $this->consumed / $this->newEstimatedDuration;
        }
    }

}
