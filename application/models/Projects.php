<?php

class Model_Projects extends My_Model_Crud_Abstract {

    protected $_name = 'project';
    protected $_primary = 'id';
    protected $_rowClass = 'Model_Db_Table_Row_Project';
    protected $_referenceMap = array(
        'sprint' => array(
            'columns' => 'id',
            'refTableClass' => 'Model_Sprints',
            'refColumns' => 'projectId'
        ),
        'user' => array(
            'columns' => 'id',
            'refTableClass' => 'Model_Project_User',
            'refColumns' => 'projectId'
        )
    );
    protected $_columns = array(
        'id' => 'Id',
        'name' => 'Nom',
        'reference' => 'Référence',
        'sold' => 'Vendu'
    );

    public function insert(array $data) {
        $data["date"] = isset($data["date"]) ? $data["date"] : date('Y-m-d H:i:s');

        return parent::insert($data);
    }

    /**
     * Get project by name
     *
     * @param string $name Name of the project
     * @param int $notId (optional) Id not selected
     * @return Zend_Db_Table_Row or null if any row found
     */
    public function getByName($name, $notId = null) {
        $where = $this->select()->where('name = ?', $name);

        if ($notId !== null) {
            $where->where('id != ?', $notId);
        }

        return $this->fetchRow($where);
    }

    /**
     * Get project by reference
     *
     * @param string $reference Reference of the project
     * @param int $notId (optional) Id not selected
     * @return Zend_Db_Table_Row or null if any row found
     */
    public function getByReference($reference, $notId = null) {
        $where = $this->select()->where('reference = ?', $reference);

        if ($notId !== null) {
            $where->where('id != ?', $notId);
        }

        return $this->fetchRow($where);
    }

}
