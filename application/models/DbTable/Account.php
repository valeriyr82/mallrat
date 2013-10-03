<?php

class Model_DbTable_Account extends Zend_Db_Table
{
    protected $_name    = 'Account';
    protected $_primary = 'ID';
    private $user_id ='';
    
    public function getAccountInfoById($accountId)
        {
          $select = $this->_db->select()
           ->where("ID='".$accountId."'");
        return  $this->_db->fetchRow($select);    
        }
    public function deleteAccountById($accountId)
        {
            if($this->_db->delete($this->_name,array('ID=?'=>$accountId)))
                return true;
            else
                return false;
        }
    public function deleteRealstateById($realstateId)
        {
            if($this->_db->delete('Real_Estate',array('ID=?'=>$realstateId)))
                return true;
            else
                return false;
        }
    public function deleteMallById($realstateId)
        {
            if($this->_db->delete('Mall',array('ID=?'=>$realstateId)))
                return true;
            else
                return false;
        }
    public function deleteStoreById($realstateId)
        {
            if($this->_db->delete('Store',array('ID=?'=>$realstateId)))
                return true;
            else
                return false;
        }
     public function deleteVendorById($realstateId)
        {
            if($this->_db->delete('Vendor',array('ID=?'=>$realstateId)))
                return true;
            else
                return false;
        }
    public function getAll($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null)
    {   
        $user = Zend_Auth::getInstance()->getIdentity();   
        $this->user_id=$user['ACCOUNT_ID']; 
        
    	 $limit_con=($limit>0)?"LIMIT $offset, $limit":''; 
         $order_con = "";
			if(!is_null($sort) && $sort["field"] != "" ){$order_con = "ORDER BY ".$sort["field"]." ".$sort["mode"];}
         
         $utility=new Model_utility();
         $where=($utility->isAdmin())?'':" and a.ID='".$this->user_id."'";
			if(!is_null($filter) && $filter["value"] !== "") {$where .= " and a.ACCOUNT_NAME like '%".$filter["value"]."%')";}
		 
         if($is_count==1){
			$select = " SELECT COUNT(*) as total
					FROM Account a
					WHERE a.ACCOUNT_TYPE!='0' $where";
         }else{
           $select =
			   "SELECT a.ID,a.TARGET_ID,a.AGENT_USER_ID,a.STATUS,IFNULL(s.UPDATED_ON,'-') as UPDATED_ON
                    , CASE a.ACCOUNT_TYPE WHEN '0' THEN 'Mall Rat'
						WHEN '1' THEN 'Real Estate'
						WHEN '2' THEN 'Mall'
						WHEN '3' THEN 'Vendor'
						WHEN '4' THEN 'Store'
						ELSE 'Unknown' END as ACCOUNTTYPE
					, a.ACCOUNT_NAME as ACCOUNTNAME 
				FROM Account a
				LEFT JOIN (
					SELECT MAX(UPDATED_ON) as UPDATED_ON, uu.ACCOUNT_ID ACCOUNT_ID
					FROM LoginSession ss
					LEFT JOIN User uu on ss.USER_ID = uu.ID
					GROUP BY uu.ACCOUNT_ID
				  ) s ON
				  s.ACCOUNT_ID=a.ID
				WHERE a.ACCOUNT_TYPE!='0' $where 
				$order_con
				$limit_con";
         }
         
    	$result=  $this->_db->fetchAll($select);
        if($is_count==1) return $result[0]['total'];
        else return $result;
    }
    
    public function getActivate($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null)
    {
        $user = Zend_Auth::getInstance()->getIdentity();   
        $this->user_id=$user['ACCOUNT_ID']; 
        
        $limit_con=($limit>0)?"LIMIT $offset, $limit":''; 
        $order_con = "";
        if(!is_null($sort) && $sort["field"] != "" ){$order_con = "ORDER BY ".$sort["field"]." ".$sort["mode"];}
        
        $utility=new Model_utility();
        $where=($utility->isAdmin())?"":"and a.ID='".$this->user_id."'";   
        if(!is_null($filter) && $filter["value"] !== "") {$where .= " and a.ACCOUNT_NAME like '%".$filter["value"]."%')";}
        
        if($is_count == 1) {
			$select = " SELECT COUNT(*) as total
					FROM Account a
					WHERE a.ACCOUNT_TYPE!='0' AND a.STATUS=0 $where";
        } else { 
            $select = " SELECT a.ID,a.TARGET_ID,a.AGENT_USER_ID,a.STATUS,IFNULL(s.UPDATED_ON,'-') as UPDATED_ON
                                , CASE a.ACCOUNT_TYPE WHEN '0' THEN 'Mall Rate'
									WHEN '1' THEN 'Real Estate'
									WHEN '2' THEN 'Mall'
									WHEN '3' THEN 'Vendor'
									WHEN '4' THEN 'Store'
									ELSE 'Unknown' END as ACCOUNTTYPE
								, a.ACCOUNT_NAME as ACCOUNTNAME 
                        FROM Account a   
                        LEFT JOIN (
                            SELECT MAX(UPDATED_ON) as UPDATED_ON, uu.ACCOUNT_ID ACCOUNT_ID
                            FROM LoginSession ss
                            LEFT JOIN User uu on ss.USER_ID = uu.ID
                            GROUP BY uu.ACCOUNT_ID
                          ) s ON
                          s.ACCOUNT_ID=a.ID
                        WHERE a.ACCOUNT_TYPE!='0' AND a.STATUS=0 $where
                        $order_con
                        $limit_con ";
        }
        $result=  $this->_db->fetchAll($select);
        if($is_count==1) return $result[0]['total'];
        else return $result;
    }
    
