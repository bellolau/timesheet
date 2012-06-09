<?php

/**
 * Description of ErrorControllerTest
 *
 * @author Laurent BELLO
 */
class ErrorControllerTest extends My_ControllerTestCase
{
	public function testControllerError() {
		$this->dispatch('/poup');
		$this->assertResponseCode(404);
		$this->assertController('error');
		$this->assertAction('error');
	}

	public function testActionError() {
		$this->authenticate();
		$this->dispatch('/index/poup');
		$this->assertResponseCode(404);
		$this->assertController('error');
		$this->assertAction('error');
	}

}
