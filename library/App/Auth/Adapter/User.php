<?php

class App_Auth_Adapter_User implements Zend_Auth_Adapter_Interface
{
    /**
     * User identity
     * @var string
     */
    protected $_identity = null;

    /**
     * User email
     * @var string
     */
    protected $_email = null;
    
    /**
     * User password
     * @var string
     */
    protected $_password = null;

    /**
     * Authenticate persistent
     * @var bool
     */
    protected $_persistent = false;
    protected $_identityOnly = false;

    /**
     * @var Model_DbTable_User
     */
    protected $_model;

    protected $_backend = false;
    /**
     * __construct
     *
     * @param string $identity
     * @param string $password
     */
    public function __construct($email = null, $password = null)
    {
		$this->_model = new Model_DbTable_User();
        $this->_identity = $email;
        $this->_password = $password;
    }

    public function setAuthPersistent($flag = true)
    {
        $this->_persistent = (bool) $flag;
    }

    public function setAuthByIdentity($flag = true)
    {
        $this->_identityOnly = (bool) $flag;
    }

    public function loginFromBackend()
    {
    	$this->_backend = true;
    }
    /**
     * Check if user store their authorization
     *
     * @return Zend_Auth_Result
     */
    protected function _checkPersistent()
    {
        if (!empty($_COOKIE['AUTH_ID']) && !empty($_COOKIE['AUTH_HASH'])) {
            $authId   = (int) $_COOKIE['AUTH_ID'];
            $authHash = substr($_COOKIE['AUTH_HASH'], 0, 40);

            // get user by auth id
            $user = $this->_model->getUserById($authId);

            // check authorization hash
            if ($user !== null) {
                $checkHash = hash('sha512', $user['PASSWORD'] /*$user['user_time_logged'] .*/ /*$_SERVER['HTTP_USER_AGENT']*/);
                if ($authHash === $checkHash) {
                    $this->_identity = $user['id'];
                    $this->_persistent = true;
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Authenticate user as guest account
     *
     * @return Zend_Auth_Result
     */
    protected function _authenticateGuest()
    {
        $user = array(
            'user_username' => 'guest',
            //'user_status'   => 'active',
            'user_role'     => 'guest'
        );

        // check have account
        $user['user_have_account'] = (isset($_COOKIE['LAST_LOGIN'])) ? true : false;

        return new Zend_Auth_Result(
            Zend_Auth_Result::SUCCESS,
            $user,
            array('authLoginGuest')
        );
    }

    /**
     * Authenticate user by it id
     *
     * @return Zend_Auth_Result
     */
    protected function _authenticateById()
    {
    	/*echo "vedvvwe<br>";
    	echo $this->_identity; die;*/
        // check useremail
        try {
            $user = $this->_model->getUserByEmail($this->_identity);
        }
        catch (Exception $e) {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_UNCATEGORIZED,
                       $this->_identity,
                       array('authFailureDb')
                   );
        }
        
        // user not found
        if ($user === null) {
            return new Zend_Auth_Result(
                Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND,
                $this->_identity,
                array('authFailureUsername')
            );
        }

        return $this->login($user);
    }

    /**
     * Register user identity
     *
     * @return void
     */
    public function login($user)
    {
        // persistent authorization
        if ($this->_persistent) {
            $hash = hash('sha512', $user['PASSWORD']);
            setcookie(
                'AUTH_ID', $user['user_id'],
                time() + (60 * 60 * 24 * 365), '/', '', false, true
            );
            setcookie(
                'AUTH_HASH', $hash,
                time() + (60 * 60 * 24 * 365), '/', '', false, true
            );
        }

        return new Zend_Auth_Result(
            Zend_Auth_Result::SUCCESS, $user, array('authLoginSuccess')
        );
    }

    /**
     * Destroy user identity
     *
     * @return void
     */
    public function logout()
    {
        setcookie('AUTH_ID', '', time() - (60 * 60 * 24 * 365), '/', '', false, true);
        setcookie('AUTH_HASH', '', time() - (60 * 60 * 24 * 365), '/', '', false, true);
        Zend_Auth::getInstance()->clearIdentity();
    }

    /**
     * Authenticate user
     *
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        // auto authenticate through plugin_access
        if ($this->_identity === null &&
            $this->_password === null &&
            $this->_checkPersistent()) {
                return $this->_authenticateById();
        }
        // check useremail
        try {
            $user = $this->_model->getUserByEmail($this->_identity);
        }
        catch (Exception $e) {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_UNCATEGORIZED,
                       $this->_identity,
                       array('authFailureDb')
                   );
        }
        // user not found
        if ($user === null) {
            return new Zend_Auth_Result(
                Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND,
                $this->_identity,
                array('authFailureUsername')
            );

        }
		
        // incorrect password
        if ($this->_password !== $user['PASSWORD']) {
            return new Zend_Auth_Result(
                Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
                $this->_identity,
                array('authFailurePassword')
            );
        }
    
        
        return $this->login($user);
    }
}
