<?php
class AccountController extends App_Controller_Action
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
            $account_model= new Model_DbTable_Account();
          $data['account_status']=$account_model->countAll();
          $data['menu_active']='account'; 
          $this->view->data=$data;  
        }
    public function viewAction()
        {
            $user = Zend_Auth::getInstance()->getIdentity();
         $data['user_data']=$user; 
            $id= $this->getRequest ()->getParam ( 'id', null );
            $account_model= new Model_DbTable_Account();
            $data=$account_model->getAccountAllInfo($id);
            $data['mall_list']=$account_model->getStoreListByMallId($data['MALL_ID']);
             $data['menu_active']='account';
          
             $this->view->data=$data;
        }
    public function realestateAction()
        {
          
          $user = Zend_Auth::getInstance()->getIdentity();
          $data['user_data']=$user; 
            $id= $this->getRequest ()->getParam ( 'id', null );
            $account_model= new Model_DbTable_Account();
            $data=$account_model->getRealEstateInfo($id);
            $data['mall_list']=$account_model->getMallListByRealestateId($id);
             $data['menu_active']='account';   
             $this->view->data=$data;  
        }
    public function addaccountAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		if($this->getRequest()->isXmlHttpRequest()){
			$post_data=$this->getRequest()->getPost();
			//$post_data=$this->getRequest()->getParams();
			$account_model= new Model_DbTable_Account(); 
			if(array_key_exists('real_name', $post_data)){
				echo $account_model->addNewRealEstate($post_data); 
			}elseif(array_key_exists('mall_name', $post_data)){
				echo $account_model->addNewMall($post_data); 
			}elseif(array_key_exists('vendor_name', $post_data)){
				echo $account_model->addNewVendor($post_data); 
			}elseif(array_key_exists('store_vendor', $post_data)){
				echo $account_model->addNewStore($post_data); 
			}
		} 
		exit;
	}
    public function getaccountdataAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        
        if($this->getRequest()->isXmlHttpRequest()){
                       
            $status=$this->_request->getPost('status');
            $req_pagenum = $this->_request->getPost('pagenum');
            $req_cntperpage = $this->_request->getPost('cntperpage');
            $req_sortfield = $this->_request->getPost('sortfield');
            $req_sortmode = $this->_request->getPost('sortmode');
            $req_filterfield = $this->_request->getPost('filterfield');
            $req_filtervalue = $this->_request->getPost('filtervalue');
            
            $account_model= new Model_DbTable_Account();
            $result='';
            switch($status){
                case 'all':
                    
                    $resultCnt = $account_model->getAll(1, array("field"=> $req_filterfield, "value" => $req_filtervalue));
                    
                    $req_pagenum--;
                    if($resultCnt < $req_pagenum * $req_cntperpage + 1) {
                        $req_pagenum = floor(($resultCnt - 1) / $req_cntperpage);
                    }
                    $result=$account_model->getAll( 0, array("field"=> $req_filterfield, "value" => $req_filtervalue), $req_cntperpage, $req_pagenum * $req_cntperpage, array("field"=>$req_sortfield, "mode"=>$req_sortmode));
                    $req_pagenum++;
                    break;
                case 'active':
                    $resultCnt = $account_model->getActive(1, array("field"=> $req_filterfield, "value" => $req_filtervalue));
                    $req_pagenum--;
                    if($resultCnt < ($req_pagenum - 1) * $req_cntperpage + 1) {
                        $req_pagenum = floor(($resultCnt - 1) / $req_cntperpage);
                    }
                    $result=$account_model->getActive( 0, array("field"=> $req_filterfield, "value" => $req_filtervalue), $req_cntperpage, $req_pagenum * $req_cntperpage, array("field"=>$req_sortfield, "mode"=>$req_sortmode));
                    $req_pagenum++;
                    break;
                case 'activate':
                    $resultCnt = $account_model->getActivate(1, array("field"=> $req_filterfield, "value" => $req_filtervalue));
                    $req_pagenum--;
                    if($resultCnt < ($req_pagenum - 1) * $req_cntperpage + 1) {
                        $req_pagenum = floor(($resultCnt - 1) / $req_cntperpage);
                    }
                    $result=$account_model->getActivate( 0, array("field"=> $req_filterfield, "value" => $req_filtervalue), $req_cntperpage, $req_pagenum * $req_cntperpage, array("field"=>$req_sortfield, "mode"=>$req_sortmode));
                    $req_pagenum++;
                    break;
                case 'pending':
                    $resultCnt = $account_model->getPending(1, array("field"=> $req_filterfield, "value" => $req_filtervalue));
                    $req_pagenum--;
                    if($resultCnt < ($req_pagenum - 1) * $req_cntperpage + 1) {
                        $req_pagenum = floor(($resultCnt - 1) / $req_cntperpage);
                    }
                    $result=$account_model->getPending( 0, array("field"=> $req_filterfield, "value" => $req_filtervalue), $req_cntperpage, $req_pagenum * $req_cntperpage, array("field"=>$req_sortfield, "mode"=>$req_sortmode));
                    $req_pagenum++;
                    break;
                case 'realestate':
                    $resultCnt = $account_model->getRealState(1, array("field"=> $req_filterfield, "value" => $req_filtervalue));
                    
                    $req_pagenum--;
                    if($resultCnt < ($req_pagenum - 1) * $req_cntperpage + 1) {
                        $req_pagenum = floor(($resultCnt - 1) / $req_cntperpage);
                    }
                    $result=$account_model->getRealState( 0, array("field"=> $req_filterfield, "value" => $req_filtervalue), $req_cntperpage, $req_pagenum * $req_cntperpage, array("field"=>$req_sortfield, "mode"=>$req_sortmode));
                    $req_pagenum++;
                    break;
                case 'mall':
                    $resultCnt = $account_model->getMall(1, array("field"=> $req_filterfield, "value" => $req_filtervalue));
                    $req_pagenum--;
                    if($resultCnt < ($req_pagenum - 1) * $req_cntperpage + 1) {
                        $req_pagenum = floor(($resultCnt - 1) / $req_cntperpage);
                    }
                    $result=$account_model->getMall( 0, array("field"=> $req_filterfield, "value" => $req_filtervalue), $req_cntperpage, $req_pagenum * $req_cntperpage, array("field"=>$req_sortfield, "mode"=>$req_sortmode));
                    $req_pagenum++;
                    break;
                case 'vendor':
                    $resultCnt = $account_model->getVendor(1, array("field"=> $req_filterfield, "value" => $req_filtervalue));
                    $req_pagenum--;
                    if($resultCnt < ($req_pagenum - 1) * $req_cntperpage + 1) {
                        $req_pagenum = floor(($resultCnt - 1) / $req_cntperpage);
                    }
                    $result=$account_model->getVendor( 0, array("field"=> $req_filterfield, "value" => $req_filtervalue), $req_cntperpage, $req_pagenum * $req_cntperpage, array("field"=>$req_sortfield, "mode"=>$req_sortmode));
                    $req_pagenum++;
                    break;
                case 'store':
                    $resultCnt = $account_model->getStore(1, array("field"=> $req_filterfield, "value" => $req_filtervalue));
                    $req_pagenum--;
                    if($resultCnt < ($req_pagenum - 1) * $req_cntperpage + 1) {
                        $req_pagenum = floor(($resultCnt - 1) / $req_cntperpage);
                    }
                    $result=$account_model->getStore( 0, array("field"=> $req_filterfield, "value" => $req_filtervalue), $req_cntperpage, $req_pagenum * $req_cntperpage, array("field"=>$req_sortfield, "mode"=>$req_sortmode));
                    $req_pagenum++;
                    break;
            }
            
            echo json_encode(array("totalcnt"=>$resultCnt, "curpage"=> $req_pagenum, "result"=>$result));
            exit;    
            }
            
        }
     public function deleteAction()
        {
            $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
              $account_model= new Model_DbTable_Account();  
              $accountId= $this->_request->getPost('id');
              if($account_model->deleteAccountById($accountId))
              echo "Successfully Deleted";
              else
                echo "There is an error while deleting record"; 
            }
            
        }
     public function realdeleteAction()
        {
            $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
              $account_model= new Model_DbTable_Account();  
              $realId= $this->_request->getPost('id');
              if($account_model->deleteRealEsate($realId))
              echo "Successfully Deleted";
              else
                echo "There is an error while deleting record"; 
            }
            
        }
     
     public function malldeleteAction()
        {
            $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
              $account_model= new Model_DbTable_Account();  
              $realId= $this->_request->getPost('id');
              if($account_model->deleteMallById($realId))
              echo "Successfully Deleted";
              else
                echo "There is an error while deleting record"; 
            }
            
        }
     public function userdeleteAction()
        {
            $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
              $account_model= new Model_DbTable_User();  
              $realId= $this->_request->getPost('id');
              if($account_model->deleteUserById($realId))
              echo "Successfully Deleted";
              else
                echo "There is an error while deleting record"; 
            }
            
        }
     public function contentdeleteAction()
        {
            $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
              $account_model= new Model_content();  
              $realId= $this->_request->getPost('id');
              if($account_model->deleteContentById($realId))
              echo "Successfully Deleted";
              else
                echo "There is an error while deleting record"; 
            }
            
        }
     public function jobdeleteAction()
        {
            $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
              $account_model= new Model_content();  
              $realId= $this->_request->getPost('id');
              if($account_model->deleteJobById($realId))
              echo "Successfully Deleted";
              else
                echo "There is an error while deleting record"; 
            }
            
        }
     
      public function storedeleteAction()
        {
            $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
              $account_model= new Model_DbTable_Account();  
              $realId= $this->_request->getPost('id');
              if($account_model->deleteStoreById($realId))
              echo "Successfully Deleted";
              else
                echo "There is an error while deleting record"; 
            }
            
        }
        
       public function vendordeleteAction()
        {
            $this->_helper->viewRenderer->setNoRender();
            if($this->getRequest()->isXmlHttpRequest()){
              $account_model= new Model_DbTable_Account();  
              $realId= $this->_request->getPost('id');
              if($account_model->deleteVendorById($realId))
              echo "Successfully Deleted";
              else
                echo "There is an error while deleting record"; 
            }
            
        }  
     public function deleteconfirmAction()
        {
            if($this->getRequest()->isXmlHttpRequest()){
                $this->view->assign(array('div' => $this->_request->getPost('div'),
                 'id' => $this->_request->getPost('id'),
                 'fn'=>$this->_request->getPost('fn')));
                echo $this->view->render('partial/deleteconfirm.phtml');
                exit;
            }
            
    }
        
    public function grid ($id = '')
    {
        $view = new Zend_View();
        $view->setEncoding('ISO-8859-1');
        $config = new Zend_Config_Ini('../../../grids/grid.ini', 'production');
        $grid = Bvb_Grid::factory('Table', $config, $id);
        $grid->setEscapeOutput(false);
        $grid->setExport(array('pdf', 'csv','excel','wordx'));
        $grid->setView($view);
        #$grid->saveParamsInSession(true);
        #$grid->setCache(array('use' => array('form'=>false,'db'=>false), 'instance' => Zend_Registry::get('cache'), 'tag' => 'grid'));
        return $grid;
    }
	public function uploadvendorlogoAction() {
		$this->_helper->viewRenderer->setNoRender();
		$upload_relative_path = '/tempfiles/';
		$uploaddir = $_SERVER['DOCUMENT_ROOT'].$upload_relative_path;
		
		$codeprocess = $data['code_process'] = date('YmdHis');
		if (isset($_GET['qqfile'])):
			$uploadedfile = $_GET['qqfile'];
			$size =  $_SERVER["CONTENT_LENGTH"];
			if($size > 104400000):
				$response = array('error'=> 'File is too large, maximum file size is 100.0MB');
				echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
			else:
				if ($this->save($uploaddir.$uploadedfile)):
					$size = filesize($uploaddir.$uploadedfile);
					$typeuploadedfile = strtolower(substr(strrchr($uploadedfile,"."),1));
					$processfile = $codeprocess.'.'.$typeuploadedfile;			
					copy($uploaddir.$uploadedfile, $uploaddir.$processfile);
					unlink($uploaddir.$uploadedfile);
					$response = array('success'=>true, 'filename'=>$processfile);
					echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
				else:
					$response = array('error'=> 'Could not save uploaded file');
					echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
				endif;
			endif;
		elseif (isset($_FILES['qqfile'])):
			$uploadedfile = $_FILES['qqfile']['name'];
			$size =  $_FILES['qqfile']['size'];
			if($size > 10440000):
				$response = array('error'=> 'File is too large, maximum file size is 10.0MB');
				echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
			else:
				if (move_uploaded_file($_FILES['qqfile']['tmp_name'], $uploaddir.$uploadedfile)):
					$typeuploadedfile = strtolower(substr(strrchr($uploadedfile,"."),1));
					$processfile = $codeprocess.'.'.$typeuploadedfile;			
					if(copy($uploaddir.$uploadedfile, $uploaddir.$processfile)):
						unlink($uploaddir.$uploadedfile);
					endif;
					//$session->setFileProcess($processfile);
					$response = array('success'=>true, 'filename'=>$processfile);
					echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
				else:
					$response = array('error'=> 'Could not save uploaded file');
					echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
				endif;
			endif;
		endif;
		exit;
	}
	function save($path) {
		$input = fopen("php://input", "r");
		$temp = tmpfile();
		$realSize = stream_copy_to_stream($input, $temp);
		fclose($input);
		$target = fopen($path, "w");
		fseek($temp, 0, SEEK_SET);
		stream_copy_to_stream($temp, $target);
		fclose($target);
		return true;
	}
	
} 
?>
