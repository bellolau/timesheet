<?php

/**
 * My_Acl_Ini
 *
 * Classe de création des ACL via un fichier de configuration INI
 *
 * @author Laurent BELLO
 */
class My_Acl_Ini extends Zend_Acl
{
    public function __construct($file) {
        $roles = new Zend_Config_Ini($file, 'roles');
        $this->_setRoles($roles);

        $ressources = new Zend_Config_Ini($file, 'ressources');
        $this->_setRessources($ressources);

        foreach ($roles->toArray() as $role => $parents) {
            $privileges = new Zend_Config_Ini($file, $role);
            $this->_setPrivileges($role, $privileges);
        }
    }

    protected function _setRoles($roles) {
        foreach ($roles as $role => $parents) {
            if (empty($parents)) {
                $parents = null;
            } else {
                $parents = explode(',', $parents);
            }

            $this->addRole(new Zend_Acl_Role($role), $parents);
        }

        return $this;
    }

    protected function _setRessources($ressources) {
        foreach ($ressources as $ressource => $parents) {
            if (empty($parents)) {
                $parents = null;
            }

            $this->add(new Zend_Acl_Resource($ressource), $parents);
        }

        return $this;
    }

    protected function _setPrivileges($role, $privileges) {
        foreach ($privileges as $do => $ressources) {
            foreach ($ressources as $ressource => $actions) {
                if (empty($actions)) {
                    $actions = null;
                } else {
                    $actions = explode(',', $actions);
                }

                $this->{$do}($role, $ressource, $actions);
            }
        }

        return $this;
    }

}
