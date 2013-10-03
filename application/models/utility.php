<?php
  class Model_utility extends Zend_Db_Table{
      
     
      
        public function currentPageURL() {
            $curpageURL = 'http';
            
            if (@$_SERVER["HTTPS"] == "on") {
                $curpageURL.= "s";
            }
            
            $curpageURL.= "://";
                
            if ($_SERVER["SERVER_PORT"] != "80") {
                $curpageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER['PHP_SELF']);
            } else {
                $curpageURL .= $_SERVER["SERVER_NAME"] . dirname($_SERVER['PHP_SELF']);
            }
                
            return $curpageURL;
        }


        public function outputXMLHeader() {
              return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        }


         public function  escapeStringForXML($str) {
            $str = str_replace("&", "&amp;", $str);
            $str = str_replace("<", "&lt;", $str);
            $str = str_replace(">", "&gt;", $str);
            $str = str_replace("\"", "&quot;", $str);
            $str = str_replace("'", "&apos;", $str);

            return $str;
        }


       public function forSQL($value) {
             if ($this->isEmpty($value)) {
                 return "NULL";
             }
             else {
                 return "'" . str_replace("'", "''", $value) . "'";
             }
        }


        public function isEmpty($value) {
             return ($value == NULL || strlen($value) == 0);
        }


         public function ReportError($description, $condition) {
            if ($condition) {
                $this->outputXMLHeader();
                echo "<Error>\n<Description>" . $this->escapeStringForXML($description) . "</Description>\n</Error>";
                exit;
            }
        }

        public function getUserSession($user_id){
            $db=$this->getAdapter();
             $query="select * from  LoginSession WHERE USER_ID = '" . $user_id . "'";
            $row=$db->fetchRow($query);
            
            return $row['ID'];
        }
        


       public function CheckSession($session_id) {
           $db=$this->getAdapter();
            $query = "SELECT TIMESTAMPDIFF(MINUTE, UPDATED_ON, CURRENT_TIMESTAMP()) FROM LoginSession WHERE LOGGED_OUT = 0 AND ID = '" . $session_id . "'";
            
            
            $row = $db->fetchAll($query);
            
            if (!$row) {
                 echo "<html><body><script type=\"text/javascript\">window.location='/'</script></body></html>";
                exit;
            }
            else {
                $age = $row[0];
                
                if ($age > 15) {
                    $query = "UPDATE LoginSession SET LOGGED_OUT = 1 WHERE ID = '" . $session_id . "'";
                    $db->query($query);
                    
                   
                    
                    echo "<html><body><script type=\"text/javascript\">window.location='home.html'</script></body></html>";

                    exit;    
                }
                else {
                    $query = "UPDATE LoginSession SET UPDATED_ON = CURRENT_TIMESTAMP() WHERE ID = '" . $session_id . "'";
                   $db->query($query);
                    
                   
                }
            }
        }
      
        public function isAdmin()
            {
                 $user = Zend_Auth::getInstance()->getIdentity();   
				 // Modified by MiconJ 8/8/2012
                 //if(($user['MALL_ID']==NULL || strlen($user['MALL_ID']) == 0) && ($user['REAL_ESTATE_ID']==NULL || strlen($user['REAL_ESTATE_ID']) == 0))
				 if($user['ACCOUNT_TYPE']==0){
                    return true;
                 }else{
                    return false;}
            }
        public function clearDir($directory,  $empty = false) { 
          if (substr($directory,-1) == "/") { 
              $directory = substr($directory,0,-1); 
          } 
    
          if (!file_exists($directory) || !is_dir($directory)) { 
              return false; 
          } 
          elseif (!is_readable($directory)) { 
              return false; 
          } 
          else { 
              $directoryHandle = opendir($directory); 
            
              while ($contents = readdir($directoryHandle)) { 
                  if ($contents != '.' && $contents != '..') { 
                      $path = $directory . "/" . $contents; 
                    
                      if (is_dir($path)) { 
                          clearDir($path); 
                      } 
                      else { 
                          unlink($path); 
                      } 
                  } 
              } 
            
             if ($empty == false) { 
                 if (!rmdir($directory)) { 
                     return false; 
                 } 
             } 
    
             closedir($directoryHandle); 
     
             return true; 
          } 
    } 
  }
?>