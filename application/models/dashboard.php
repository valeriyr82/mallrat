<?php
class Model_dashboard extends Zend_Db_Table
{
    private $utility;
   
    
    public function getDashboradData(){
        $user = Zend_Auth::getInstance()->getIdentity();
        $query="SELECT * FROM Account acc 
                Left join Mall m on m.id=acc.TARGET_ID
                left join Real_Estate rs on rs.id=acc.TARGET_ID
                WHERE acc.ID ='".$user['ACCOUNT_ID']."'";
           $db=$this->getAdapter();
          return $result=$db->fetchAll($query);
                 
        
    }
    public function getStatistics($post)
        {
            $this->utility=new Model_utility();
          $session_id = @$post["session_id"];
            $is_session = (int)@$post["is_session"];
            $month = @$post["month"];
            $year = @$post["year"];
            $datefrom=@$post["datefrom"];    
            $dateto=@$post["dateto"];    
            $mall_id = @$post["mall_id"];
            $real_estate_id = @$post["real_estate_id"];   
             $db=$this->getAdapter();
            $data=$this->utility->outputXMLHeader()."<Response>\n";
    
    if ($is_session) {
        if (!$this->utility->isEmpty($mall_id)) {
            $query = "SELECT IFNULL(SUM(SESSIONS),0) as total_download FROM MallStatistics WHERE MALL_ID = '$mall_id'";
        }
        else if (!$this->utility->isEmpty($real_estate_id)) {
            $query = "SELECT IFNULL(SUM(SESSIONS),0) as total_download FROM MallStatistics S, Mall M WHERE S.MALL_ID = M.ID AND M.REAL_ESTATE_ID='$real_estate_id'";
        }
        else {
            $query = "SELECT IFNULL(SUM(SESSIONS),0) as total_download FROM MallStatistics";            
        }
    }
    else {
        $query = "SELECT IFNULL(SUM(DOWNLOADS),0) as total_download FROM Downloads";
    }
    
    $row = $db->fetchRow($query);
   
    $total = $row['total_download'];
    
    $data.="\t<Total>$total</Total>\n";
    
    //mall fans start

        if (!$this->utility->isEmpty($mall_id)) {
            $query = "SELECT count(*) as total_fan FROM Mall_Fan WHERE MALL_ID = '$mall_id'";
        }
        else if (!$this->utility->isEmpty($real_estate_id)) {
            $query = "SELECT count(*) as total_fan FROM Mall_Fan S, Mall M WHERE S.MALL_ID = M.ID AND M.REAL_ESTATE_ID='$real_estate_id'";
        }
        else {
            $query = "SELECT count(*) as total_fan FROM Mall_Fan";            
        }
   
    
    
    $row = $db->fetchRow($query);
   
    $total_fan = $row['total_fan'];
    
    $data.="\t<TotalFan>$total_fan</TotalFan>\n";
    
    
    //mall fans end
    
    //date range
    $rang_condition='';
      if (!$this->utility->isEmpty($datefrom) && !$this->utility->isEmpty($dateto)) {  
       
         
          $month_from=date("m",strtotime($datefrom));
           $rang_condition=" DATE( CONCAT( `YEAR` , '-', `MONTH` , '-', `DAY` ) )  between
                            '".date("Y",strtotime($datefrom))."-".date("m",strtotime($datefrom))."-".date("d",strtotime($datefrom))."'
                            and  '".date("Y",strtotime($dateto))."-".date("m",strtotime($dateto))."-".date("d",strtotime($dateto))."'
                            ";

      }
    //
    
    if (!$is_session) {
        
      
        $query = "SELECT COUNT(DISTINCT DEVICE_UUID) as total_month FROM DeviceRegistration WHERE MONTH = $month AND YEAR = $year";
    
         $row = $db->fetchRow($query);
        $total = $row['total_month'];
        
        $data.= "\t<MonthUnique>$total</MonthUnique>\n";        
    }
    
    if ($is_session) {
        if (!$this->utility->isEmpty($mall_id)) {
            
             $con=(strlen($rang_condition)==0)?" MONTH = $month AND YEAR = $year":$rang_condition;
            $query = "SELECT DAY, SESSIONS FROM MallStatistics WHERE $con AND MALL_ID = '$mall_id'";
           
        }  
        else if (!$this->utility->isEmpty($real_estate_id)) {
            $con=(strlen($rang_condition)==0)?" MONTH = $month AND YEAR = $year":$rang_condition;   
            $query = "SELECT DAY, SUM(SESSIONS) as total_session FROM MallStatistics S, Mall M WHERE $con AND S.MALL_ID = M.ID AND M.REAL_ESTATE_ID = '$real_estate_id' GROUP BY DAY";
        }
        else {
            $con=(strlen($rang_condition)==0)?" MONTH = $month AND YEAR = $year":$rang_condition;   
            $query = "SELECT DAY, SUM(SESSIONS) as total_session FROM MallStatistics WHERE $con GROUP BY DAY";
        }    
    }
    else {
        $con=(strlen($rang_condition)==0)?" MONTH = $month AND YEAR = $year":$rang_condition;   
        $query = "SELECT DAY, ACTIVE_USERS as total_session FROM Statistics WHERE $con";
    }
    
     $result = $db->fetchAll($query);
     $total_session_data_value=0;

   foreach($result as $row){
        $day = $row['DAY'];
        $value = $row['total_session'];
        $total_session_data_value=$total_session_data_value+$value;
        $data.= "\t<Day$day>$value</Day$day>\n";
    }
    $data.= "\t<TotalDayData>".count($result)."</TotalDayData>\n";
    $data.= "\t<TotalDataSessionValue>".$total_session_data_value."</TotalDataSessionValue>\n";

    if (!$this->utility->isEmpty($real_estate_id)) {
        $query = "SELECT COUNT(*) as total_mall FROM Mall WHERE REAL_ESTATE_ID = '$real_estate_id'";
       }else{
        $query="SELECT count( ID ) as total_mall FROM Mall";
    }
        $row = $db->fetchRow($query);
        
        $count = $row['total_mall'];
        
        $data.= "\t<MallCount>$count</MallCount>\n";
        //total  Mall
        
        $query="SELECT count( DISTINCT MALL_ID ) as total_mall_floor FROM MallFloorPlan";
         $row = $db->fetchRow($query);   
          $mall_floor=$row['total_mall_floor'];
          $data.= "\t<MallFloorCount>$mall_floor</MallFloorCount>\n";    
     //avg map
        $select="select IFNULL(SUM(SESSIONS),0) as total_session from MallStatistics";
       
       $row = $db->fetchRow($select);    
       $total_session=$row['total_session'];
       //starting year, month,day
         $select="select * from MallStatistics  
            where year =(select min(year)  from MallStatistics)  
            order by month ,day limit 1 ";
            $row = $db->fetchRow($select);   
            $date1 = $row['YEAR'].'-'.$row['MONTH'].'-'.$row['DAY'];
            $date2 = date('Y-m-d');

            $diff = abs(strtotime($date2) - strtotime($date1));

            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
         $avg=number_format($total_session/$months,2);       
       //
     //
     $data.= "\t<AVGMap>$avg</AVGMap>\n"; 
    $data.= "</Response>\n";
    
    return $data;
        }
}

?>