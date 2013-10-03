<?php

class Zend_View_Helper_Desc extends Zend_View_Helper_Abstract
{

    /**
     * Direct - return self
     *
     * @return Zend_View_Helper_User
     */
    public function desc()
    {
        return $this;
    }

    public function getPicture($type, $id = null, $picture = null)
    {    	
        if ($id === null) {
            $id = 0;
            $picture = '';
        }
        $picType = $type;

        $fileName = '/uploads/desc/' . $id . $picType . $picture . '.jpg';

        switch ($type) {
            case 'v':
                if (empty($picture)) {
                    return "<img class='avatar avatar-small desc-avatar' src='/themes/new/images/no-avatar_small.png' "
                             . 'width="64" height="64" alt="" />';
                } else {
                    return "<img class='avatar avatar-small desc-avatar' src='{$fileName}' alt='' width='64' height='64' />";
                }
                break;
			case 'm':
	            if (empty($picture)) {
	                return "<img class='avatar avatar-small desc-avatar' src='/themes/new/images/no-avatar_small.png' "
	                         . 'width="48" height="48" alt="" />';
	            } else {
	            	return "<img class='avatar avatar-small desc-avatar' src='{$fileName}' alt='' width='48' height='48' />";
	            }
	            break;
            case 's':
        		if (empty($picture)) {
                    return "<img class='avatar avatar-small desc-avatar' src='/themes/new/images/no-avatar_small.png' "
                             . 'width="32" height="32" alt="" />';
                } else {
                    return "<img class='avatar avatar-small desc-avatar' src='{$fileName}' alt='' width='32' height='32' />";
                }
            	break;
        }
    }
    
    public function descMenu($active, $desc_id)
    {
    	if (Zend_Auth::getInstance()->hasIdentity()){
    		Zend_Auth::getInstance()->getIdentity();
    	}
    }
    
}
