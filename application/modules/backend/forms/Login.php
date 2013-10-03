<?php

class Backend_Form_Login extends Zend_Form {
	
	/**
    * Initialize settings for new instance
    * 
    * @return void
    */
    public function __construct()
    {
        $this->init();
        $this->clearDecorators();
        $this->setElementDecorators(array('ViewHelper'));
    }
    
	public function init()
	{
		
		//field username:init
		$username = new Zend_Form_Element_Text('form_login_login');
		$username->addFilter('StripTags');
		$username->setRequired(true);
		
		//field username: validators
		$validator = new Zend_Validate_NotEmpty();
        $validator->setMessages(
            array('isEmpty' => 'Please enter your login')
        );
        $validator->setDefaultTranslator($this->translate);
        $username->addValidator($validator, true);
				
/*        $validator = new Zend_Validate_Db_RecordExists(array(
        'table' => 'user',
        'field' => 'user_username'
   		));
   		$validator->setMessages(array('recordFound' => 'Username is incorrect'));
		$validator->setDefaultTranslator($this->translate);
        $username->addValidator($validator, true);
  */      
		//field username:add
		$this->addElement($username);
		
		//field password: init
		$password = new Zend_Form_Element_Password('form_password_login');
		$password->setRequired(true);
		
		//field password: validators
		$validator = new Zend_Validate_NotEmpty();
        $validator->setMessages(
            array('isEmpty' => 'Please enter your password')
        );
        $validator->setDefaultTranslator($this->translate);
        $password->addValidator($validator, true);
        
		//field password: add
		$this->addElement($password);
		
		//field checkbox Remember_Me: init
		$remember = new Zend_Form_Element_Checkbox('form_remember_login');
		
		$remember->setOptions(
            array('class' => 'check',
                  'id' => 'remember')
        );
		
		//field checkbox Remember_me: add
		$this->addElement($remember);
		
		//field submit_button: init
		$submit = new Zend_Form_Element_Submit('form_submit_login');
		$submit->setLabel('Sign in');
		
		//field submit_button: add
		$this->addElement($submit);
		
		$backend = new Zend_Form_Element_Hidden('form_from_backend');
		$backend->setValue('backend');
		$this->addElement($backend);
	} 	
	
}