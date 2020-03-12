<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class PersonelController extends BaseController {
	protected $success = true;
	protected $message = '';
	protected $entity  = 'personel';
	protected $entityId  = 'personel_id';

	public function __construct()
    	{	
        parent::__construct();
        $this->load->helper('form');
	}
	
	public function personelByNRP_get($nrp){
		header('Content-Type: application/json');

		$endpoint = PERSONEL_BY_NRP.$nrp;
		$responseJson = $this->getModel()->http_get($endpoint);
		echo $responseJson;
	}

	protected function getModel() {
		return $this->personel;
	}

	protected function getEntityId() {
		return $this->entityId;
	}
}
