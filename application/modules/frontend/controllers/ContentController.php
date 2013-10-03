<?php

class ContentController extends App_Controller_Action
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
		$modelcontent=new Model_content();
		$data['mall_list']=$modelcontent->getMallList("", 0);
		$this->view->data=$data;
    }
    
	public function getcontentdataAction()
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

			$content_model= new Model_content();
			$result=''; 
			$resultCnt = 0;
			
			switch($status){
			case 'event':
				$resultCnt = $content_model->getAllEvents(1, array("field"=> $req_filterfield, "value" => $req_filtervalue));
				$req_pagenum--;
				if($resultCnt < $req_pagenum * $req_cntperpage + 1) {
                       $req_pagenum = floor(($resultCnt - 1) / $req_cntperpage);
                }
				$result=$content_model->getAllEvents( 0, array("field"=> $req_filterfield, "value" => $req_filtervalue), $req_cntperpage, $req_pagenum * $req_cntperpage, array("field"=>$req_sortfield, "mode"=>$req_sortmode));
				$req_pagenum++;
				//$result=$content_model->getAllEvents(25,0,0);     
				break;
			case 'job':
				$resultCnt = $content_model->getAllJobs(1, array("field"=> $req_filterfield, "value" => $req_filtervalue));
				$req_pagenum--;
				if($resultCnt < $req_pagenum * $req_cntperpage + 1) {
                       $req_pagenum = floor(($resultCnt - 1) / $req_cntperpage);
                }
				$result=$content_model->getAllJobs( 0, array("field"=> $req_filterfield, "value" => $req_filtervalue), $req_cntperpage, $req_pagenum * $req_cntperpage, array("field"=>$req_sortfield, "mode"=>$req_sortmode));
				$req_pagenum++;
				//$result=$content_model->getAllJobs(25, 0,0,2);
				break;
			}
			echo json_encode(array("totalcnt"=>$resultCnt, "curpage"=> $req_pagenum, "result"=>$result));
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
    public function addcontentAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		if($this->getRequest()->isXmlHttpRequest()){
			$post_data=$this->getRequest()->getPost();
			//$post_data=$this->getRequest()->getParams();
			$content_model= new Model_content(); 
			if(array_key_exists('job_mall', $post_data)){
				echo $content_model->addNewJob($post_data); 
			}elseif(array_key_exists('event_mall', $post_data)){
				echo $content_model->addNewEvent($post_data); 
			}
		} 
		exit;
	}
	public function uploadeventimageAction() {
		$this->_helper->viewRenderer->setNoRender();
		$upload_relative_path = '/tempfiles/';
		$uploaddir = $_SERVER['DOCUMENT_ROOT'].$upload_relative_path;
		
		$codeprocess = $data['code_process'] = date('YmdHisu');
		if (isset($_GET['qqfile'])):
			$uploadedfile = $_GET['qqfile'];
			$size =  $_SERVER["CONTENT_LENGTH"];
			if($size > 104400000):
				$response = array('error'=> 'File is too large, maximum file size is 100.0MB');
				//echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
			else:
				$typeuploadedfile = strtolower(substr(strrchr($uploadedfile,"."),1));
				$processfile = $codeprocess."_".$this->rand_string(5).'.'.$typeuploadedfile;
				if ($this->save($uploaddir.$processfile)):
					//$size = filesize($uploaddir.$uploadedfile);
					//$typeuploadedfile = strtolower(substr(strrchr($uploadedfile,"."),1));
					//$processfile = $codeprocess."_".$this->rand_string(5).'.'.$typeuploadedfile;			
					//copy($uploaddir.$uploadedfile, $uploaddir.$processfile);
					//unlink($uploaddir.$uploadedfile); 
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
				//echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
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
	function rand_string( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
		$size = strlen( $chars );
		$str = "";
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}
		return $str;
	}
}

