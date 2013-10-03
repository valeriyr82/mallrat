<?php
  class Model_content extends Zend_Db_Table
{
    private $utility;
    
    public function deleteContentById($accountId)
        {
            if($this->_db->delete('Events',array('ID=?'=>$accountId)))
                return true;
            else
                return false;
        }
    public function deleteJobById($accountId)
        {
            if($this->_db->delete('Job',array('ID=?'=>$accountId)))
                return true;
            else
                return false;
        }
    public function getAllJobs($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null)//($limit = 25, $offset = 0,$is_count=0,$con='')
	{
		//$user = Zend_Auth::getInstance()->getIdentity();   
		//$this->user_id=$user['ACCOUNT_ID'];  
		$DB = $this->_db;
		$utility_model= new Model_utility(); 
		$limit_con=($limit>0)?"LIMIT $offset, $limit":'';

		$filter_con = "";
		$quoted_val = "";
		if(!is_null($filter) and $filter["field"] !== "") { 
			try{ 
				$quoted_val = $DB->quote($filter["value"]);
				$quoted_val = substr($quoted_val, 1);
				$quoted_val = substr($quoted_val, 0, -1);
			} catch(Zend_Db_Exception $ex){}
			$filter_con = " AND J.JOB_TITLE like '$quoted_val%'" ;
		}
		
		$order_con = "";
		if(!is_null($sort) and $sort["field"] != "") {$order_con = " ORDER BY ".$sort["field"]." ".$sort["mode"]; }
		
		if($is_count==1) {
			$select ="SELECT COUNT(*) as TOTAL
			FROM Job J
			LEFT JOIN Mall M ON M.ID=J.MALL_ID 
			WHERE 1=1
			$filter_con";
			//echo $select;
		} else {
			$select ="SELECT J.ID, J.REF_NUMBER, J.JOB_TITLE, M.MALLNAME, DATEDIFF(J.CLOSING_DATE,CURDATE()) as DAY_LEFT,DATE_FORMAT(J.CLOSING_DATE,'%M %d, %Y') as closing_date
				FROM Job J 
				LEFT JOIN Mall M ON M.ID=J.MALL_ID 
				WHERE 1=1 
				$filter_con 
				$order_con 
				$limit_con";
			//echo $select;
			//exit;
		}
		$result =  $this->_db->fetchAll($select);
		if($is_count==1) return $result[0]['TOTAL'];
		else return $result;  
	}
    public function getAllEvents($is_count=1, $filter = null, $limit = 15, $offset = 0, $sort = null)//($limit = 25, $offset = 0,$is_count=0,$con='')
	{
		//$user = Zend_Auth::getInstance()->getIdentity();   
		//$this->user_id=$user['ACCOUNT_ID']; 
		$DB = $this->_db;
		$utility_model= new Model_utility();
		
		$limit_con=($limit>0)?"LIMIT $offset, $limit":'';
		$filter_con = "";
		$quoted_val = "";
		if(!is_null($filter) && $filter["field"] !== "") { 
			try{ 
				$quoted_val = $DB->quote($filter["value"]);
				$quoted_val = substr($quoted_val, 1);
				$quoted_val = substr($quoted_val, 0, -1);
			} catch(Zend_Db_Exception $ex){}
			$filter_con = " AND E.NAME like '$quoted_val%'" ;
		}
		
		$order_con = "";
		if(!is_null($sort) && $sort["field"] != "") {$order_con = " ORDER BY ".$sort["field"]." ".$sort["mode"]; }
		
		if($is_count==1) {
			$select ="SELECT COUNT(*) as TOTAL
				FROM Events E
				WHERE 1=1
				$filter_con";
				//GROUP BY E.ID";
				//echo $select;

		} else {
			$select ="SELECT E.*,M.MALLNAME,DATE_FORMAT(E.START_DATE,'%M %d, %Y') as start_date,DATE_FORMAT(E.END_DATE,'%M %d, %Y') as end_date,COUNT(EA.ID)as attending
				FROM Events E
				LEFT JOIN EventAttending EA ON EA.EVENT_ID =E.ID  
				LEFT JOIN Mall M ON E.MALL_ID = M.ID  
				WHERE 1=1
				$filter_con
				GROUP BY E.ID 
				$order_con
				$limit_con";
			
		}		
		$result=  $this->_db->fetchAll($select);
		if($is_count==1) return $result[0]['TOTAL'];
		else return $result;  
	}
    
