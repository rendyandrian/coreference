<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class LoginController extends BaseController {
	protected $message = '';
	protected $success = true;
	protected $entity  = 'user';

	public function __construct()
    	{	
        parent::__construct();
        $this->load->helper('form');
	}
	
	public function index()
	{
		$authStatus = $this->session->flashdata(KEY_STATUS);
		$authMessage = $this->session->flashdata(KEY_MESSAGE);
		
		$data = [
			'alert-status' => $authStatus,
			'alert-message' => $authMessage
		];
		
		return view ('login',['data' => $data]);
	}

	
	public function authenticate() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			$authResponse = $this->login_post($username,$password);
			if($authResponse->success) {
				$user = $authResponse->user;
				$this->session->set_userdata(KEY_USER, $user);
				$this->session->set_flashdata(KEY_STATUS, VALUE_STATUS_SUCCESS);
				redirect('/');
			} else {
				$this->session->set_flashdata(KEY_STATUS, VALUE_STATUS_FAILED);
				$this->session->set_flashdata(KEY_MESSAGE, $authResponse->message);
				$data =[
					'auth' => 'Username atau Password Salah'
				];
				return view ('login', $data);	
			}
		} else {
			redirect('login');
		}
	}

	public function logout() {
		$this->getModel()->destroyToken($userid=2);
		$this->session->sess_destroy();
		redirect('login');
	}
	
	
	public function login_post($username='',$password=''){
		$data = [];
		if(strlen($password) < 8){
			$this->success = false;
			$this->message = "Gagal melakukan autentifikasi.";
		}
		
		$result = $this->getModel()->auth($username,$password);

		if(($result && !empty($result['token']))){
			$data['personel'] = $this->personel->getPersonelByUserId($result['user_id']);
			$data['satuan'] 	= $this->satuan->getSatuanByKodeSatuan($result['kode_satuan']);
			$data['group'] 	= $this->group->getGroupByGroupId($result['user_id']);

			$this->message = "Berhasil melakukan autentifikasi.";
		}else{
			$this->success = false;
			$this->message = "Gagal melakukan autentifikasi.";
		}

		$response = $this->createResponse($this->success,$this->message,$this->entity,$data);

		return $response;
	}

	protected function getModel() {
		return $this->user;
	}
}
