<?php

class Model_ProjectUser extends Zend_Db_Table {

    protected $_name = 'project_user';
    protected $_primary = array('projectId', 'userId');
    protected $_referenceMap = array(
        'project' => array(
            'columns' => 'projectId',
            'refTableClass' => 'Model_Projects',
            'refColumns' => 'id'
        ),
        'user' => array(
            'columns' => 'userId',
            'refTableClass' => 'Model_Users',
            'refColumns' => 'id'
        )
    );

}