    public function countall()
	{
		$data['jobs'] = $this->getAllJobs(1);
		$data['events'] = $this->getAllEvents(1);
		return $data;   
	}

	public function addNewEvent($data) {
		try{
			$DB = $this->_db;
			if(is_null($data["event_mall"]) || $data["event_mall"]==="" ) {
				return "Please select shopping mall.";
			}
			$startdate = "";
			if(is_null($data["event_start_date_input"]) || $data["event_start_date_input"] == "") {
				return "Please input start date.";
			} else {
				$startdate = "STR_TO_DATE('".$data["event_start_date_input"]."','%m/%d/%Y')";
			}
			$enddate = "";
			if(is_null($data["event_end_date_input"]) || $data["event_end_date_input"] == "") {
				return "Please input end date.";
			} else {
				$enddate = "STR_TO_DATE('".$data["event_end_date_input"]."','%m/%d/%Y')";
			}
			$publicfilepath = "";
			if(!is_null($data['event_filename']) && $data["event_filename"]!="") {
				$publicfilepath = $this->copytoeventimage($data['event_filename']);
			}
			$query = "INSERT INTO Events(ID, NAME, DESCRIPTION, MALL_ID, START_DATE, END_DATE, IMAGE_URL)"
					." VALUES( UUID(), ".$DB->quote($data["event_name"]). ",".$DB->quote($data["event_desc"]).",".$DB->quote($data['event_mall']).",".$startdate
					.",".$enddate.",".$DB->quote($publicfilepath).")";    
			$result = $this->_db->query($query);
			return 'Successfully Added';
		} catch(Exception $e ) {
			return $e->getMessage();
		}
	}
	private function copytoeventimage($srcfilename) {
		
		$srcrealpath = APPLICATION_ROOT.'/public/tempfiles/';
		$curdatedir = date('Ym');
		$this->makeDir(APPLICATION_ROOT.'/public/eventimages/'.$curdatedir);
		$dstrealpath = APPLICATION_ROOT.'/public/eventimages/'.$curdatedir.'/'.$srcfilename;
		$dstthumbpath = APPLICATION_ROOT.'/public/eventimages/'.$curdatedir.'/thumb_'.$srcfilename;
		copy($srcrealpath.$srcfilename,$dstrealpath);
		unlink($srcrealpath.$srcfilename);
		$dstpublicpath = '/eventimages/'.$curdatedir."/".$srcfilename;
		$this->make_thumb($dstrealpath, $dstthumbpath, 70, 40);
		return $dstpublicpath;
	}
	private function makeDir($path)
	{
		return is_dir($path) || mkdir($path);
	}
	private function make_thumb($src, $dest, $limit_width, $limit_height) {
		/* read the source image */
		$source_image = imagecreatefromjpeg($src);
		$width = imagesx($source_image);
		$height = imagesy($source_image);
		
		/* find the "desired height" of this thumbnail, relative to the desired width  */
		
		if(($width / $height) > ($limit_width / $limit_height)) {
			$desired_width = $limit_width;
			$desired_height = floor($height * ($desired_width / $width));
		} else {
			$desired_height = $limit_height;
			$desired_width = floor($width * ($desired_height / $height));
		}
		
		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
		
		/* copy source image at a resized size */
		imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
		
		/* create the physical thumbnail image to its destination */
		imagejpeg($virtual_image, $dest);
	}
	public function addNewJob($data) {
		try{
			$DB = $this->_db;
			if(is_null($data["job_mall"]) || $data["job_mall"]==="" ) {
				return "Please select shopping mall.";
			}

			$job_store = "";
			if(is_null($data["job_store"]) || $data["job_store"]==="" ) {
				$job_store = 'null';
			} else {
				$job_store = $DB->quote($data["job_store"]);
			}

			$closingdate = "";
			if(is_null($data["job_close_date_input"]) || $data["job_close_date_input"] == "") {
				$closingdate = "ADDDATE(NOW(), INTERVAL 60 DAY)";
			} else {
				$closingdate = "STR_TO_DATE('".$data["job_close_date_input"]."','%m/%d/%Y')";
			}
			$query = "INSERT INTO Job(ID, MALL_ID, STORE_ID, JOB_TITLE, REF_NUMBER, DESCRIPTION, EXPERIENCE, CLOSING_DATE)"
					." VALUES( UUID(), ".$DB->quote($data["job_mall"]). ",".$job_store.",".$DB->quote($data['job_title']).",".$DB->quote($data['job_refnumber'])
					.",".$DB->quote($data['job_desc']).",".$DB->quote($data['job_experience']).",".$closingdate.")";
			//return $query;
			$result = $this->_db->query($query);

			return 'Successfully Added';

		} catch(Exception $e ) {
			return $e->getMessage();
		}
	}
//---------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------
	public function getStoreListByMallId($mallid)
	{
//		$select="SELECT S.ID as id, S.
//			FROM Store S 
//			LEFT JOIN Mall M ON M.ID=S.MALL_ID AND M.ID='".$mallid."'"; 
		$select="SELECT A.ACCOUNT_NAME as value, A.TARGET_ID as id
				FROM Account A
				INNER JOIN Store S ON S.ID = A.TARGET_ID AND S.MALL_ID='$mallid'
				WHERE A.ACCOUNT_TYPE='4'";
		$result=  $this->_db->fetchAll($select);
		return $result;
	}    
	public function getRealEstateList($keyword) {
		$select="SELECT O_COMPANY as value, O_COMPANY as label, ID as id FROM Real_Estate WHERE O_COMPANY like '$keyword%' limit 20";
		$result=  $this->_db->fetchAll($select);
		return $result;
	}
	public function getCategoryList($keyword) {
		$select="SELECT NAME as value, NAME as label, ID as id FROM StoreCategory WHERE NAME like '$keyword%' ORDER BY NAME";
		$result=  $this->_db->fetchAll($select);
		return $result;
	}
	public function getVendorList($keyword) {
		$select="SELECT NAME as value, NAME as label, ID as id FROM Vendor WHERE NAME like '$keyword%' limit 20";
		$result=  $this->_db->fetchAll($select);
		return $result;
	}
	public function getMallList($keyword, $islimited = 1) {
		$select="SELECT MALLNAME as value, MALLNAME as label, ID as id FROM Mall WHERE MALLNAME like '$keyword%'";
		if($islimited == 1) {
			$select.= " limit 20";
		}
		$result=  $this->_db->fetchAll($select);
		return $result;
	}
	public function getAccountList($keyword) {
		$select="SELECT ACCOUNT_NAME as value, ACCOUNT_NAME as label, ID as id FROM Account WHERE ACCOUNT_NAME like '$keyword%' ORDER BY ACCOUNT_NAME limit 20";
		$result=  $this->_db->fetchAll($select);
		array_push($result, array("value"=>"Mall Rat", "label"=>"Mall Rat", "id"=>"mallratid"));
		return $result;
	}
	public function activateUser($email, $password) {
		$returnstring = "";
		$DB = $this->_db;
		$query="SELECT * FROM User WHERE EMAIL_ADDRESS=".$DB->quote($email)." and PASSWORD=".$DB->quote($password);
		$result=  $this->_db->fetchAll($query);
		if(count($result) > 0) {
			try{
				$user_id = $result[0]["ID"];
				$account_id = $result[0]["ACCOUNT_ID"];
				$query="UPDATE User SET STATUS='1' WHERE ID=".$DB->quote($user_id);
				$this->_db->query($query);
				$query="UPDATE Account SET STATUS='2' WHERE ID=".$DB->quote($account_id);
				$this->_db->query($query);
				$returnstring = "Following user has been successfully activated: <br /><b>$email</b>";
			} catch (Zend_Db_Exception $e) {
				$returnstring = $e->getMessage();
			}
		} else {
			$returnstring = "Could not found a user to be activated.";
		}
		return $returnstring;
	}
}
?>
