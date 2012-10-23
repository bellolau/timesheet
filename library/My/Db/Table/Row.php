<?php

class My_Db_Table_Row extends Zend_Db_Table_Row_Abstract {
	
	public function save() {
		$table = $this->getTable();
		$cols = $table->getCols();

		foreach($this as $col => $value) {
			if (!in_array($col, $cols)) {
				unset($this->$col);
			}
		}

		parent::save();
	}
	
}
