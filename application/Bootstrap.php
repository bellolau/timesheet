<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initAutoload() {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('My_');

        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
            'basePath'		=> DOCUMENT_ROOT . '/application',
            'namespace'		=> '',
            'resourceTypes'	=> array(
                'model' => array(
                    'path'		=> 'models/',
                    'namespace'	=> 'Model'
                ),
                'form' => array(
                    'path'		=> 'forms/',
                    'namespace'	=> 'Form'
                )
            ),
        ));
        
        return $autoloader;
    }
    
    protected function _initTranslate() {
        $this->bootstrap('view');
        $view = $this->getResource('view');

        $translate = new Zend_Translate(
                        'gettext',
                        APPLICATION_PATH . '/languages',
                        'fr',
                        array('scan' => Zend_Translate::LOCALE_FILENAME)
        );
        $availableLanguages = $translate->getList();

        try {
            $requestedLanguage = new Zend_Locale(Zend_Locale::BROWSER);
        } catch (Zend_Locale_Exception $e) {
            $requestedLanguage = 'en';
        }

        if (in_array($requestedLanguage, $availableLanguages)) {
            $translate->setLocale($requestedLanguage);
        }

        // Save in registery to use into Zend_Form object
        Zend_Registry::set('Zend_Translate', $translate);
        $view->translate = $translate;
    }
    
}
