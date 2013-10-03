<?php

class Model_DbTable_User extends Zend_Db_Table
{
    protected $_name    = 'User';
    protected $_primary = 'id';

    public function getUserById($uid)
    {
        $uid = (int) $uid;
        $user = $this->find($uid)->current();

        return (null !== $user) ? $user->toArray(): null;
    }
    
    static public function getUserByIdStatic($uid)
    {
    	$table = new Model_DbTable_User();
        $uid = (int) $uid;
        $user = $table->find($uid)->current();

        return (null !== $user) ? $user->toArray(): null;
    }  
    
    static public function checkEmail($email)
    {
    	$table = new Model_DbTable_User();
        $user = $table->fetchRow(array('EMAIL_ADDRESS = ?' => $email));

        return (null !== $user) ? 'true' : null;
    }  
    public function checkUpdateEmail($email,$id)
        {
            $table = new Model_DbTable_User();
            $select='Select * from User 
                Where EMAIL_ADDRESS="'.$email.'" and ID!="'.$id.'"';
        //$user = $table->fetchRow(array('EMAIL_ADDRESS = ?' => $email,'ID != ?' => $id));
        $user = $this->_db->fetchRow($select);

        return (null !== $user) ? true : false;
            
        }  

    public function getUserByEmail($value)
    {
		// Midified by MiconJ 8/8/2012
        /*$select = $this->_db->select()
                ->from('User')
                ->joinLeft(
                    'Account',
                    'Account.ID = User.ACCOUNT_ID',
                    array('Account.MALL_ID', 'Account.REAL_ESTATE_ID','Account.AGENT_USER_ID')
                    )
                ->joinLeft('Mall',
                            'Mall.ID = Account.MALL_ID',
                            array('Mall.MALLNAME')
                            )
                 ->joinLeft('Real_Estate',
                            'Real_Estate.ID = Account.REAL_ESTATE_ID ',
                            array('Real_Estate.O_COMPANY')
                            )

                ->where('EMAIL_ADDRESS = ?', $value);
			*/
		$select = $this->_db->select()
			->from('User')
			->joinLeft(
				'Account',
				'Account.ID = User.ACCOUNT_ID',
				array('Account.TARGET_ID','Account.AGENT_USER_ID','Account.ACCOUNT_TYPE')
				)
			->joinLeft('Mall',
						'Mall.ID = Account.TARGET_ID',
						array('Mall.MALLNAME')
						)
			 ->joinLeft('Real_Estate',
						'Real_Estate.ID = Account.TARGET_ID ',
						array('Real_Estate.O_COMPANY')
						)

			->where('EMAIL_ADDRESS = ?', $value);
        return  $this->_db->fetchRow($select);
    }
    
	public function updateUser($data, $userId)
    {
    	return $this->update($data, "ID = '{$userId}'");
    }
    

    public function updatePassword($userId, $password)
    {
        $userId = (int) $userId;

        return $this->update(array('PASSWORD' => hash('sha512', $password), "ID = {$userId}"));
    }

    public function updateEmail($userId, $email)
    {
        $userId = (int) $userId;
        return $this->update(array('EMAIL_ADDRESS' => $email), "ID = {$userId}");
    }


    public function deleteUserById($user_id,$session_id)
    {
        $utility_model= new Model_utility(); 
        try{
          $query = "SELECT A.AGENT_USER_ID, U.ID FROM Account A, User U, LoginSession S WHERE U.ACCOUNT_ID = A.ID AND U.ID = S.USER_ID AND S.ID = '" . $session_id . "'";
    $row = $this->_db->fetchRow($query);
     
    if ($row) {
        $uid = $row["ID"];
        $agent_user_id = $row["AGENT_USER_ID"];
        
        if (!isEmpty($agent_user_id) && $agent_user_id == $user_id && $agent_user_id != $uid) {
            echo "Access denied";
            return;
        }
    }    
    
    $query = "SELECT * FROM Account WHERE AGENT_USER_ID = '" . $user_id . "'";
    $row = $this->_db->fetchRow($query);
    
    if ($row) {
        $account_id = $row["ID"];
        
        $query = "SELECT * FROM User WHERE ACCOUNT_ID = '" . $account_id . "' AND ID <> '" . $user_id . "'";    
        $row = $this->_db->fetchRow($query);
        
       
    
        if ($row) {
            $query = "UPDATE Account SET AGENT_USER_ID = " . $utility_model->forSQL($row["ID"]) . " WHERE ID = " . $utility_model->forSQL($account_id);
        }
        else {
            $query = "UPDATE Account SET AGENT_USER_ID = NULL WHERE ID = " . $utility_model->forSQL($account_id);
        }
    
        $result = $this->_db->query($query);
        
       
    }

    $query = "DELETE FROM LoginSession WHERE USER_ID = '" . $user_id . "'";
    $result = $this->_db->query($query);
        
    
    $query = "DELETE FROM Activity WHERE REQUESTED_BY = '" . $user_id . "' OR APPROVED_BY = '" . $user_id . "' OR NEW_AGENT_ID = '" . $user_id . "'";
    $result = $this->_db->query($query);
        
   
    $query = "DELETE FROM User WHERE ID = '" . $user_id . "'";
    $result = $this->_db->query($query); 
     return "Successfully Deleted"; 
        }catch(Exception $e)
            {
                return $e->getMessage();
            }
        
        
        
   
    }


