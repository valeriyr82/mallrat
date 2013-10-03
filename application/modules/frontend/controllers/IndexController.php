<?php

class IndexController extends App_Controller_Action
{
    private $utility;
    public function init()
    {
        /* Initialize action controller here */
        $this->utility=new Model_utility();
    }

    public function indexAction()
    {
    	
    	
    	if (!Zend_Auth::getInstance()->hasIdentity()){	    	
	    	$this->view->indexPage = true;
	    	$loginForm = new Form_Login();
	    	$this->view->loginForm = $loginForm;

	    	// handle form submit
	    	if ($formData = $this->getRequest()->getPost()) {
	    		// validate data
	    		if ($loginForm->isValid($formData)) {
	    			$values = $loginForm->getValues();
	    	
	    			$email    = $values['form_useremail_login'];
	    			$remember    = $values['form_remember_login'];
	    			$encPassword = hash("sha512", $values['form_password_login']);
	    			$backend = 0;
	    	
	    			// authenticate user
	    			$authResult = $this->_auth($email, $encPassword, $remember, $backend, $loginForm);
	    			if ($authResult === true) {
                       
	    				$user = Zend_Auth::getInstance()->getIdentity();
	    				$modelUser = new Model_DbTable_User();
	    				$modelUser->updateLastLogin($user['ID']);
	    			} else {
						echo "auth failed";
					}
	    		}
	    	}
    	}
        if (Zend_Auth::getInstance()->hasIdentity()){            
        $user = Zend_Auth::getInstance()->getIdentity();
         $data['user_data']=$user; 
      
        $dashboard_model=new Model_dashboard();
        $dash_data=$dashboard_model->getDashboradData();
       
        $data['user_id']=$user['ID'];
        $data['session_id']=$this->utility->getUserSession($user['ID']);
        $data['mall_id']=$dash_data[0]['MALL_ID'];
        $data['real_estate_id']=$dash_data[0]['REAL_ESTATE_ID'];
    	$data['mallrat_downloads'] = '';
    	$data['mall_sessions'] = '';
    	$data['users'] = '';
    	$data['fans'] = '';
    	$data['malls'] = '';
    	$data['map_sessions'] = '';
    	$data['map_sessions_avg'] = '';
    	$data['map_sessions_total'] = '';
        $data['menu_active']='dashboard';
        
    	$this->view->data = $data;
    	}
    	$modelActivity = new Model_DbTable_Activity();
    	$this->view->activity = $modelActivity->getRecentActivity();
        
    }
    public function getstatisticsAction()
        {
            $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
              
            $dash_model=new Model_dashboard();
            echo $dash_model->getStatistics($_POST); 
            exit;    
            }
            
        }
    public function logoutAction()
    {
        // logout user only if he is logged in
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $adapter = new App_Auth_Adapter_User();
            $adapter->logout();
        }
        $this->_redirect('/');
    }
    
    private function _auth($email, $password, $remember = '0', $backend = '', $form)
    {
    	 
    	// create auth adapter
    	$authAdapter = new App_Auth_Adapter_User($email, $password);
    	if ($remember === '1') {
    		$authAdapter->setAuthPersistent();
    	}
    	if ($backend) $authAdapter->loginFromBackend();
    	// authenticate
    	$result = Zend_Auth::getInstance()->authenticate($authAdapter);
    
        
    	// successful authentication
    	if ($result->isValid()) {
    		$returnValue = true;
    	} else {
    		// determine error code
    		switch ($result->getCode()) {
    			case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
    			case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
    				$form->addError('Invalid username or password. Please try again');
    				break;
    			case Zend_Auth_Result::FAILURE:
    				$error = $result->getMessages();
    				$form->addError($error[0]);
    				break;
    			default:
    				$form->addError('Application error was occured while trying to authenticate');
    		}
    		$returnValue = false;
    	}
    	return $returnValue;
    }
    
    public function billingAction()
    {
    	
    }
    
    public function dataAction()
    {
    	
    }
}