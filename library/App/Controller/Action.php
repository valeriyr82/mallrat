<?php

/**
 * This class add several features to the standard controller class
 *
 * @package    App_Controller
 * @subpackage Action
 * @copyright  Copyright (c) 2012
 * @version    v0.1
 * @since      Version 0.1
 * @author     Nikita Fedorov
 */
class App_Controller_Action extends Zend_Controller_Action
{
	
	/**
     * @var Zend_Session_Namespace
     */
    protected $_session = null;

    /**
     * @var Zend_Auth
     */
    protected $_auth = null;

    /**
     * @var array
     */
    protected $_user = array();
    
	
	/**
     * Constructor overload
     */
    public function __construct(
        Zend_Controller_Request_Abstract $request, 
        Zend_Controller_Response_Abstract $response, 
        array $invokeArgs = array()
    )
    {
        parent::__construct($request, $response, $invokeArgs);

        // session
        $this->_session = new Zend_Session_Namespace('App');
		$this->_checkAuth();
        
    }

    /**
     * Sends response to ajax requests
     * 
     * @param bool $result
     * @param array $response
     */
    protected function _json($result, $response = array())
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->getResponse()->setHeader('Content-Type', 'application/json');
        } else {
            $this->getResponse()->setHeader('Content-Type', 'text/html');
        }
        
        $data = array(
            'result'   => $result,
            'request'  => $this->getRequest()->getPost(),
            'response' => $response
        );
        $data = Zend_Json::encode($data);
        
        // disable view and layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        // send response
        $response = $this->getResponse();
        $response->setBody($data)
                 ->sendResponse();

        exit();
    }

	/**
     * Trigger error on action
     *
     * @param  int $code Error code
     *
     * @return void
     */
    protected function _error($code = 0)
    {
        switch ($code) {
            case 404:
                //throw new Zend_Controller_Action_Exception('Not found', 404);
                $this->view->errorMessage = 'Sorry, but the page you requested could not be found.';
                $this->_forward('index', 'index', 'frontend');
                break;

            case 403:
                throw new Zend_Controller_Action_Exception('Forbidden', 403);
                break;

            default:
                throw new Zend_Controller_Action_Exception('Application error', 500);
        }
    }
    
   
    
    /*
     *  Function for checking user authorization
     */
	protected function _checkAuth()
	{
		if(!Zend_Auth::getInstance()->hasIdentity()) 
		{
			//return ($this->_redirect('/'));
		}
	}
    
}