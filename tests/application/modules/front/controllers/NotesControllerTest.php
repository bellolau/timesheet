<?php

/**
 * NotesControllerTest
 *
 * @author Laurent BELLO
 */
class NotesControllerTest extends My_ControllerTestCase {

	public function testIndexPage() {
		$this->dispatch('/notes');
		$this->assertResponseCode(200);
		$this->assertController('notes');
		$this->assertAction('index');
	}

}
