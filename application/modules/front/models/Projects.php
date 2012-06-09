<?php

class Front_Model_Projects extends My_Model_Crud_Abstract {

    protected $_name = 'project';
    protected $_primary = 'id';
    protected $_columns = array(
        'id' => 'Id',
        'name' => 'Name',
        'reference' => 'Reference',
        'date' => 'Created'
    );

//    protected $_rowClass = 'Model_Db_Table_Row_Project';

    public function insert(array $data) {
        $data["date"] = isset($data["date"]) ? $data["date"] : date('Y-m-d H:i:s');

        return parent::insert($data);
    }

    /**
     * Get project by name
     * 
     * @param string $name Name of the project
     * @return Zend_Db_Table_Row or null if any row found
     */
    public function getByName($name) {
        $where = $this->select()->where('name = ?', $name);

        return $this->fetchRow($where);
    }

    /**
     * Get project by reference
     * 
     * @param string $reference Reference of the project
     * @return Zend_Db_Table_Row or null if any row found
     */
    public function getByReference($reference) {
        $where = $this->select()->where('reference = ?', $reference);

        return $this->fetchRow($where);
    }

}
