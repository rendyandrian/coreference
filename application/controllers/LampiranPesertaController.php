<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class LampiranPesertaController extends BaseController {
	protected $success = true;
	protected $message = '';
	protected $entity  = 'lampiranPeserta';
	protected $entityId  = 'lampiran_peserta_id';


	protected function getModel() {
		return $this->lampiranPeserta;
	}

	protected function getEntityId() {
		return $this->entityId;
	}
}
?>