    public function getPending($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null)//$limit = 15, $offset = 0,$is_count=0)
    {
        /*$user = Zend_Auth::getInstance()->getIdentity();   
        $this->user_id=$user['ACCOUNT_ID']; 
    	  $limit_con=($limit>0)?"LIMIT $offset, $limit":''; 
         $sql_con=($is_count==1)?"COUNT(*) AS TOTAL":" DISTINCT A.ID,A.MALL_ID,A.REAL_ESTATE_ID,A.AGENT_USER_ID,A.STATUS,S.UPDATED_ON,U.EMAIL_ADDRESS,U.FIRST_NAME,U.LAST_NAME,U.JOB_TITLE, IF(a.MALL_ID is null,IF(a.real_estate_id is null, 'None', 'Real Estate'),'Mall') as ACCOUNTTYPE";
         
         $utility=new Model_utility();  
         $where=($utility->isAdmin())?'':"and A.ID='".$this->user_id."'";   
         $select ="select $sql_con from Account A
           LEFT JOIN User U on U.ACCOUNT_ID=A.ID   
          LEFT JOIN LoginSession S ON S.UPDATED_ON = (SELECT MAX(UPDATED_ON) FROM LoginSession SS, User UU 
        WHERE SS.USER_ID = UU.ID AND UU.ACCOUNT_ID = A.ID)
        WHERE A.STATUS=1 $where       
        ORDER BY A.ID DESC   $limit_con
        ";
    	$result=  $this->_db->fetchAll($select);
        if($is_count==1) return $result[0]['TOTAL'];
        else return $result;*/
        $user = Zend_Auth::getInstance()->getIdentity();   
        $this->user_id=$user['ACCOUNT_ID']; 
        
        $limit_con=($limit>0)?"LIMIT $offset, $limit":''; 
        $order_con = "";
           if(!is_null($sort) && $sort["field"] != "" ){$order_con = "ORDER BY ".$sort["field"]." ".$sort["mode"];}
        
        $utility=new Model_utility();
        $where=($utility->isAdmin())?"":"and A.ID='".$this->user_id."'";
           if(!is_null($filter) && $filter["value"] !== "") {$where .= " AND A.ACCOUNT_NAME like '%".$filter["value"]."%'";}
           
         $sql_con=($is_count==1)?"COUNT(*) AS TOTAL":" ";
            
         if($is_count == 1) {
             $select="
                    SELECT COUNT(*) as TOTAL 
                    FROM Account A 
					WHERE A.STATUS=1 $where";
					//WHERE A.ACCOUNT_TYPE!='0' AND A.STATUS=1 $where";

         } else {
             $select ="SELECT A.ID, A.TARGET_ID, A.AGENT_USER_ID, A.STATUS, S.UPDATED_ON
							, CASE A.ACCOUNT_TYPE WHEN '0' THEN 'Mall Rat'
								WHEN '1' THEN 'Real Estate'
								WHEN '2' THEN 'Mall'
								WHEN '3' THEN 'Vendor'
								WHEN '4' THEN 'Store'
								ELSE 'Unknown' END as ACCOUNTTYPE
							, A.ACCOUNT_NAME as ACCOUNTNAME 
                        FROM Account A
                        LEFT JOIN LoginSession S ON S.UPDATED_ON = (SELECT MAX(UPDATED_ON) FROM LoginSession SS, User UU 
							WHERE SS.USER_ID = UU.ID AND UU.ACCOUNT_ID = A.ID) 
                        WHERE A.STATUS=1 $where 
                    $order_con 
                    $limit_con";
         }
        $result=  $this->_db->fetchAll($select);
        if($is_count==1) return $result[0]['TOTAL'];
        else return $result;
    }
    public function getActive($limit = 15, $offset = 0,$is_count=0)
    {
        $user = Zend_Auth::getInstance()->getIdentity();   
        $this->user_id=$user['ACCOUNT_ID']; 
         $limit_con=($limit>0)?"LIMIT $offset, $limit":''; 
         //------ original code --------------
         $sql_con=($is_count==1)?"COUNT(*) AS TOTAL":' DISTINCT A.ID,A.MALL_ID,A.REAL_ESTATE_ID,A.AGENT_USER_ID,A.STATUS,S.UPDATED_ON,U.EMAIL_ADDRESS,U.FIRST_NAME,U.LAST_NAME,U.JOB_TITLE';
         
         $utility=new Model_utility();  
         $where=($utility->isAdmin())?'':"and A.ID='".$this->user_id."'";   
         $select ="select $sql_con from Account A
                LEFT JOIN User U on U.ACCOUNT_ID=A.ID   
                LEFT JOIN LoginSession S ON S.UPDATED_ON = (SELECT MAX(UPDATED_ON) FROM LoginSession SS, User UU 
                WHERE SS.USER_ID = UU.ID AND UU.ACCOUNT_ID = A.ID)
                WHERE A.STATUS=2 $where       
                ORDER BY A.ID DESC   $limit_con
                ";
        
    	$result=  $this->_db->fetchAll($select);
        
        /*$sql_con=($is_count==1)?" distinct COUNT(*) AS TOTAL":' DISTINCT A.ID,A.MALL_ID,A.REAL_ESTATE_ID,A.AGENT_USER_ID,A.STATUS,S.UPDATED_ON,U.EMAIL_ADDRESS,U.FIRST_NAME,U.LAST_NAME,U.JOB_TITLE';
        $utility=new Model_utility();  
        $where=($utility->isAdmin())?'':"and A.ID='".$this->user_id."'"; 
        $select = "SELECT $sql_con FROM  Account a "
        ."LEFT JOIN user u ON u.account_id = a.id "
        ."LEFT JOIN loginsession s on s.user_id = u.id "
        ."WHERE A.STATUS=2 $where "
        ."ORDER BY A.ID DESC $limit_con";*/
        if($is_count==1) return $result[0]['TOTAL'];
        else return $result;
    }
    public function getRealState($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null)
        {
         
        $user = Zend_Auth::getInstance()->getIdentity();   
        $this->user_id=$user['ACCOUNT_ID']; 
        
        $limit_con=($limit>0)?"LIMIT $offset, $limit":''; 
        $order_con = "";
        if(!is_null($sort) && $sort["field"] != "" ){$order_con = "ORDER BY ".$sort["field"]." ".$sort["mode"];}
          
		$where = "";
           if(!is_null($filter) && $filter["value"] !== "")  {$where .= " and a.ACCOUNT_NAME like '%".$filter["value"]."%'";}
        
         if($is_count == 1) {
            $select = "SELECT COUNT(*) as total 
                        FROM Account a
                        WHERE a.ACCOUNT_TYPE='1' $where";      
         } else {
            $select = "
                SELECT a.ID, a.TARGET_ID, r.O_COMPANY, r.O_STATE, a.STATUS, count(a.id) as MALLCNT, sum(mp.gla) as TOTALGLA, IFNULL(s.updated_on, '-') as LASTACTIVITY
                FROM Account a
                INNER JOIN Real_Estate r ON a.TARGET_ID = r.ID
                LEFT JOIN Mall m ON m.REAL_ESTATE_ID = a.TARGET_ID
                LEFT JOIN Mall_Profiles mp on m.ID=mp.ID
                LEFT JOIN (
                    SELECT MAX(UPDATED_ON) as UPDATED_ON, uu.ACCOUNT_ID ACCOUNT_ID
                    FROM LoginSession ss
                    LEFT JOIN User uu on ss.USER_ID = uu.ID
                    GROUP BY uu.ACCOUNT_ID
                  ) s 
                    ON s.ACCOUNT_ID=a.ID
				WHERE a.ACCOUNT_TYPE='1' $where
                GROUP BY a.ID
				$order_con
				$limit_con";
         }
         
        $result=  $this->_db->fetchAll($select);
        if($is_count==1) return $result[0]['total'];
        else return $result;
        }
    public function getMall($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null)
        {
        $user = Zend_Auth::getInstance()->getIdentity();    
        $this->user_id=$user['ACCOUNT_ID']; 
       
        $limit_con=($limit>0)?"LIMIT $offset, $limit":'';
        
        $order_con = "";
          if(!is_null($sort) && $sort["field"] != "" ){$order_con = "ORDER BY ".$sort["field"]." ".$sort["mode"];}

		$where='';
           if(!is_null($filter) && $filter["value"] !== "")  { $where .= " and a.ACCOUNT_NAME like '%".$filter["value"]."%'";}
        
        if($is_count==1){
            $sql = "SELECT COUNT(*) as total 
            FROM Account a 
            WHERE a.ACCOUNT_TYPE='2' $where
            ";
        } else {
            $sql = "
                    SELECT a.ID, a.TARGET_ID, a.STATUS as STATUS, IFNULL(m.MALLNAME, '-') as mallname, ifnull(mp.GLA, '-') as sale_sqft, ifnull(mf.FANCNT,0) as fans, ifnull(s.SESSION_COUNT,'0') as session_count, ifnull(m.MGMT_CITY, '-') as mgmt_city, ifnull(m.US_CAN,'-') as us_can, IFNULL(s.UPDATED_ON, '-') as lastactivity
                    FROM Account a
                    LEFT JOIN Mall m ON a.TARGET_ID = m.ID
                    LEFT JOIN Mall_Profiles mp ON mp.ID = a.TARGET_ID
                    LEFT JOIN (
                            SELECT MAX(UPDATED_ON) AS UPDATED_ON, uu.ACCOUNT_ID ACCOUNT_ID, COUNT(ss.ID) AS SESSION_COUNT
                            FROM LoginSession ss
                            INNER JOIN User uu ON ss.USER_ID = uu.ID
                            GROUP BY uu.ACCOUNT_ID
                        ) s ON s.ACCOUNT_ID=a.ID
                    LEFT JOIN (
                            SELECT COUNT(*) AS FANCNT, smf.MALL_ID AS MALL_ID FROM Mall_Fan smf GROUP BY smf.MALL_ID
                        ) mf ON mf.MALL_ID = a.TARGET_ID
                    WHERE a.ACCOUNT_TYPE='2' $where
                    GROUP BY a.ID
                $order_con
                $limit_con";

                
        }
        
        $result=  $this->_db->fetchAll($sql);
        if($is_count==1) return $result[0]['total'];
        else return $result;

        }
    public function getVendor($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null)
        {
		$user = Zend_Auth::getInstance()->getIdentity();    
        $this->user_id=$user['ACCOUNT_ID']; 
		
        $limit_con=($limit>0)?"LIMIT $offset, $limit":'';
        
        $order_con = "";
          if(!is_null($sort) && $sort["field"] != "" ){$order_con = "ORDER BY ".$sort["field"]." ".$sort["mode"];}

		$where='';
           if(!is_null($filter) && $filter["value"] !== "")  { $where .= " and a.ACCOUNT_NAME like '%".$filter["value"]."%'";}
        
        if($is_count==1){
            $sql = "SELECT COUNT(*) as total 
					FROM Account a 
					WHERE a.ACCOUNT_TYPE='3' $where
					";
        } else {
            $sql = "SELECT a.ID, a.TARGET_ID, a.STATUS as STATUS, a.ACCOUNT_NAME, sc.NAME as CATEGORY_NAME,'1' as STORECNT, '0' as FANS, IFNULL(s.UPDATED_ON, '-') as lastactivity 
                    FROM Account a 
                    LEFT JOIN Vendor v ON a.TARGET_ID = v.ID  
					LEFT JOIN StoreCategory sc ON v.CATEGORY_ID = sc.ID 
					LEFT JOIN ( 
                            SELECT MAX(UPDATED_ON) AS UPDATED_ON, uu.ACCOUNT_ID ACCOUNT_ID 
                            FROM LoginSession ss 
                            INNER JOIN User uu ON ss.USER_ID = uu.ID 
                            GROUP BY uu.ACCOUNT_ID 
                        ) s ON s.ACCOUNT_ID=a.ID 
                    WHERE a.ACCOUNT_TYPE='3' $where 
					$order_con 
					$limit_con";
					/*LEFT JOIN ( 
											SELECT COUNT(*) as STORECNT, VENDOR_ID
											FROM Store
											GROUP BY VENDOR_ID
										) as st ON st.VENDOR_ID = a.TARGET_ID*/
					//echo $sql;
					//exit;
        }
        
        $result=  $this->_db->fetchAll($sql);
        if($is_count==1) return $result[0]['total'];
        else return $result;
        /* $user = Zend_Auth::getInstance()->getIdentity();   
        $this->user_id=$user['ACCOUNT_ID'];  
        $limit_con=($limit>0)?"LIMIT $offset, $limit":'';
       if($is_count==1):
           $select = "SELECT DISTINCT COUNT(*) AS TOTAL FROM Vendor V 
           LEFT JOIN StoreCategory SC ON SC.ID = V.CATEGORY_ID
        left outer join Store ST on V.ID=ST.VENDOR_ID
       GROUP BY V.ID
        ORDER BY  V.NAME
        ";
       else:
          $select = "SELECT DISTINCT V.ID, V.NAME, SC.NAME as CATEGORY, V.UPDATED_ON,V.DELETED, count(ST.ID) as TOTAL_STORE FROM Vendor V 
        LEFT JOIN StoreCategory SC ON SC.ID = V.CATEGORY_ID
        left outer join Store ST on V.ID=ST.VENDOR_ID
       GROUP BY V.ID
        ORDER BY  V.NAME  $limit_con";
       endif;     
        
       
        $result=  $this->_db->fetchAll($select);
        if($is_count==1) return $result[0]['TOTAL'];
        else return $result;*/
        }
    public function getStore($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null)
        {
		$user = Zend_Auth::getInstance()->getIdentity();    
		$this->user_id=$user['ACCOUNT_ID']; 

		$limit_con=($limit>0)?"LIMIT $offset, $limit":'';

		$order_con = "";
			if(!is_null($sort) && $sort["field"] != "" ){$order_con = "ORDER BY ".$sort["field"]." ".$sort["mode"];}

		$where='';
			if(!is_null($filter) && $filter["value"] !== "")  { $where .= " and a.ACCOUNT_NAME like '%".$filter["value"]."%'";}

		if($is_count==1){
			$sql = "SELECT COUNT(*) as total 
					FROM Account a 
					WHERE a.ACCOUNT_TYPE='4' $where
					";
		} else {
			$sql = "
				SELECT a.ID, a.TARGET_ID, a.STATUS as STATUS, a.ACCOUNT_NAME, a.ACCOUNT_NAME as MALLNAME, sc.NAME as CATEGORY_NAME, '0' as FANS, IFNULL(s.UPDATED_ON, '-') as lastactivity 
				FROM Account a 
				LEFT JOIN Store st ON a.TARGET_ID = st.ID 
				LEFT JOIN StoreCategory sc ON st.CATEGORY_ID = sc.ID 
				LEFT JOIN ( 
						SELECT MAX(UPDATED_ON) AS UPDATED_ON, uu.ACCOUNT_ID ACCOUNT_ID
						FROM LoginSession ss 
						INNER JOIN User uu ON ss.USER_ID = uu.ID 
						GROUP BY uu.ACCOUNT_ID 
					) s ON s.ACCOUNT_ID=a.ID
				
				
				WHERE a.ACCOUNT_TYPE='4' $where 
				$order_con 
				$limit_con";
				/*LEFT JOIN LoginSession s ON s.UPDATED_ON = (SELECT MAX(UPDATED_ON) FROM LoginSession SS, User UU 
							WHERE SS.USER_ID = UU.ID AND UU.ACCOUNT_ID = a.ID)*/
				/*LEFT JOIN ( 
						SELECT MAX(UPDATED_ON) AS UPDATED_ON, uu.ACCOUNT_ID ACCOUNT_ID
						FROM LoginSession ss 
						INNER JOIN User uu ON ss.USER_ID = uu.ID 
						GROUP BY uu.ACCOUNT_ID 
					) s ON s.ACCOUNT_ID=a.ID */
				//LEFT JOIN Mall m ON st.MALL_ID = m.ID 
		}

		$result=  $this->_db->fetchAll($sql);
		if($is_count==1) return $result[0]['total'];
		else return $result;
        /*$user = Zend_Auth::getInstance()->getIdentity();   
        $this->user_id=$user['ACCOUNT_ID'];   
         $limit_con=($limit>0)?"LIMIT $offset, $limit":'';
        if($is_count==1):
           $select = "SELECT DISTINCT COUNT(*) AS TOTAL FROM Store S 
           LEFT JOIN StoreCategory SC ON SC.ID = S.CATEGORY_ID
        left join Mall M ON M.ID=S.MALL_ID
         
        ";
       else:
          $select = "SELECT DISTINCT S.*,SC.NAME as CATEGORY, M.MALLNAME as MALL FROM Store S 
           LEFT JOIN StoreCategory SC ON SC.ID = S.CATEGORY_ID
        left join Mall M ON M.ID=S.MALL_ID
           $limit_con";  
       endif;     
       
       $result=  $this->_db->fetchAll($select);
        if($is_count==1) return $result[0]['TOTAL'];
        else return $result;*/
        }
    