    public function getAllUsers($pagination = false)
    {
        $select = $this->_db->select()
                       ->from('user');
        if ($pagination) {
            return $select;
        } else {
            return $this->_db->fetchAll($select);
        }
    }
    
    static public function selectUsers($rop = 0, $page = 0, $condition = '', $order)
    {
    	$table = new Model_DbTable_User();
    	$sel = $table->_db->select();
    	$sel->from($table->_name);
    	if ($condition)
    		$sel->where($condition);
    	$sel->order($order);
    	if (($rop != 0) && ($page != 0)) {
    		$offset = ($page - 1) * $rop;
    		$sel->limit($rop, $offset);
    		return $table->_db->fetchAll($sel);
    	} else return count($table->_db->fetchAll($sel));
    }
    
    static public function selectAllUsers($condition = '', $order='')
    {
    	$table = new Model_DbTable_User();
    	$sel = $table->_db->select();
    	$sel->from($table->_name);
    	if ($condition)
    		$sel->where($condition);
    	if ($order)
    		$sel->order($order);
   		return $table->_db->fetchAll($sel);
    }
    
    static public function updateUserStatic($user)
    {
    	$table = new Model_DbTable_User();
    	return $table->update($user, 'ID = '.$user['user_id']);
    }
    
    static public function deleteUserStatic($userid)
    {
    	$table = new Model_DbTable_User();
    	return $table->delete('ID = '.$userid);
    }
    
