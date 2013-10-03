<?php

/**
 * Validate if value is proper user password
 *
 * @category   Verbase
 * @package    App_Validate
 * @copyright  Copyright (c) 2011, RonasIT
 * @version    v0.1
 * @since      Version 0.1
 * @author     Andrey Kurashev
 */
class App_Validate_Db_Password extends Zend_Validate_Abstract
{
    const INVALID = 'isInvalid';
       
    /**
     * Validation failure message template definition
     * 
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => 'Invalid password. Please try again'
    );
    
    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if $value is proper user password
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $modelUser = new Model_DbTable_User();
        $valid = true;
        $this->_setValue($value);
        
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $user = Zend_Auth::getInstance()->getIdentity();
            
            // get old hashed password to check
            $passwordDb = $modelUser->getUserById($user['user_id']);

            // get hash of specified old password
            $encryptedPassword = sha1($value);

            // check password
            if ($encryptedPassword != $passwordDb['user_password']) {
                $valid = false;
                $this->_error(self::INVALID);
            }
        } else {
            $valid = false;
        }
        return $valid;
    }
}