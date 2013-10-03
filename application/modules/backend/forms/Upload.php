<?php

class Backend_Form_Upload extends Zend_Form {
	
	/**
    * Initialize settings for new instance
    * 
    * @return void
    */
	
    public function __construct()
    {
        $this->init();

    }
    	
	public function init()
	{
		//field birth_month:init
			$type = new Zend_Form_Element_Select('form_image_type');
			$type->setRequired(true);
			$type->addMultiOptions(array(
			'1'  => 'Man', 
			'0'  => 'Woman'
			));
		//field birth_month:validators
		
		//field birth_month:add
			$this->addElement($type);
			
		//form upload choose: init
		$upload = new Zend_Form_Element_File('form_image_choose');
		$upload->setRequired(true);
		
		//form upload chose: validators
		$validator = new Zend_Validate_File_Extension('jpg,png');
		$validator->setMessage('Invalid format of the file');
		$upload->addValidator($validator, true);
		
		$validator = new Zend_Validate_File_NotExists('uploads/');
		$validator->setMessage('File already exists');
		$upload->addValidator($validator, true);

		//form upload choose: add
		$this->addElement($upload);
		
		//form upload caption: init
		$caption = new Zend_Form_Element_Text('form_image_caption');
		$caption->addFilter('StripTags');
		
		//form upload caption: add
		$this->addElement($caption);
		
		//form upload submit: init
		$submit = new Zend_Form_Element_Submit('form_image_submit');
		$submit->setLabel('Upload');
		
		//form upload submit: add
		$this->addElement($submit);
	}
}