<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class RuangRapatController extends BaseController {
	protected $success = true;
	protected $message = '';
	protected $entity  = 'ruangRapat';
	protected $entityId  = 'ruang_rapat_id';

	protected function configFileUploads($path){
		//cek directory
		if(!is_dir($path)){
			mkdir($path, 0775, TRUE);
		}
		
		//config image
		$config['upload_path'] 		= $path;
		$config['allowed_types'] 	= 'jpeg|gif|jpg|png|pdf';
		$config['max_size']     	= '1024';
		$config['overwrite'] 		= TRUE;
		
		return $config;
    	}

	public function getRuangRapat(){
		header("Content-type:application/json");
		$data = $this->getModel()->all();
		echo json_encode($data);
	}

	protected function getModel() {
		return $this->ruangRapat;
	}

	protected function getEntityId() {
		return $this->entityId;
	}
}
?>