    public function countAll()
    {
    	 
    	$data['all'] = $this->getAll(1);
    	$data['active'] = 0;//$this->getActive(0, 0,1);
    	$data['activate'] = $this->getActivate(1);
        $data['pending'] = $this->getPending(1);
        $data['realstate'] =$this->getRealState(1);
        $data['mall'] = $this->getMall(1);
        $data['vendor'] = $this->getVendor(1);
    	$data['store'] = $this->getStore(1);
    	return $data;
    }
    public function getAllEvent()
        {
            $query="select * from Events ORDER BY id DESC limit 5";
             return  $this->_db->fetchAll($query); 
        }
        
    public function getAccountAllInfo($accId)
        {
            $select="Select * from Account A 
            Left join Mall M on M.ID=A.MALL_ID
            Left join Real_Estate R on R.ID=A.REAL_ESTATE_ID
            left outer join User U on U.ACCOUNT_ID=A.ID
            where A.ID='".$accId."'";
           return  $this->_db->fetchRow($select);   
        }
    public function getRealEstateInfo($realId)
        {
            $select="Select * from Real_Estate R  
                    LEFT JOIN Mall M ON M.REAL_ESTATE_ID = R.ID
                    LEFT JOIN Mall_Profiles MP ON MP.ID=M.ID
                    where R.ID='".$realId."'";
           return  $this->_db->fetchRow($select);   
        }
    public function getStoreListByMallId($mall_id)
        {
           $select="Select * from Store S
                    Left join StoreCategory c on c.ID=S.CATEGORY_ID
                    Left join MallFloorPlan f on f.ID=S.FLOOR_ID
                     where S.MALL_ID='".$mall_id."'";
           return  $this->_db->fetchAll($select);    
        }
    public function getMallListByRealestateId($realId)
        {
  
         $select = "SELECT DISTINCT A.ID, A.STATUS, M.MALLNAME, M.MGMT_CITY, M.US_CAN, S.UPDATED_ON,count(MF.ID) as MALL_FAN FROM Account A 
        LEFT JOIN Mall M ON A.MALL_ID = M.ID 
        left join Mall_Fan MF on MF.MALL_ID=M.ID
        LEFT JOIN LoginSession S ON S.UPDATED_ON = (SELECT MAX(UPDATED_ON) FROM LoginSession SS, User UU WHERE SS.USER_ID = UU.ID AND UU.ACCOUNT_ID = A.ID) 
        WHERE M.REAL_ESTATE_ID ='".$realId."'   
        ORDER BY A.STATUS, M.MALLNAME";
          return  $this->_db->fetchAll($select);   
        }
	private function getUID()
	{
		$query = "SELECT UUID() as UID";
		$result =$this->_db->fetchRow($query);
		return $result['UID'];     
	}
	public function addNewRealEstate($data) {
		try{
			$real_estate_id = $this->getUID();

			$query = "INSERT INTO Real_Estate(ID, O_COMPANY, O_ADDR1,O_ADDR2, O_CITY, O_STATE, O_COUNTRY, O_WEB)";
			$query = $query . " VALUES('" . $real_estate_id .  "', '" . $data['real_name'] . "', '" .$data['real_addr1'] . "','" .$data['real_addr2'] . "', '" . $data['real_city'] . "', '" . $data['real_province'] . "', '" . $data['real_country'];
			$query = $query . "', '', '" . $data['web_site'] . "')";
			$result = $this->_db->query($query);    

			$query = "INSERT INTO Account(ID, TARGET_ID, ACCOUNT_NAME, ACCOUNT_TYPE) VALUES(UUID(), '" . $real_estate_id . "', '" . $data['real_name'] . "', 1)";
			$result = $this->_db->query($query);  
			return "Successfully created".$real_estate_id;

		}catch(Exception $e)
		{
			return $e->getMessage();
		}
    }
  
