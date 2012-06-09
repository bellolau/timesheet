<?php

/**
 * ControllerTestCase
 *
 * @author Laurent BELLO
 */
class My_ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
	public function setUp() {
		$this->bootstrap = new Zend_Application(
            'testing',
            APPLICATION_PATH . '/configs/application.ini'
        );

        parent::setUp();
	}

	public function tearDown() {
		Zend_Controller_Front::getInstance()->resetInstance();
        $this->resetRequest();
        $this->resetResponse();

        $this->request->setPost(array());
        $this->request->setQuery(array());
	}

	protected function authenticate() {
		return Front_Model_Users::authenticate('bellolau@gmail.com', 'H1k3xs0');
	}

	public function assertAuthenticate() {
		$auth = Zend_Auth::getInstance();
		$this->assertTrue($auth->hasIdentity());
	}

	public function assertNoAuthenticate() {
		$auth = Zend_Auth::getInstance();
		$this->assertFalse($auth->hasIdentity());
	}

}
