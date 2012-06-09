<?php

class My_DatabaseTestCase extends Zend_Test_PHPUnit_DatabaseTestCase
{
	private $_connectionMock;

	/**
	 * Returns the test database connection.
	 *
	 * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
	 */
	protected function getConnection() {
		if ($this->_connectionMock === null) {
			$dbOptions = array(
				'adapter' => 'PDO_MYSQL',
				'params' => array(
					'host' => 'localhost',
					'username' => 'root',
					'password' => '',
					'dbname' => 'notes',
				)
			);

			$connection = Zend_Db::factory($dbOptions['adapter'], $dbOptions['params']);
			$this->_connectionMock = $this->createZendDbConnection($connection, 'zfunittests');
			Zend_Db_Table_Abstract::setDefaultAdapter($connection);
		}
		return $this->_connectionMock;
	}

	/**
	 * @return PHPUnit_Extensions_Database_DataSet_IDataSet
	 */
	protected function getDataSet() {
		return $this->createFlatXmlDataSet(DOCUMENT_ROOT . '/tests/data/models/init.xml');
	}

	/**
	 * Assert table with a data set
	 *
	 * @param Zend_Db_Table $table table to assert
	 * @param string $file dataset filename
	 */
	protected function assertTableDataSetsEqual(Zend_Db_Table_Abstract $table, $file) {
		$ds = new Zend_Test_PHPUnit_Db_DataSet_DbTableDataSet();
		$ds->addTable($table);

		$this->assertDataSetsEqual($this->createFlatXmlDataSet($file), $ds);
	}

}