	public function addNewMall($data) {
		try{
			$realestate_id = $this->getRealEstateID($data['mall_real_estate']);
			if(is_null($realestate_id)) {
				return 'You typed undefined real estate name.';
			}
			$mall_id = $this->getUID();  
			
			$query = "INSERT INTO Mall(ID, REAL_ESTATE_ID,MALLNAME, MGMT_ADD1, MGMT_CITY, MGMT_STAT, MGMT_ZIP, CUSTOMER_SERVICE_NUMBER, US_CAN)";
			$query = $query . " VALUES('" . $mall_id .  "', '" . $realestate_id . "', '" . $data['mall_name'] . "', '" . $data['mall_addr1'] . "', '" . $data['mall_city'];
			$query = $query  . "', '" . $data['mall_state'] . "', '" . $data['mall_zipcode'] . "', '" . $data['mall_customer_service'] . "', '". $data['mall_country'] . "')";    
			$result = $this->_db->query($query);

			$query = "INSERT INTO Account(ID, TARGET_ID, ACCOUNT_NAME, ACCOUNT_TYPE) VALUES(UUID(), '" . $mall_id . "', '" . $data['mall_name'] . "', 2)";
			$result = $this->_db->query($query);

			return 'Successfully Added'.$mall_id;

		} catch(Exception $e ) {
			return $e->getMessage();
		}
	}
	public function addNewVendor($data){
		try{
			$category_id = $this->getCategoryID($data['vendor_category']);
			if(is_null($category_id)) {
				return 'You typed undefined category name.';
			}
			$vendor_id = $this->getUID();

			$query = "INSERT INTO Vendor(ID, NAME, CATEGORY_ID, DESCRIPTION, CREATED_ON) "
					."VALUES ('$vendor_id','{$data['vendor_name']}', '$category_id', '{$data['vendor_desc']}',NOW())";
			$result = $this->_db->query($query);
			
			$uploaddir = $_SERVER['DOCUMENT_ROOT']."/tempfiles/";

			/*$svgfilecontent = file_get_contents($uploaddir.$data['vendor_logofilename']);
			$convertedcontent = $this->_db->quoteInto("?",$svgfilecontent);
			//$query = $this->_db->quoteInto("INSERT INTO Vendor_Logo(ID, FILECONTENT) VALUES (?, ?)", $vendor_id, $svgfilecontent);
			$query = "INSERT INTO Vendor_Logo(ID, FILECONTENT) VALUES ('$vendor_id', $convertedcontent)";
			//echo $query;
			$result = $this->_db->query($query);*/

			$query = "INSERT INTO Account(ID, TARGET_ID, ACCOUNT_NAME, ACCOUNT_TYPE)";
			$query.= "VALUES (UUID(), '$vendor_id','{$data['vendor_name']}', '3')";

			unlink($uploaddir.$data['vendor_logofilename']);
			$result = $this->_db->query($query);
			return 'Successfully Added'.$vendor_id;
		} catch(Exception $e ) {
			return $e->getMessage();
		}
	}
	public function addNewStore($data){
		try{
			$vendor_id = $this->getVendorID($data['store_vendor']);
			if(is_null($vendor_id)) {
				return 'You typed undefined vendor name.';
			}
			$mall_id = $this->getMallID($data['store_mall']);
			if(is_null($mall_id)) {
				return 'You typed undefined mall name.';
			}
			$category_id = $this->getCategoryID($data['store_category']);
			if(is_null($category_id)) {
				return 'You typed undefined category name.';
			}
			$store_name = $data['store_vendor']."-".$data['store_mall'];
			
			$store_id = $this->getUID();
			$query = "INSERT INTO Store(ID, DESCRIPTION, CATEGORY_ID, VENDOR_ID, MALL_ID, CREATED_ON)";
			$query.= "VALUES ('$store_id','{$data['store_desc']}', '$category_id', '$vendor_id', '$mall_id', NOW())";
			$result = $this->_db->query($query);
			
			$query = "INSERT INTO Account(ID, TARGET_ID, ACCOUNT_NAME, ACCOUNT_TYPE)";
			$query.= "VALUES (UUID(), '$store_id','$store_name', '4')";
			$result = $this->_db->query($query);
			return 'Successfully Added'.$store_id;
		} catch(Exception $e ) {
			return $e->getMessage();
		}
	}
	private function getMallID($mallname) {
		try{
			$query = "SELECT ID FROM Mall WHERE MALLNAME='$mallname'";
			$result = $this->_db->fetchAll($query);
			if(count($result) > 0) {
				return $result[0]["ID"];
			}
		}catch(Exception $e) {
			return null;
		}
	}
	private function getVendorID($name) {
		try{
			$query = "SELECT ID FROM Vendor WHERE NAME='$name'";
			$result = $this->_db->fetchAll($query);
			if(count($result) > 0) {
				return $result[0]["ID"];
			}
		}catch(Exception $e) {
			print_r($e);
			return null;
		}
	}
	private function getCategoryID($name) {
		try{
			$query = "SELECT ID FROM StoreCategory WHERE NAME='$name'";
			$result = $this->_db->fetchAll($query);
			if(count($result) > 0) {
				return $result[0]["ID"];
			}
		}catch(Exception $e) {
			return null;
		}
	}
	private function getRealEstateID($name) {
		try{
			$query = "SELECT ID FROM Real_Estate WHERE O_COMPANY='$name'";
			$result = $this->_db->fetchAll($query);
			if(count($result) > 0) {
				return $result[0]["ID"];
			}
		}catch(Exception $e) {
			return null;
		}
	}
  
