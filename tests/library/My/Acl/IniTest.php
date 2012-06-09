<?php

/**
 * My_Acl_IniTest
 *
 * @author Laurent BELLO
 */
class My_Acl_IniTest extends My_ControllerTestCase
{
	/**
	 * @author Laurent BELLO
	 * @group library
	 */
	public function testConstruct() {
		$iniFile = DOCUMENT_ROOT . '/tests/data/acl.ini';
		$myAclIni = new My_Acl_Ini($iniFile);

		$this->assertTrue($myAclIni instanceof  My_Acl_Ini);
		$this->assertTrue($myAclIni instanceof  Zend_Acl);

		$ressources = array('front_index', 'front_user');
		$this->assertEquals($ressources, $myAclIni->getResources());

		$roles = array('test1', 'test2');
		$this->assertEquals($roles, $myAclIni->getRoles());
	}

}
