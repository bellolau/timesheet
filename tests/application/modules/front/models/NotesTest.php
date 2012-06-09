<?php

class Front_Model_NotesTest extends My_DatabaseTestCase {

	private $_notes;

	public function setUp() {
		parent::setUp();
		$this->_notes = new Front_Model_Notes();
	}

	public function assertPreConditions() {
		$this->assertEquals('Front_Model_Notes', get_class($this->_notes));
	}

	public function insertNoteTest() {
		$data = array(
			'url' => 'http://www.facebook.com',
			'description' => 'LE réseau social',
			'created' => '2011-02-27 00:00:00'
		);
		$this->_notes->insert($data);
	}

	public function testNoteInsertedIntoDatabase() {
		$this->insertNoteTest();

		$dataSetFile = DOCUMENT_ROOT. "/tests/data/models/notes/afterInsert.xml";
		$this->assertTableDataSetsEqual($this->_notes, $dataSetFile);
	}

	public function testNoteUpdatedIntoDatabase() {
		$this->insertNoteTest();

		$data = array(
			'description' => 'L\'incontournable !'
		);
		$this->_notes->update($data, array('noteId = ?' => 2));

		$dataSetFile = DOCUMENT_ROOT. "/tests/data/models/notes/afterUpdate.xml";
		$this->assertTableDataSetsEqual($this->_notes, $dataSetFile);
	}

	public function testNoteDeletedFromDatabase() {
		$this->insertNoteTest();

		$this->_notes->delete(array('noteId = ?' => 2));

		$dataSetFile = DOCUMENT_ROOT. "/tests/data/models/notes/afterDelete.xml";
		$this->assertTableDataSetsEqual($this->_notes, $dataSetFile);
	}

}
