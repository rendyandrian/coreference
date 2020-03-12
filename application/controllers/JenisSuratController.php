<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class JenisSuratController extends BaseController {
	protected $success = true;
	protected $message = '';
	protected $entity  = 'jenisSurat';
	protected $entityId  = 'jenis_surat_id';


	protected function getModel() {
		return $this->jenisSurat;
	}

	protected function getEntityId() {
		return $this->entityId;
	}
}
?>