  public function deleteAccount($account_id)
    {
        $query = "SELECT M.ID FROM Mall M, Account A WHERE A.MALL_ID = M.ID AND A.ID = '$account_id'";
    $result = $this->_db->fetchRow($query);
    
   
    $mall_id = $result['ID'];
    
    if (!isEmpty($mall_id)) {
        $query = "DELETE LoginSession S FROM LoginSession S, User U WHERE S.USER_ID = U.ID AND U.ACCOUNT_ID='$account_id'";
        
        $result = $this->_db->query($query);
       
        $query = "SELECT ID FROM MallFloorPlan WHERE MALL_ID = '$mall_id'";

        $result = $this->_db->fetchAll($query);
        
        $tabs = array("Store", "Path", "ServiceItem");
        
        foreach ($result as $row) {
            $floor_id = $row["ID"];
            
            foreach ($tabs as $t) {
                $query = "DELETE FROM $t WHERE FLOOR_ID='$floor_id'";

                 $this->_db->query($query);
                
            }            
        }
        
        $tabs = array("Mall_Profiles", "Leasing_Data", "Market_Data", "Visitor_Traffic", 
                      "Mall_Manager", "Marketing_Manager", "Specialty_Leasing", "Leasing_Agent",
                      "Mall_Management", "Management_Company", "Owner_Company");
                      
        foreach ($tabs as $t) {
            $query = "DELETE FROM $t WHERE ID='$mall_id'";

            $result = $this->_db->query($query);
           
        }

        $tabs = array("MallFloorPlan", "MallHours", "Service", "Intersection");
                      
        foreach ($tabs as $t) {
            $query = "DELETE FROM $t WHERE MALL_ID='$mall_id'";

            $result = $this->_db->query($query);
                     
        }
        
        $query = "UPDATE Account SET AGENT_USER_ID=NULL WHERE ID='$account_id'";
        
        $result = $this->_db->query($query);
       
        $query = "DELETE A FROM Activity A, User U WHERE (A.REQUESTED_BY = U.ID OR A.APPROVED_BY = U.ID OR A.NEW_AGENT_ID = U.ID) AND U.ACCOUNT_ID='" . $account_id . "'";
        
        $result = $this->_db->query($query);
       
        $query = "DELETE FROM User WHERE ACCOUNT_ID='$account_id'";
        
        $result = $this->_db->query($query);
        
        $query = "DELETE FROM Account WHERE ID='$account_id'";
        
        $result = $this->_db->query($query);
       $query = "DELETE FROM Activity WHERE MALL_ID='$mall_id'";
        
        $result = $this->_db->query($query);
       
        $query = "DELETE FROM Mall WHERE ID='$mall_id'";
        
        $result = $this->_db->query($query);
        
        $rootPath = realpath("./..");
        $fullMapsPath = $rootPath . "/" . $maps_folder;
    
        if (!file_exists($fullMapsPath)) {
             mkdir($fullMapsPath);
        }
        
        $utility_model=new Model_utility();
        $fullMapsPath = $fullMapsPath . "/" . $mall_id;    
        $utility_model->clearDir($fullMapsPath);
    }
}

public function deleteRealEsate($account_id)
    {
        try{
            $query = "SELECT R.ID FROM Real_Estate R, Account A WHERE A.REAL_ESTATE_ID = R.ID AND A.ID = '$account_id'";
    $result = $this->_db->fetchRow($query);
    
    
    $real_estate_id = $result['ID'];
    
    if (!isEmpty($real_estate_id)) {
        $query = "DELETE LoginSession S FROM LoginSession S, User U WHERE S.USER_ID = U.ID AND U.ACCOUNT_ID='$account_id'";
        
        $result = $this->_db->query($query);
       
        $query = "UPDATE Account SET AGENT_USER_ID=NULL WHERE ID='$account_id'";
        
        $result = $this->_db->query($query);
       
        $query = "DELETE A FROM Activity A, User U WHERE (A.REQUESTED_BY = U.ID OR A.APPROVED_BY = U.ID OR A.NEW_AGENT_ID = U.ID) AND U.ACCOUNT_ID='" . $account_id . "'";
        
        $result = $this->_db->query($query);
        
        $query = "DELETE FROM User WHERE ACCOUNT_ID='$account_id'";
        
        $result = $this->_db->query($query);
       
        $query = "DELETE FROM Account WHERE ID='$account_id'";
        
        $result = $this->_db->query($query);
        
        $query = "DELETE FROM Real_Estate WHERE ID='$real_estate_id'";
        
        $result =$this->_db->query($query);
        return "Successfully Deleted";
        
    }
    }catch(Exception $e){
        return $e->getMessage();
            
        }
        
    }
}