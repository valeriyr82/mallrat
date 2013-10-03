<?php
class UsersController extends App_Controller_Action
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
            $user_model= new Model_DbTable_User();
          $data['user_status']=$user_model->countAll();
          $data['menu_active']='user'; 
          $this->view->data=$data;  
        }
    public function viewAction()
        {
             if($this->_request->getPost()){
                 echo $this->_request->getPost('id');
             }           
        }
	public function getuserdataAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		if($this->getRequest()->isXmlHttpRequest()){
			$status=$this->_request->getPost('status');
			$pagenum=$this->_request->getPost('pagenum');
			$cntperpage=$this->_request->getPost('cntperpage');
			$sortfield=$this->_request->getPost('sortfield');
			$sortmode=$this->_request->getPost('sortmode');
			$filterfield=$this->_request->getPost('filterfield');
			$filtervalue=$this->_request->getPost('filtervalue');

			$user_model= new Model_DbTable_User();
			$result=''; 
			$resultCnt = 0;
			switch($status){
			case 'all':
				//$result=$user_model->getUser(25,0,0);     
				$resultCnt=$user_model->getUser(0, 1, array("field"=> $filterfield, "value" => $filtervalue));
				$pagenum--;
				if($resultCnt < ($pagenum - 1) * $cntperpage + 1) {
					$req_pagenum = floor(($resultCnt - 1) / $cntperpage);
				}
				$result=$user_model->getUser(0,  0, array("field"=> $filterfield, "value" => $filtervalue), $cntperpage, $pagenum * $cntperpage, array("field"=>$sortfield, "mode"=>$sortmode));
				$pagenum++;
				break;
			case 'pending':
				//$result=$user_model->getUser(25,0,0,1);
				$resultCnt=$user_model->getUser(1, 1, array("field"=> $filterfield, "value" => $filtervalue));
				$pagenum--;
				if($resultCnt < ($pagenum - 1) * $cntperpage + 1) {
					$req_pagenum = floor(($resultCnt - 1) / $cntperpage);
				}
				$result=$user_model->getUser(1, 0, array("field"=> $filterfield, "value" => $filtervalue), $cntperpage, $pagenum * $cntperpage, array("field"=>$sortfield, "mode"=>$sortmode));
				$pagenum++;
				break;
			case 'mallrat':
				//$result=$user_model->getUser(25, 0,0,2);
				$resultCnt=$user_model->getUser(2, 1, array("field"=> $filterfield, "value" => $filtervalue));
				$pagenum--;
				if($resultCnt < ($pagenum - 1) * $cntperpage + 1) {
					$req_pagenum = floor(($resultCnt - 1) / $cntperpage);
				}
				$result=$user_model->getUser(2,  0, array("field"=> $filterfield, "value" => $filtervalue), $cntperpage, $pagenum * $cntperpage, array("field"=>$sortfield, "mode"=>$sortmode));
				$pagenum++;
				break;
			case 'realestate':
				$resultCnt=$user_model->getRealestate(1, array("field"=> $filterfield, "value" => $filtervalue));
				$pagenum--;
				if($resultCnt < ($pagenum - 1) * $cntperpage + 1) {
					$req_pagenum = floor(($resultCnt - 1) / $cntperpage);
				}
				$result=$user_model->getRealestate( 0, array("field"=> $filterfield, "value" => $filtervalue), $cntperpage, $pagenum * $cntperpage, array("field"=>$sortfield, "mode"=>$sortmode));
				$pagenum++;
				break;
			case 'mall':
				$resultCnt=$user_model->getMall(1, array("field"=> $filterfield, "value" => $filtervalue));
				$pagenum--;
				if($resultCnt < ($pagenum - 1) * $cntperpage + 1) {
					$req_pagenum = floor(($resultCnt - 1) / $cntperpage);
				}
				$result=$user_model->getMall( 0, array("field"=> $filterfield, "value" => $filtervalue), $cntperpage, $pagenum * $cntperpage, array("field"=>$sortfield, "mode"=>$sortmode));
				$pagenum++;
				break;
			case 'vendor':
				$resultCnt=$user_model->getVendor(1, array("field"=> $filterfield, "value" => $filtervalue));
				$pagenum--;
				if($resultCnt < ($pagenum - 1) * $cntperpage + 1) {
					$req_pagenum = floor(($resultCnt - 1) / $cntperpage);
				}
				$result=$user_model->getVendor( 0, array("field"=> $filterfield, "value" => $filtervalue), $cntperpage, $pagenum * $cntperpage, array("field"=>$sortfield, "mode"=>$sortmode));
				$pagenum++;
				break;
			case 'store':
				$resultCnt=$user_model->getStore(1, array("field"=> $filterfield, "value" => $filtervalue));
				$pagenum--;
				if($resultCnt < ($pagenum - 1) * $cntperpage + 1) {
					$req_pagenum = floor(($resultCnt - 1) / $cntperpage);
				}
				$result=$user_model->getStore( 0, array("field"=> $filterfield, "value" => $filtervalue), $cntperpage, $pagenum * $cntperpage, array("field"=>$sortfield, "mode"=>$sortmode));
				$pagenum++;
				break;
		}
		echo json_encode(array("totalcnt"=>$resultCnt, "curpage"=> $pagenum, "result"=>$result));
		exit; 
	}
            
        }
     public function profileAction()
        {
         
         $user = Zend_Auth::getInstance()->getIdentity();
         $user_model= new Model_DbTable_User(); 
           
         $data['user_data']=$user; 
         $data['member_list']=$user_model->getTeammemberList($user['ACCOUNT_ID']);
          $data['menu_active']='account';  
         $this->view->data=$data;       
        }
     public function adduserAction()
        {
          $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
             $user_model= new Model_DbTable_User();
             echo $user_model->addNewUser($this->getRequest()->getPost());
             exit;    
            }   
        }
	public function resendactivationmailAction() {
		$this->_helper->viewRenderer->setNoRender();
		if($this->getRequest()->isXmlHttpRequest()){
			$user_model= new Model_DbTable_User();
			echo $user_model->sendActivationMail($this->getRequest()->getPost());
			exit;
		}
	}
     public function updateprofileAction()
        {
            $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
                 $user = Zend_Auth::getInstance()->getIdentity(); 
               $status=$this->_request->getPost('profile_pass');
               $data=Array();
                $data['FIRST_NAME']= $this->_request->getPost('first_name');     
                $data['LAST_NAME']= $this->_request->getPost('last_name');  
                $data['EMAIL_ADDRESS']= $this->_request->getPost('email'); 
                $password= $this->_request->getPost('newpassword'); 
                $oldpassword= $this->_request->getPost('oldpassword'); 
                $id= $this->_request->getPost('id');   
                
            $user_model= new Model_DbTable_User();   
            $result=''; 
            switch($status){
                case 'profile':
                                if($user_model->checkUpdateEmail($data['EMAIL_ADDRESS'],$id))
                                    {  
                                      try{$user_model->updateUser($data,$id);
                                      $msg="Successfully Updated";
                                      $is_success=1;
                                      }catch( Exception $e){
                                         $msg=$e->getMessage();
                                         $is_success=0;   
                                      }        
                                    }
                             
                                break;
                 case 'pass':
                                if($user['PASSWORD']===hash('sha512', $oldpassword))
                                    {
                                    try{$user_model->updatePassword($id,$password);
                                      $msg="Successfully Updated";
                                      $is_success=1;  
                                      }catch( Exception $e){
                                         $msg=$e->getMessage(); 
                                         $is_success=0;  
                                      }        
                                    }
                                break;
                
                 
                
            }
            
            echo json_encode(array('success'=>$is_success,'msg'=>$msg));
            exit;    
            }
            
        }

} 
?>
