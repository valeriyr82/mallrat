<?php

/**
 * Validate if value contains email address in custom format
 *
 * @category   VerBase
 * @package    App_Validate
 * @copyright  Copyright (c) 2011, RonasIT
 * @version    v0.1
 * @since      Version 0.1
 * @author     Andrey Kurashev
 */
class App_Validate_Email extends Zend_Validate_Abstract
{
    const INVALID = 'hasInvalidFormat';
       
    /**
     * Validation failure message template definition
     * 
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => '%value% has invalid email format'
    );
    
    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if $value contains only english alphabetic and digit characters,
     * and maybe some additional allowed characters
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);
        
        if (preg_match_all(
            '/(?:\s|^)?<?((?:\S*?)@(?:\S*?))>?(?:\s|,|;|$)/',
            $value, $emails
        )) {
            $validator = new Zend_Validate_EmailAddress();
            for ($i = 0; $i < count($emails[1]); $i++) {
                if (!$validator->isValid($emails[1][$i])) {
                    $this->_error(self::INVALID);
                    return false;
                }
            }
        } else {
            $this->_error(self::INVALID);
            return false;
        }
        return true;
    }
}