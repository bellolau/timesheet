<?php

class Model_Users extends My_Model_Crud_Abstract {
    const SALT = "djhfml";

    protected $_name = 'user';
    protected $_primary = 'id';
    protected $_referenceMap = array(
        'project' => array(
            'columns'           => 'id',
            'refTableClass'     => 'Model_ProjectUser',
            'refColumns'        => 'userId'
        ),
        'tracking' => array(
            'columns'           => 'id',
            'refTableClass'     => 'Model_Tracking',
            'refColumns'        => 'userId'
        )
    );
    protected $_columns = array(
        'userId' => 'Id',
        'email' => 'Mail',
        'CONCAT(firstname, \' \', lastname)' => 'Name',
        'active' => 'Activated',
        'role' => 'Role'
    );

    public function insert(array $data) {
        $data["created"] = isset($data["created"]) ? $data["created"] : date('Y-m-d H:i:s');
        $data["lastModified"] = isset($data["lastModified"]) ? $data["lastModified"] : date('Y-m-d H:i:s');
        $data["hash"] = isset($data["hash"]) ? $data["hash"] : $this->getUniqId();

        if (isset($data["confirmPassword"])) {
            unset($data["confirmPassword"]);
        }

        if (isset($data["password"])) {
            $data["password"] = self::encryptPassword($data["password"]);
        }

        return parent::insert($data);
    }

    public function update(array $data, $where) {
        $data["lastModified"] = isset($data["lastModified"]) ? $data["lastModified"] : date('Y-m-d H:i:s');

        if (isset($data["confirmPassword"])) {
            unset($data["confirmPassword"]);
        }

        if (isset($data["password"])) {
            $data["password"] = self::encryptPassword($data["password"]);
        }

        return parent::update($data, $where);
    }

    /**
     * Get user by email
     *
     * @param string $email
     * @return Zend_Db_Table_Row or null if any row found
     */
    public function getByEmail($email) {
        $where = $this->select()->where('email = ?', $email);

        return $this->fetchRow($where);
    }

    /**
     * Authenticate user
     * 
     * @param string $email
     * @param string $password
     * @return bool True if authentication success or false if not
     */
    public static function authenticate($email, $password) {
        $authAdapter = new Zend_Auth_Adapter_DbTable(null, 'user', 'email', 'password');
        $authAdapter->setIdentity($email);
        $authAdapter->setCredential(self::encryptPassword($password));

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);

        return $result->isValid();
    }

    public function getUniqId() {
        $uniqId = self::generateUniqId();
        $result = $this->fetchRow(array('hash = ?' => $uniqId));

        while ($result !== null) {
            $uniqId = self::generateUniqId();
            $result = $this->fetchRow(array('hash = ?' => $uniqId));
        }

        return $uniqId;
    }

    public static function generateUniqId() {
        return uniqid(md5(rand()), true);
    }

    public static function encryptPassword($password) {
        return sha1(self::SALT . $password . self::SALT);
    }

}
