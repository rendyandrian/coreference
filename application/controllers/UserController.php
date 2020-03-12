<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class UserController extends BaseController {
	protected $success = true;
	protected $message = '';
	protected $entity  = 'user';
	protected $entityId  = 'user_id';

	public function __construct()
    	{	
        parent::__construct();
        $this->load->helper('form');
	}

	
	public function index()
	{
		$authStatus = $this->session->flashdata(KEY_STATUS);
		$authMessage = $this->session->flashdata(KEY_MESSAGE);
		
		$resultQuery = $this->getModel()->all();
		
		$users = $this->getUserAttribut($resultQuery);
		$data = [
			'alert-status' => $authStatus,
			'alert-message' => $authMessage,
			'users' => $users
		];

		return view ('user.index', $data);
	}

	public function edit_get($id) {
		$this->message = "User data.";
		
		$resultQuery = $this->getModel()->find($id);	
		$user = $this->getUserAttribut($resultQuery);

		$groups= $this->group->all();

		$data =[
			'user' => $user,
			'groups' => $groups
		];
		return view ('user.edit', $data);	
	}
	
	public function add_get() {
		$groups= $this->group->all();
		$data = [
			'groups' => $groups
		];
		return view ('user.add', $data);	
	}
	
	
	public function add_post() {
		$this->message = "Data successfully entered.";
		$data = new stdClass();
		$entityId = $this->entityId;
		$parentTable = 'user';
		
		$dataPost = (object) $this->input->post();

		$dataPost->password = md5($this->input->post('password'));
		
		$mappingResult = $this->tableMapping($dataPost,$parentTable);
		
		$dataInsert = $this->getModel()->insert($mappingResult);

		$userId = $dataInsert[0];
		$personelId = $dataInsert[1];
		$dataPost->$entityId = $userId;

		if(empty($userId) || empty($personelId)){
			$this->success = false;
			$delete = $this->delete($personelId);
			$delete->message = 'Data failed to be entered';
			return $delete;
		}
		
		$data = $this->getUserAttribut($dataPost);
		
		$response = $this->createResponse($this->success,$this->message,$this->entity,$data);

		if($response->success){
			redirect('user');
		}
		else{
			redirect('user/add');
		}
	}

	public function edit_post($id){
		$this->message = "Data successfully updated.";
		$data = new stdClass();
		$entityId = $this->entityId;
		$dataPost = (object) $this->input->post();
		$pageProfile=$dataPost->page_user;
		unset($dataPost->page_user);
		$password = $this->input->post('password');

		if($password==""){
			unset($dataPost->password);
		}
		else{
			$dataPost->password = md5($password);
		}
		$data->$entityId = $this->getModel()->update($dataPost,$id);
		
		if($data->$entityId < 0){
			$this->success = false;
			$this->message = 'Data failed to be update';
			$data = '';
		}else{
			$data = $this->getUserAttribut($dataPost);
		}

		$response = $this->createResponse($this->success,$this->message,$this->entity,$data);
		if(isset($pageProfile)){
			if($response->success){
				redirect('');
			}
			else{
				redirect('');
			}
		}else{
			if($response->success){
				redirect('user');
			}
			else{
				redirect('user');
			}
		}
	}
	
	public function delete($id){
		$this->message = "Data successfully deleted.";
		$this->entity = "";
		$data = $this->getModel()->delete($id);	
		
		if(!$data){
			$this->success = false;
			$this->message = "Data failed to delete.";
		}
		
		$response = $this->createResponse($this->success,$this->message,$this->entity,$data);
		if($response->success){
			redirect('user');
		}
		else{
			redirect('user');
		}
	}	

	public function getUserAttribut($resultQuery){
		//result query must consist of object
		if(is_array($resultQuery)){
			foreach ($resultQuery as $key => $value) {
				$resultQuery[$key]->group = $this->group->find($value->group_id);
				$resultQuery[$key]->satuan = $this->satuan->getSatuanByKodeSatuan($value->kode_satuan);
				unset($value->group_id);
				unset($value->kode_satuan);
			}
		}else{
				$resultQuery->group = $this->group->find($resultQuery->group_id);
				$resultQuery->satuan = $this->satuan->getSatuanByKodeSatuan($resultQuery->kode_satuan);
				unset($resultQuery->group_id);
				unset($resultQuery->kode_satuan);
		}
		return $resultQuery;
	}

	public function profile()
	{  
		
		$authStatus = $this->session->flashdata(KEY_STATUS);
		$authMessage = $this->session->flashdata(KEY_MESSAGE);
		$userData = $this->session->{KEY_USER};
		$userId = $userData['personel']->user_id;
		$this->message = "User data.";
		
		$resultQuery = $this->getModel()->find($userId);	
		$user = $this->getUserAttribut($resultQuery);

		$groups= $this->group->all();

		$data =[
			'user' => $user,
			'groups' => $groups
		];
		return view ('user.profile', $data);
	}
	protected function getModel() {
		return $this->user;
	}

	protected function getEntityId() {
		return $this->entityId;
	}
}
