<?php

class CommonController extends App_Controller_Action
{

    private $utility;
    public function init()
    {
        /* Initialize action controller here */
        $this->utility=new Model_utility();
    }

    public function indexAction()
    {
        $user = Zend_Auth::getInstance()->getIdentity();
         $data['user_data']=$user; 
         $content_model= new Model_content();
          $data['content_status']=$content_model->countAll();
          $data['menu_active']='content'; 
          $account_model=new Model_DbTable_Account();
          $data['mall_list']=$account_model->getMall();
          $this->view->data=$data;
        
    }
    
     public function getcontentdataAction()
        {
            $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
              
               $status=$this->_request->getPost('status');
                      
                
            $content_model= new Model_content();
            $result=''; 
            switch($status){
                case 'event':
                              $result=$content_model->getAllEvents(25,0,0);     
                                break;
                 case 'job':
                              $result=$content_model->getAllJobs(25, 0,0,2);
                                break;
                
                 
            }
            echo json_encode($result);
            exit;    
            }
            
        }
     public function getstorelistforcomboAction()
        {
          $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
               $mallid=$this->_request->getPost('mallid');
                $model_content=new Model_content();
                $result=$model_content->getStoreListByMallId($mallid);
                echo json_encode($result);
            exit;
            }  
        }
	public function array_to_json( $array ){

		if( !is_array( $array ) ){
			return false;
		}

		$associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
		if( $associative ){

			$construct = array();
			foreach( $array as $key => $value ){

				// We first copy each key/value pair into a staging array,
				// formatting each key and value properly as we go.

				// Format the key:
				if( is_numeric($key) ){
					$key = "key_$key";
				}
				$key = "\"".addslashes($key)."\"";

				// Format the value:
				if( is_array( $value )){
					$value = array_to_json( $value );
				} else if( !is_numeric( $value ) || is_string( $value ) ){
					$value = "\"".addslashes($value)."\"";
				}

				// Add to staging array:
				$construct[] = "$key: $value";
			}

			// Then we collapse the staging array into the JSON form:
			$result = "{ " . implode( ", ", $construct ) . " }";

		} else { // If the array is a vector (not associative):

			$construct = array();
			foreach( $array as $value ){

				// Format the value:
				if( is_array( $value )){
					$value = $this->array_to_json( $value );
				} else if( !is_numeric( $value ) || is_string( $value ) ){
					$value = "'".addslashes($value)."'";
				}

				// Add to staging array:
				$construct[] = $value;
			}

			// Then we collapse the staging array into the JSON form:
			$result = "[ " . implode( ", ", $construct ) . " ]";
		}

		return $result;
	}
    public function getrealestatelistAction(){
		$this->_helper->viewRenderer->setNoRender();
		if($this->getRequest()->isXmlHttpRequest()){
			$keyword=$this->getRequest()->getParam('term');
			$model_content=new Model_content();
			$result=$model_content->getRealEstateList($keyword);
			echo $this->array_to_json($result);
		}
		exit;
	}
    public function getvendorlistAction(){
		//$invalid = array('\''=>'\\\'');
		$this->_helper->viewRenderer->setNoRender();
		if($this->getRequest()->isXmlHttpRequest()){
			$keyword=$this->getRequest()->getParam('term');
			$model_content=new Model_content();
			$result=$model_content->getVendorList($keyword);
			
			/*$rearranged_result = array();
			foreach ($result as $row) {
				array_push($rearranged_result, 
					array(
						"id"=>$row["id"], 
						"label"=>str_replace(array_keys($invalid), array_values($invalid),$row["label"]), 
						"value" => str_replace(array_keys($invalid), array_values($invalid),$row["value"])
					)
				);
			}*/
			echo json_encode($result);
		}
		exit;
	}
    public function getcategorylistAction(){
		$this->_helper->viewRenderer->setNoRender();
		if($this->getRequest()->isXmlHttpRequest()){
			$keyword=$this->getRequest()->getParam('term');
			$model_content=new Model_content();
			$result=$model_content->getCategoryList($keyword);
			echo json_encode($result);
		}
		exit;
	}
	public function getmallistAction(){
		$this->_helper->viewRenderer->setNoRender();
		if($this->getRequest()->isXmlHttpRequest()){
			$keyword=$this->getRequest()->getParam('term');
			$model_content=new Model_content();
			$result=$model_content->getMallList($keyword);
			echo json_encode($result);
		}
		exit;
	}
	public function getaccountlistAction(){
		$this->_helper->viewRenderer->setNoRender();
		if($this->getRequest()->isXmlHttpRequest()){
			$keyword=$this->getRequest()->getParam('term');
			$model_content=new Model_content();
			$result=$model_content->getAccountList($keyword);
			echo json_encode($result);
		}
		exit;
	}
	public function verifyAction() {
		$this->_helper->viewRenderer->setNoRender();
		$mailaddr=$this->getRequest()->getParam('email');
		$password=$this->getRequest()->getParam('hash');
		$model_content=new Model_content();
		$result=$model_content->activateUser($mailaddr, $password);
		echo "<!DOCTYPE html><html><title>Mall Rat activation</title><body>".$result."</body></html>";
		exit;
	}
}

