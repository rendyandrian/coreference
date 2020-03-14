<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class InboxController extends BaseController {
	protected $success = true;
	protected $message = '';
	protected $entity  = 'inbox';
	protected $entityId  = 'inbox_id';


	protected function getModel() {
		return $this->inbox;
	}

	protected function getEntityId() {
		return $this->entityId;
	}
	public function index()
    {
		$userData = $this->session->{KEY_USER};
		$userId = $userData['personel']->user_id;
		$kodeSatuan = $userData['satuan']->kode_satuan;
		
        $authStatus = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);
        return view ($this->entity.'.index');
    }
	public function anotasi($id){
		header("Content-type:application/json");
		$getArab = $this->getModel()->showAllArabBySurat($id);	
		echo json_encode($getArab);
	}	
}
?>