	public function updateData($data, $uid)
    {    	
    	return $this->update($data,"ID = {$uid}");    
    }
    public function updateLastLogin($user_id){
         $db=$this->getAdapter();
        $query = "DELETE FROM LoginSession WHERE USER_ID = '" . $user_id . "'";
     
        $db->query($query);
        
        $query = "SELECT UUID() as session";
        $row=$db->fetchRow($query);
     
        $utility= new Model_utility();
        
        $session_id = $row['session'];        
        
        $query = "INSERT INTO LoginSession(ID, USER_ID) VALUES(";
        $query = $query . $utility->forSQL($session_id) . ", " . $utility->forSQL($user_id) . ")";
    
        $result = $db->query($query);
        
    }
    public function getUser($con = 0, $is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null/*$limit = 25, $offset = 0,$is_count=0,$con=''*/)
	{
		$user = Zend_Auth::getInstance()->getIdentity();   
		$this->user_id=$user['ACCOUNT_ID'];  
		$utility_model= new Model_utility(); 

		$limit_con=($limit>0)?"LIMIT $offset, $limit":'';
		$order_con = "";
			if(!is_null($sort) && $sort["field"] != "" ){$order_con = "ORDER BY ".$sort["field"]." ".$sort["mode"];}
		$where = "";
			if(!is_null($filter) && $filter["value"] !== "")  { $where .= " AND (U.FIRST_NAME like '%".$filter["value"]."%' or U.LAST_NAME like '%".$filter["value"]."%')" ;}
		
		$extra='';
		//Modified By MiconJ 8/8/2012
		//         if(!$utility_model->isEmpty($user['MALL_ID'])){
		if($user['ACCOUNT_TYPE'] == '2'){ // If user is mall
			$extra .= " AND A.ID ='".$user['ACCOUNT_ID']."'";
		}
		//Modified By MiconJ 8/8/2012
		//         else if (!$utility_model->isEmpty($user['REAL_ESTATE_ID'])) {			 
		//$extra = $extra . " AND (A.REAL_ESTATE_ID = '" . $user['REAL_ESTATE_ID'] . "' OR M.REAL_ESTATE_ID = '" . $user['REAL_ESTATE_ID'] . "')";
		else if ($user['ACCOUNT_TYPE'] == '1') { // If user is real_estate
			$extra .= " AND (A.TARGET_ID = '" . $user['TARGET_ID'] . "' OR M.REAL_ESTATE_ID = '" . $user['TARGET_ID'] . "')";
		}
		
		switch ($con) {
			case 1: // Pending
				$extra = $extra . " AND U.STATUS = 0";
				break;
			case 2: // mall rat
				$extra = $extra . " AND A.TARGET_ID IS NULL";
				break;
		}

		if($is_count==1){
			//Modified By MiconJ 8/8/2012
			/*$select = "SELECT DISTINCT COUNT(*) AS TOTAL FROM User U 
			LEFT JOIN LoginSession S ON U.ID = S.USER_ID,Account A LEFT JOIN Mall M ON A.MALL_ID = M.ID WHERE U.ACCOUNT_ID = A.ID
			$extra      
			";*/
			$select = "SELECT COUNT(*) AS TOTAL
			FROM User U 
			INNER JOIN Account A ON A.ID = U.ACCOUNT_ID
			LEFT JOIN Mall M ON A.TARGET_ID = M.ID 
			WHERE 1=1
			$where
			$extra      
			";
		}else{
			//Modified By MiconJ 8/8/2012
			/*$select = "SELECT U.*, M.MALLNAME, A.REAL_ESTATE_ID,R.O_COMPANY, DATE_FORMAT(S.UPDATED_ON, '%m/%d/%Y %h:%i%p') AS UPDATED_ON FROM User U 
			LEFT JOIN LoginSession S ON U.ID = S.USER_ID,Account A 
			LEFT JOIN Real_Estate R ON R.ID=A.REAL_ESTATE_ID
			LEFT JOIN Mall M ON A.MALL_ID = M.ID 
			WHERE U.ACCOUNT_ID = A.ID 
			$extra        
			$limit_con";*/
			$select = 
			"SELECT U.*, M.MALLNAME, A.TARGET_ID, A.ACCOUNT_NAME, A.ACCOUNT_TYPE, IFNULL(DATE_FORMAT(S.UPDATED_ON, '%m/%d/%Y %h:%i%p'),'-') AS UPDATED_ON 
			FROM User U 
			INNER JOIN Account A ON U.ACCOUNT_ID = A.ID 
			LEFT JOIN LoginSession S ON U.ID = S.USER_ID 
			LEFT JOIN Mall M ON A.TARGET_ID = M.ID 
			WHERE 1=1
			$where
			$extra
			$order_con
			$limit_con";
		}
		$result=  $this->_db->fetchAll($select);
		if($is_count==1) return $result[0]['TOTAL'];
		else return $result;  
	}
	public function getRealestate($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null) {
		$limit_con = ($limit>0) ? "LIMIT $offset, $limit":'';
		$order_con = "";
			if(!is_null($sort) && $sort["field"] != "" ){$order_con = "ORDER BY ".$sort["field"]." ".$sort["mode"];}
		$where = "";
			if(!is_null($filter) && $filter["value"] !== "")  { $where .= " and (u.FIRST_NAME like '%".$filter["value"]."%' or u.LAST_NAME like '%".$filter["value"]."%')" ;}
		
		if($is_count == 1) {
			$query = "SELECT count(*) as TOTAL
				FROM User u
				INNER JOIN Account a ON u.ACCOUNT_ID = a.ID and a.ACCOUNT_TYPE='1'
				WHERE 1=1 
				$where
				$order_con";
			
		} else {
			$query = "SELECT u.ID, u.EMAIL_ADDRESS, u.FIRST_NAME, u.LAST_NAME, u.STATUS, a.ACCOUNT_TYPE, a.ACCOUNT_NAME, IFNULL(DATE_FORMAT(S.UPDATED_ON, '%m/%d/%Y %h:%i%p'),'-') AS UPDATED_ON
				FROM User u
				INNER JOIN Account a ON u.ACCOUNT_ID = a.ID and a.ACCOUNT_TYPE='1' $where
				LEFT JOIN LoginSession S ON u.ID = S.USER_ID
				$order_con
				$limit_con";
		}
		$result = $this->_db->fetchAll($query);
		if($is_count==1) return $result[0]['TOTAL'];
		else return $result;
	}
	public function getMall($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null) {
		$limit_con = ($limit>0) ? "LIMIT $offset, $limit":'';
		$order_con = "";
			if(!is_null($sort) && $sort["field"] != "" ){$order_con = "ORDER BY ".$sort["field"]." ".$sort["mode"];}
		$where = "";
			if(!is_null($filter) && $filter["value"] !== "")  { $where .= " and (u.FIRST_NAME like '%".$filter["value"]."%' or u.LAST_NAME like '%".$filter["value"]."%')" ;}
		
		if($is_count == 1) {
			$query = "SELECT count(*) as TOTAL
				FROM User u
				INNER JOIN Account a ON u.ACCOUNT_ID = a.ID and a.ACCOUNT_TYPE='2'
				WHERE 1=1
				$where
				$order_con";
		} else {
			$query = "SELECT u.ID, u.EMAIL_ADDRESS, u.FIRST_NAME, u.LAST_NAME, u.STATUS, a.ACCOUNT_TYPE, a.ACCOUNT_NAME, IFNULL(DATE_FORMAT(S.UPDATED_ON, '%m/%d/%Y %h:%i%p'),'-') AS UPDATED_ON
				FROM User u
				INNER JOIN Account a ON u.ACCOUNT_ID = a.ID and a.ACCOUNT_TYPE='2' 
				LEFT JOIN LoginSession S ON u.ID = S.USER_ID
				WHERE 1=1
				$where
				$order_con
				$limit_con";
		}
		$result = $this->_db->fetchAll($query);
		if($is_count==1) return $result[0]['TOTAL'];
		else return $result;
	}
	public function getVendor($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null) {
		$limit_con = ($limit>0) ? "LIMIT $offset, $limit":'';
		$order_con = "";
			if(!is_null($sort) && $sort["field"] != "" ){$order_con = "ORDER BY ".$sort["field"]." ".$sort["mode"];}
		$where = "";
			if(!is_null($filter) && $filter["value"] !== "")  { $where .= " and (u.FIRST_NAME like '%".$filter["value"]."%' or u.LAST_NAME like '%".$filter["value"]."%')" ;}
		
		if($is_count == 1) {
			$query = "SELECT count(*) as TOTAL
				FROM User u
				INNER JOIN Account a ON u.ACCOUNT_ID = a.ID and a.ACCOUNT_TYPE='3'
				WHERE 1=1 
				$where
				$order_con";
				
		} else {
			$query = "SELECT u.ID, u.EMAIL_ADDRESS, u.FIRST_NAME, u.LAST_NAME, u.STATUS, a.ACCOUNT_TYPE, a.ACCOUNT_NAME, IFNULL(DATE_FORMAT(S.UPDATED_ON, '%m/%d/%Y %h:%i%p'),'-') AS UPDATED_ON
				FROM User u
				INNER JOIN Account a ON u.ACCOUNT_ID = a.ID and a.ACCOUNT_TYPE='3'
				LEFT JOIN LoginSession S ON u.ID = S.USER_ID
				WHERE 1=1 
				$where
				$order_con
				$limit_con";
		}
		$result = $this->_db->fetchAll($query);
		if($is_count==1) return $result[0]['TOTAL'];
		else return $result;
	}
	public function getStore($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null) {
		$limit_con = ($limit>0) ? "LIMIT $offset, $limit":'';
		$order_con = "";
			if(!is_null($sort) && $sort["field"] != "" ){$order_con = "ORDER BY ".$sort["field"]." ".$sort["mode"];}
		$where = "";
			if(!is_null($filter) && $filter["value"] !== "")  { $where .= " and (u.FIRST_NAME like '%".$filter["value"]."%' or u.LAST_NAME like '%".$filter["value"]."%')" ;}
		
		if($is_count == 1) {
			$query = "SELECT count(*) as TOTAL
				FROM User u
				INNER JOIN Account a ON u.ACCOUNT_ID = a.ID and a.ACCOUNT_TYPE='4' 
				WHERE 1=1
				$where 
				$order_con";
				
		} else {
			$query = "SELECT u.ID, u.EMAIL_ADDRESS, u.FIRST_NAME, u.LAST_NAME, u.STATUS, a.ACCOUNT_TYPE, a.ACCOUNT_NAME, IFNULL(DATE_FORMAT(S.UPDATED_ON, '%m/%d/%Y %h:%i%p'),'-') AS UPDATED_ON
				FROM User u
				INNER JOIN Account a ON u.ACCOUNT_ID = a.ID and a.ACCOUNT_TYPE='4'
				LEFT JOIN LoginSession S ON u.ID = S.USER_ID
				WHERE 1=1
				$where
				$order_con
				$limit_con";
		}
		$result = $this->_db->fetchAll($query);
		if($is_count==1) return $result[0]['TOTAL'];
		else return $result;
	}

