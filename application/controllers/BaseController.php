<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $route = $this->uri->segment(1);
        $this->authPageException($route);
        
    }

	private function authPageException($route) {
        
        $isUserLoggedIn = $this->session->has_userdata(KEY_USER);        
        
        if($isUserLoggedIn && $route=="login") {
            redirect('/');
        } else if(!$isUserLoggedIn 
            && $route != "login" 
            && $route != "authenticate"){
            redirect('/login');
        }
    }
    
    public function tableMapping($dataPost,$parentTable){
        function getValue($column)
		{
            return $column['COLUMN_NAME'];
		}
		
		$resultColumn = $this->getModel()->getColumnName($parentTable);
        $parentColumn = array_map('getValue', $resultColumn);
        
		$dataResult = [];
		foreach ($dataPost as $keyDataPost => $valueDataPost) {
            if(in_array($keyDataPost,$parentColumn)){
                $dataResult[$keyDataPost] = $valueDataPost;
            }else{
                $dataResult['child_data'][$keyDataPost] = $valueDataPost;
                if (strpos($keyDataPost, '_id') !== false) {
                    $idChildTable = $keyDataPost;
                }
            }
        }

        //opsi 1 : str_replace
        $childTable = str_replace('_id','',$idChildTable);
        $dataResult['child_table'] = $childTable;
        
        //opsi 2 : query
        // $childTable = $this->getModel()->getTableName($idChildTable);
        // $dataResult['child_table'] = $childTable->TABLE_NAME;
        
        return $dataResult;
    }
    
    public function createResponse($success,$message,$key,$data) {
		$response['success'] = $this->success;
        $response['message'] = $this->message;
        $this->session->set_flashdata(KEY_STATUS, $this->success);
        $this->session->set_flashdata(KEY_MESSAGE, $message);
        if($key){
            $response[$key]     =  $data;
        }

        return (object) $response;
	}

    public function index()
    {
        $authStatus = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);

        $data = $this->getModel()->all();
        // echo $this->db->last_query();die();
        $data = [
            'alertStatus' => $authStatus,
            'alertMessage' => $authMessage,
            $this->entity.'s' => $data
        ];
        return view ($this->entity.'.index',$data);
    }
    
    public function add_get() {
        $authStatus = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);

        $data = [
            'alertStatus' => $authStatus,
            'alertMessage' => $authMessage
        ];

        return view ($this->entity.'.add', $data);  
    }

    public function add_post() {
        $this->message = "Data successfully entered.";
        $data = new stdClass();
        $entityId = $this->entityId;

        $dataPost = $this->input->post();
        $data->$entityId = $this->getModel()->insert($dataPost);
        
        if(!$data->$entityId){
            $this->success = false;
            $this->message = 'Data failed to be entered';
            $data = '';
        }

        $response = $this->createResponse($this->success,$this->message,$this->entity,$data);
        
        if($response->success){
            redirect($this->entity);
        }
        else{
            redirect($this->entity.'/add');
        }
    }

    public function edit_get($id) {
        $authStatus = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);

        $data = $this->getModel()->find($id);

        $data = [
            'alertStatus' => $authStatus,
            'alertMessage' => $authMessage,
            $this->entity => $data
        ];

        return view ($this->entity.'.edit', $data); 
    }
    
    public function edit_post($id) {
        $this->message = "Data successfully updated.";
        $data = new stdClass();
        $entityId = $this->entityId;

        $dataPost = $this->input->post();
        $data->$entityId = $this->getModel()->update($dataPost,$id);

        if($data->$entityId < 0){
            $this->success = false;
            $this->message = 'Data failed to be update';
            $data = '';
        }else{
            $data = (object) $dataPost;
        }

        $response = $this->createResponse($this->success,$this->message,$this->entity,$data);
        if($response->success){
            redirect($this->entity);
        }
        else{
            redirect($this->entity.'/'.$id.'/edit');
        }
    }
    
    public function show($id){
        $authStatus = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);

        $data = $this->getModel()->find($id);
        
        $data = [
            'alertStatus' => $authStatus,
            'alertMessage' => $authMessage,
            $this->entity => $data
        ];
        
        return view ($this->entity.'.show', $data); 
	}
    
    public function deactivate($id){
        $this->message = 'Data successfully deleted';
        $authStatus = $this->session->flashdata(KEY_STATUS);
        $authMessage = $this->session->flashdata(KEY_MESSAGE);

        $dataPost = ['status_aktif' => 0];
        $data = $this->getModel()->update($dataPost,$id);

        
        if($data < 0){
            $this->success = false;
            $this->message = 'Data failed to be delete';
            $data = '';
        }else{
            $data = (object) $dataPost;
        }

        $response = $this->createResponse($this->success,$this->message,$this->entity,$data);
        
        redirect($this->entity);
	}

    public function delete($id) {
        $this->message = "Data successfully deleted.";
        $data = $this->getModel()->delete($id); 
        
        if(!$data){
            $this->success = false;
            $this->message = "Data failed to delete.";
        }
        
        $response = $this->createResponse($this->success,$this->message,$this->entity,$data);
        redirect($this->entity);
    }
  
    public function do_upload($files, $path)
    {
        $data = array();
        
        $now = date('dmYHis');
        $path = './uploads/'.$path;
        
        $config = $this->configFileUploads($path);
        if(count($files) > 0){
            foreach ($files as $key => $value) {
                if($value['name']!="") {
                    $fileName = $value['name'];
                    $config['file_name'] = $fileName;
                    
                    $this->upload->initialize($config);
                    
                    if ( ! $this->upload->do_upload($key))
                    {   
                        $data[$key]['success'] = false;
                        $data[$key]['message'] = strip_tags($this->upload->display_errors());
                    }
                    else
                    {
                        $data[$key]['success'] = true;
                        $data[$key]['photo'] = $fileName;
                    }
                }
            }
        }
        
        return $data;
    }

    public function isSuperadmin() {
        $userSess = $this->session->{KEY_USER};
        return ($userSess['group']->group_id == GROUP_SUPERADMIN || $userSess['group']->group_id == GROUP_MABES) ? true : false;
    }

}
