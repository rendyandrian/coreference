<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class GroupController extends BaseController {
	protected $success = true;
	protected $message = '';
	protected $entity  = 'group';
	protected $entityId  = 'group_id';


	protected function getModel() {
		return $this->group;
	}

	protected function getEntityId() {
		return $this->entityId;
	}
}
?>
