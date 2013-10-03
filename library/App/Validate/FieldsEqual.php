<?php

/**
 * Validate if two fields are equal
 *
 * @category   BeMail
 * @package    App_Validate
 * @copyright  Copyright (c) 2010, RonasIT
 * @version    v0.1
 * @since      Version 0.1
 * @author     Andrey Kurashev
 */
class App_Validate_FieldsEqual extends Zend_Validate_Abstract
{
    const INVALID = 'invalid';

    /**
     * Form element name
     * 
     * @var string
     */
    protected $_contextKey = null;

    /**
     * Validation failure message template definition
     * 
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "Fields are not equal",
    );

    /**
     * Set deafult values for new instance
     * 
     * @param string $key
     * @return void
     */
    public function __construct($key)
    {
        $this->_contextKey = $key;
    }

    /**
     * Defined by Zend_Validate_Interface
     *
     * Return true if two fields are equal
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value, $context = null)
    {
        $valueString = (string) $value;
        $this->_setValue($valueString);

        if (isset($context[$this->_contextKey])) {
            if (is_array($context)) {
                $token = $context[$this->_contextKey];
            } else if (is_string($context)) {
                $token = $context;
            } else {
                $token = null;
            }

            $validator = new Zend_Validate_Identical($token);
            if ($validator->isValid($valueString)) {
                return true;
            }
        }

        $this->_error(self::INVALID);
        return false;
    }
}