    public function countAll()
	{
		$data['all'] = $this->getUser(0,1);
        $data['pending'] = $this->getUser(1,1);
        $data['mallrat'] = $this->getUser(2,1);
		
        //$account_model=new Model_DbTable_Account();
        $data['realstate'] =$this->getRealestate(1);
        $data['mall'] = $this->getMall(1);
        $data['vendor'] = $this->getVendor(1);
        $data['store'] = $this->getStore(1);
        return $data;   
        }
    private function getUID()
    {
     $query = "SELECT UUID() as UID";
        $result =$this->_db->fetchRow($query);
        
        return $result['UID'];     
    }
    public function getTeammemberList($accountid)
        {
          $select="select * from Account  A
            inner join User U on A.AGENT_USER_ID=U.ID
            where A.ID='".$accountid."'";
           
           return $this->_db->fetchAll($select);        
        }
    public function getTeam($user_id)
        {
         
            $query = "SELECT A.AGENT_USER_ID, U2.ID, CONCAT(U2.FIRST_NAME, ' ', U2.LAST_NAME) AS NAME FROM Account A, User U1, User U2 WHERE U1.ACCOUNT_ID = U2.ACCOUNT_ID AND A.ID = U2.ACCOUNT_ID AND U1.ID = '" . $user_id . "' ORDER BY NAME";
                                        
           return $this->_db->fetchAll($query);        
       
        }
	private function getAccountID($name) {
		try{
			if($name === "Mall Rat") {
				$query = "SELECT ID FROM Account WHERE TARGET_ID is null";
				$result = $this->_db->fetchAll($query);
			} else {
				$query = "SELECT ID FROM Account WHERE ACCOUNT_NAME='$name'";
				$result = $this->_db->fetchAll($query);
			}		
			if(count($result) > 0) {
				return $result[0]["ID"];
			}
		}catch(Exception $e) {
			return null;
		}
	}
	private function getAutomaticHashKey() {
		$password = "";
		$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
		$maxlength = strlen($possible);
		$i = 0; 
		$length = (int)mt_rand(9, 15);
		while ($i < $length) { 
			$char = substr($possible, mt_rand(0, $maxlength - 1), 1);
			if (!strstr($password, $char)) { 
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}
	public function addNewUser($user_data)
	{
		$user = Zend_Auth::getInstance()->getIdentity();    
		$utility=new Model_utility();
		$user_id = $this->getUID();
		$DB = $this->_db;

		$account_id = $this->getAccountID($user_data['user_event_name']);
		if(is_null($account_id)) {
			return 'You typed undefined account name.';
		}
		$password = $this->getAutomaticHashKey();
		$hashkey = hash("sha512", $password);
		try {
			$query = "INSERT INTO User(ID, ACCOUNT_ID, EMAIL_ADDRESS, FIRST_NAME, LAST_NAME, PASSWORD, STATUS) "
					. " VALUES (" . $DB->quote($user_id) . ", " . $DB->quote($account_id) . ", " . $DB->quote($user_data['user_email']) . ", "
					. $DB->quote($user_data['user_first_name']) . ", " . $DB->quote($user_data['user_last_name']) . ", ".$DB->quote($hashkey).", 0)";
			$result = $this->_db->query($query);

			$query = "UPDATE Account SET AGENT_USER_ID = ".$DB->quote($user_id).", STATUS='1' WHERE ID = ".$DB->quote($account_id);
			$result = $this->_db->query($query);
		} catch (Zend_Db_Exception $e) {
			return $e->getMessage();
		}
		try{
			$url = 'http://dev.mallrat.ca/common/verify?email='.$user_data['user_email'].'&hash='.$hashkey;
			$message  = '<html><body><font size="4" face="Verdana">Thanks for signing up!<br />'
			.'Your account has been created, you can login with the following '
			.'credentials after you have activated your account by pressing the url below.<br />';
			$message .= ' ------------------------  <br />';
			$message .= ' user name : '.$user_data['user_email'].'<br />';
			$message .= ' password  : '.$password.'<br />';
			$message .= ' ------------------------  <br />';
			$message .= ' Please click this link to activate your account: <br />';
			$message .= '<a href="'.$url.'">'.$url.'</a></font></body></html>';
			$username = $user_data['user_first_name']." ".$user_data['user_last_name'];
			
			$mail = new Zend_Mail("utf-8");
			$mail->setBodyHtml($message);
			$mail->setFrom('no-reply@mallrat.ca', 'Mall Rat');
			$mail->addTo($user_data['user_email'], $username);
			$mail->setSubject("Mall Rat User Verification");
			$mail->send();
			return "Successfully registered.";
		} catch(Zend_Mail_Exception $e) {
			return "Did not send activation mail to the user.";
		}
		
		/*if ($reset_password == "1") {
			$query = "UPDATE User SET PASSWORD = " . $utility->forSQL(hash("sha512", $password)) . " WHERE ID = " . $utility->forSQL($user_id);
			$result = $this->_db->query($query);
			$crlf = "\n";
			$hdrs = array (
				'From'    =>    'no-reply@synergymedia.com',
				'Subject' => 'The password is reset for your account.'
			);
			
			$message  = '<html><body><font size="4" face="Verdana"><img src="./images/email_header.png"><br><br>The password for your account has been reset.';
			$message .= ' Your new password is: <b>' . $password . '</b>';
			$message .= '<br><br>Thank you,<br>The Mall Rat Team</font></body></html>';
			
		}

		$utility->outputXMLHeader();

		echo "<Response>\n";
		echo "\t<UserID>" . htmlentities($user_id) . "</UserID>\n";
		echo "</Response>\n";*/
	}
	public function sendActivationMail($param)
	{
		$user = Zend_Auth::getInstance()->getIdentity();
		$DB = $this->_db;
		$password = $this->getAutomaticHashKey();
		$hashkey = hash("sha512", $password);
		try {
			$query = "SELECT * FROM User WHERE ID=".$DB->quote($param['user_id']);
			$user_data = $this->_db->fetchAll($query);
			if(count($user_data) < 1) {
				return "Could not found this user.";
			}
			$query = "UPDATE User SET PASSWORD = ".$DB->quote($hashkey)." WHERE ID = ".$DB->quote($param['user_id']);
			$result = $this->_db->query($query);
			$affectedRows = $result->rowCount();
			if($affectedRows < 1) {
				return "Could not update the database.";
			}
		} catch (Zend_Db_Exception $e) {
			return $e->getMessage();
		}
		try{
			$url = 'http://dev.mallrat.ca/common/verify?email='.$user_data[0]['EMAIL_ADDRESS'].'&hash='.$hashkey;
			$message  = '<html><body><font size="4" face="Verdana">Thanks for signing up!<br />'
			.'Your account has been created, you can login with the following '
			.'credentials after you have activated your account by pressing the url below.<br />';
			$message .= ' ------------------------  <br />';
			$message .= ' user name : '.$user_data[0]['EMAIL_ADDRESS'].'<br />';
			$message .= ' password  : '.$password.'<br />';
			$message .= ' ------------------------  <br />';
			$message .= ' Please click this link to activate your account: <br />';
			$message .= '<a href="'.$url.'">'.$url.'</a></font></body></html>';
			$username = $user_data[0]['FIRST_NAME']." ".$user_data[0]['LAST_NAME'];
			
			$mail = new Zend_Mail("utf-8");
			$mail->setBodyHtml($message);
			$mail->setFrom('no-reply@synergymedia.com', 'Mall Rat');
			$mail->addTo('miconj96@gmail.com', 'dsafdsaf');//$user_data[0]['EMAIL_ADDRESS']
			$mail->setSubject("Mall Rat User Verification");
			$mail->send();
			return "The activation mail was sent successfully.".$user_data[0]['EMAIL_ADDRESS'];
		} catch(Zend_Mail_Exception $e) {
			return "Did not send activation mail to the user.";
		}
	}
}
