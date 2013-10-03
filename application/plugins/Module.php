<?php

class Plugin_Module extends Zend_Controller_Plugin_Abstract
{
    /**
     * Module specific configuration
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $config     = Zend_Controller_Front::getInstance()
                          ->getParam('bootstrap')->getOptions();
        $moduleName = $request->getModuleName();

        if (isset($config[$moduleName]['resources']['layout']['layout'])) {
            $layoutScript = $config[$moduleName]['resources']['layout']['layout'];
            Zend_Layout::getMvcInstance()->setLayout($layoutScript);
        }
    }
}