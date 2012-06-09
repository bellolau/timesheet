<?php

/**
 * IndexControllerTest
 *
 * @author Laurent BELLO
 */
class IndexControllerTest extends My_ControllerTestCase
{
	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testIndexPageNoLogged() {
		$this->dispatch('/index/index');
		$this->assertResponseCode(200);
		$this->assertController('user');
		$this->assertAction('login');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testIndexPageLogged() {
		$this->assertTrue($this->authenticate());

		$this->dispatch('/index/index');
		$this->assertResponseCode(200);
		$this->assertController('index');
		$this->assertAction('home');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testHomePageNoLogged() {
		$this->dispatch('/index/home');
		$this->assertResponseCode(403);
		$this->assertController('error');
		$this->assertAction('rights');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testHomePageLogged() {
		$this->assertTrue($this->authenticate());

		$this->dispatch('/index/home');
		$this->assertResponseCode(200);
		$this->assertController('index');
		$this->assertAction('home');
	}

}
