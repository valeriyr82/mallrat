<?php

class Zend_View_Helper_User extends Zend_View_Helper_Abstract
{
    /**
     * @var array
     */
    protected $_user = null;

    /**
     * Direct - return self
     *
     * @return Zend_View_Helper_User
     */
    public function user()
    {
        return $this;
    }

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->_user = $auth->getIdentity();
        } else {
            $this->_user = array(
            	'user_role'  => 'guest',
				'user_id'    => 0,
            );
        }
    }

    /**
     * Updates the information about user
     *
     * @return void
     */
    public function update()
    {
   		$auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->_user = $auth->getIdentity();
        } else {
            $this->_user = array(
            	'user_role'  => 'guest',
				'user_id'    => 0,
            );
        }
    }
    
    /**
     * Get user name
     *
     * @return string
     */
    public function getUsername()
    {
    	if (($this->_user['user_username'] == '') || (empty($this->_user['user_username']))){
    		$part = explode("@", $this->_user['user_email']);
    		return (string) $part[0];
    	}else{
        	return (string) $this->_user['user_username'];
    	}
    }

    /**
     * Get user email
     *
     * @return string
     */
    public function getEmail()
    {
        return (string) $this->_user['user_email'];
    }

    /**
     * Get user id
     *
     * @return string
     */
    public function getId()
    {
        return (isset($this->_user['user_id'])) ? (int) $this->_user['user_id'] : null;
    }

    /**
     * Get user role
     *
     * @return string
     */
    public function getRole()
    {
        return (isset($this->_user['user_role'])) ? $this->_user['user_role'] : 'guest';
    }

	/**
     * Get user role for desc
     *
     * @return string
     */
    public function getDescRole($desc_id)
    {
    	$modelAssign = new Model_DbTable_Assign();
    	$role = $modelAssign->getUserRole($desc_id, $this->_user['user_id']);
        return (!empty($role)) ? $role['asgn_role'] : 'guest';
    }
    
    /**
     * Check user is guest
     *
     * @return bool
     */
    public function isLoggedIn()
    {
        return ($this->_user['user_role'] === 'guest') ? false : true;
    }
    
    public function getPicture($type, $id = null, $picture = null)
    {
        if ($id === null) {
            if ($this->isLoggedIn()) {
                $id = $this->_user['user_id'];
                $picture = $this->_user['user_avatar'];
            } else {
                $id = 0;
                $picture = '';
            }
        }

        $fileName = '/uploads/user/avatar/' . $id . $type . $picture . '.jpg';

        switch ($type) {
            case 'v':
                if (strpos($picture, 'http://') !== false) {
                    return "<img class='avatar avatar-small desc-avatar' src='{$picture}' alt='' width='64' height='64' />";
                } elseif ((empty($picture)) || ($picture == ' ') || ($picture == '')) {
                    return "<img class='avatar avatar-small desc-avatar' src='/themes/new/images/no-avatar_small.png' "
                             . 'width="64" height="64" alt="" />';
                } else {
                    return "<img class='avatar avatar-small desc-avatar' src='{$fileName}' alt='' width='64' height='64' />";
                }
                break;
			case 's':
                if (strpos($picture, 'http://') !== false) {
                    return "<img class='avatar avatar-small desc-avatar' src='{$picture}' alt='' width='32' height='32' />";
                } elseif ((empty($picture)) || ($picture == ' ') || ($picture == '')) {
                    return "<img class='avatar avatar-small' src='/themes/new/images/no-avatar_small.png' "
                             . 'width="32" height="32" alt="" />';
                } else {
                    return "<img class='avatar avatar-small desc-avatar' src='{$fileName}' alt='' width='32' height='32' />";
                }
                break;
            default:
                return '';
        }
    }
}
