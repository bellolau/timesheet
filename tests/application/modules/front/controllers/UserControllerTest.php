<?php

/**
 * IndexControllerTest
 *
 * @author Laurent BELLO
 */
class UserControllerTest extends My_ControllerTestCase
{
	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testLoginPageNoLogged() {
		$this->dispatch('/user/login');
		$this->assertResponseCode(200);
		$this->assertController('user');
		$this->assertAction('login');
		$this->assertNoAuthenticate();
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testLoginPageWithBadLogin() {
		$this->request->setMethod('POST');
		$this->_request->setPost(array(
			'email' => 'toto@toto.com',
			'password' => 'toto'
		));
		$this->dispatch('/user/login');
		$this->assertResponseCode(200);
		$this->assertController('user');
		$this->assertAction('login');
		$this->assertNoAuthenticate();
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testLoginPageWithGoodLogin() {
		$this->request->setMethod('POST');
		$this->_request->setPost(array(
			'email' => 'bellolau@gmail.com',
			'password' => 'H1k3xs0'
		));
		$this->dispatch('/user/login');
		$this->assertRedirectTo('/');
		$this->assertAuthenticate();
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testLoginPageLogged() {
		$this->assertTrue($this->authenticate());

		$this->dispatch('/user/login');
		$this->assertRedirectTo('/');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testLogoutPageNoLogged() {
		$this->dispatch('/user/logout');
		$this->assertRedirectTo('/');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testLogoutPageLogged() {
		$this->assertTrue($this->authenticate());

		$this->dispatch('/user/logout');
		$this->assertRedirectTo('/');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testCreatePageNoLogged() {
		$this->dispatch('/user/create');
		$this->assertResponseCode(200);
		$this->assertController('user');
		$this->assertAction('create');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testCreatePageWithBadInformations() {
		$this->_request->setMethod('POST');
		$this->_request->setPost(array(
			'email' => 'tt',
			'password' => 'df'
		));
		$this->dispatch('/user/create');
		$this->assertResponseCode(200);
		$this->assertController('user');
		$this->assertAction('create');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testCreatePageWithGoodInformations() {
		$this->_request->setMethod('POST');
		$this->_request->setPost(array(
			'firstname' => 'test1',
			'lastname' => 'test',
			'email' => 'test1@test.com',
			'password' => 'df',
			'confirmPassword' => 'df',
		));
		$this->dispatch('/user/create');
		$this->assertRedirectTo('/user/good');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testCreatePageWithAlreadyEmailUsed() {
		$this->_request->setMethod('POST');
		$this->_request->setPost(array(
			'firstname' => 'test1',
			'lastname' => 'test',
			'email' => 'test1@test.com',
			'password' => 'df',
			'confirmPassword' => 'df',
		));
		$this->dispatch('/user/create');
		$this->assertResponseCode(200);
		$this->assertController('user');
		$this->assertAction('create');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testCreatePageLogged() {
		$this->assertTrue($this->authenticate());

		$this->dispatch('/user/create');
		$this->assertRedirectTo('/');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testGoodPageNoLogged() {
		$this->dispatch('/user/good');
		$this->assertResponseCode(200);
		$this->assertController('user');
		$this->assertAction('good');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testGoodPageLogged() {
		$this->assertTrue($this->authenticate());

		$this->dispatch('/user/good');
		$this->assertResponseCode(200);
		$this->assertController('user');
		$this->assertAction('good');
	}
	
	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testActivePageWithoutHash() {
		$this->dispatch('/user/active');
		$this->assertResponseCode(200);
		$this->assertController('user');
		$this->assertAction('active');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testActivePageWithUndefinedHash() {
		$this->_request->setQuery(array(
			'hash' => 99
		));

		$this->dispatch('/user/active');
		$this->assertResponseCode(200);
		$this->assertController('user');
		$this->assertAction('active');
	}

	/**
	 * @author Laurent BELLO
	 * @group controllers
	 */
	public function testActivePageWithGoodHash() {
		$userModel = new Front_Model_Users();
		$user = $userModel->find(1)->current();

		$data = array(
			'active' => 0
		);
		$userModel->update($data, array('userId = ?' => $user->userId));

		$this->_request->setQuery(array(
			'hash' => $user->hash
		));

		$this->dispatch('/user/active');
		$this->assertResponseCode(200);
		$this->assertController('user');
		$this->assertAction('active');

		$user = $userModel->find(1)->current();
		$this->assertEquals(1, $user->active);
	}

}
