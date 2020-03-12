<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class TembusanController extends BaseController {
	protected $success = true;
	protected $message = '';
	protected $entity  = 'tembusan';
	protected $entityId  = 'tembusan_id';

	public function __construct()
    	{	
        parent::__construct();
        $this->load->helper('form');
	}

	protected function getModel() {
		return $this->tembusan;
	}

	protected function getEntityId() {
		return $this->entityId;
	}
}
