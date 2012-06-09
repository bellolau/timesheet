<?php

/**
 * My_Auth
 *
 * Plugin to check user right
 *
 * @package My
 * @version 1
 */
class My_Auth extends Zend_Controller_Plugin_Abstract {
    /**
     * Redirection path when user rights checks fail
     */

    const FAIL_ACL_MODULE = 'default';
    const FAIL_ACL_ACTION = 'rights';
    const FAIL_ACL_CONTROLLER = 'error';

    /**
     * @var Zend_Auth instance
     */
    private $_auth;

    /**
     * @var Zend_Acl instance
     */
    private $_acl;

    /**
     * Constructor
     */
    public function __construct() {
        $aclIniFile = APPLICATION_PATH . '/configs/acl.ini';
        $acl = new My_Acl_Ini($aclIniFile);

        $this->_acl = $acl;
        $this->_auth = Zend_Auth::getInstance();
    }

    /**
     * Check user rights
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $role = 'guest';
        // Get user role if connected
        if ($this->_auth->hasIdentity()) {
            $email = $this->_auth->getIdentity();
            $usersModel = new Model_Users();
            $user = $usersModel->getByEmail($email);

            if ($user !== null) {
                $userNamespace = new Zend_Session_Namespace('user');
                $userNamespace->infos = $user;

                $role = isset($user->role) ? $user->role : 'member';
            }
        } else {
            Zend_Session::namespaceUnset('user');
        }

        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();

        $resource = $module . '_' . $controller;

        if (!$this->_acl->has($resource)) {
            throw new Zend_Controller_Router_Exception('', 404);
        }

        // Check user rights
        if (!$this->_acl->isAllowed($role, $resource, $action)) {
            // Redirect if is not allowed
            $module = self::FAIL_ACL_MODULE;
            $controller = self::FAIL_ACL_CONTROLLER;
            $action = self::FAIL_ACL_ACTION;
        }

        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);
    }

}
