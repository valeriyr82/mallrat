<?php

/**
 * View Helper to display form errors
 *
 * @category   BeMail
 * @package    App_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2010, RonasIT
 * @version    v0.1
 * @since      Version 0.1
 * @author     Andrey Kurashev
 */
class Zend_View_Helper_FormErrorsWrapper extends Zend_View_Helper_Abstract
{
    /**
     * @var Zend_Form
     */
    protected $_form;

    /**
     * Error messages local cache
     * 
     * @var array
     */
    protected $_messages = array();

    /**
     * Direct - return self
     *
     * @param  Zend_Form $form
     * @return Zend_View_Helper_FormErrorsWrapper
     */
    public function formErrorsWrapper($form)
    {
        $this->_form = $form;
        if ($this->_form->isErrors()) {
            $this->_messages = $this->_form->getMessages();
        }

        return $this;
    }
    
    /**
     * 
     * Checking if form has Errors
     * 
     * @param Zend_Form $form
     * @return bool
     */
    public function hasErrors($form)
    {
    	$this->_form = $form;
        if ($this->_form->isErrors()) {
        	return TRUE;
        }else{
        	return FALSE;
        }
    }

    /**
     * Render element errors
     *
     * @param  string $name Element name
     * @return string
     */
    public function printErrors($name = null)
    {
        // add error for form
        if ($name === null) {
            $errors = $this->_form->getErrorMessages();
            if (!empty($errors)) {
                $html = '<div id="form_errors" class="form_errors"><ul class="errors"><li>'
                      . implode('</li><li>', $errors)
                      . '</li></ul></div>';

                return $html;
            } else {
                return '<div id="form_errors" class="form_errors" style="display: none;"></div>';
            }
        // add error for element
        } else {
            if (!empty($this->_messages[$name])) {
                $html = '<div class="' . $name . '_errors" '
                      . 'id="' . $name . '_errors">'
                      . '<ul class="errors"><li>'
                      . implode('</li><li>', $this->_messages[$name])
                      . '</li></ul></div>';

                return $html;
            } else {
                return '<div class="' . $name . '_errors" style="display: none;"'
                     . 'id="' . $name . '_errors"></div>';
            }
        }
    }
}
