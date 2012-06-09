<?php

/**
 * Front_Model_UsersTest
 *
 * @author Laurent BELLO
 */
class Front_Model_UsersTest extends My_DatabaseTestCase
{
	private $_users;

	public function setUp() {
		parent::setUp();
		$this->_users = new Front_Model_Users();
	}

	public function assertPreConditions() {
		$this->assertEquals('Front_Model_Users', get_class($this->_users));
	}

	private function insertUserTest() {
		$data = array(
			'active' => 0,
			'firstname' => 'Test1',
			'lastname' => 'Test',
			'email' => 'test1@test.com',
			'password' => 'test',
			'confirmPassword' => 'test',
			'role' => 'member',
			'created' => '2010-09-18 16:51:00',
			'lastModified' => '2010-09-18 16:51:00',
			'hash' => '344'
		);
		$this->_users->insert($data);
	}

	/**
	 * @author Laurent BELLO
	 * @group models
	 */
	public function testGenerateUniqId() {
		$this->assertType('string', Front_Model_Users::generateUniqId());
	}

	/**
	 * @author Laurent BELLO
	 * @group models
	 */
	public function testGetUniqId() {
		$this->assertType('string', $this->_users->getUniqId());
	}

	/**
	 * @author Laurent BELLO
	 * @group models
	 */
	public function testUserInsertedIntoDatabase() {
		$this->insertUserTest();

		$dataSetFile = DOCUMENT_ROOT. "/tests/data/models/users/afterInsert.xml";
		$this->assertTableDataSetsEqual($this->_users, $dataSetFile);
		$this->assertTrue(is_array($this->_users->getUser('test1@test.com')));
	}

	/**
	 * @author Laurent BELLO
	 * @group models
	 */
	public function testUserUpdatedIntoDatabase() {
		$this->insertUserTest();

		$data = array(
			'active' => 1,
			'lastModified' => '2010-09-18 17:03:00'
		);
		$this->_users->update($data, array('userId = ?' => 2));

		$dataSetFile = DOCUMENT_ROOT. "/tests/data/models/users/afterUpdate.xml";
		$this->assertTableDataSetsEqual($this->_users, $dataSetFile);
	}

	/**
	 * @author Laurent BELLO
	 * @group models
	 */
	public function testUserDeletedFromDatabase() {
		$this->insertUserTest();

		$this->_users->delete(array('userId = ?' => 2));

		$dataSetFile = DOCUMENT_ROOT. "/tests/data/models/users/afterDelete.xml";
		$this->assertTableDataSetsEqual($this->_users, $dataSetFile);
		$this->assertFalse($this->_users->getUser('test1@test.com'));
	}

}
