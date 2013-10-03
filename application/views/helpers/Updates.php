<?php

class Zend_View_Helper_Updates extends Zend_View_Helper_Abstract
{
	
	public function updates()
    {
        return $this;
    }
	
	public function checkMessages($user_id)
	{
		$modelMessages = new Model_DbTable_Messages();
		$messages = $modelMessages->getUnread($user_id);
		if (count($messages)){
			return count($messages);
		}else{
			return false;
		}
	}
}