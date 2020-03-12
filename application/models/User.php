<?php
	require_once 'BaseModel.php';
	class User extends BaseModel {

		public function __construct(){
			$this->table = parent::$tableUser;
			parent::__construct($this->table);
		}
		
		public function all(){
			$this->db->select('usr.user_id');
			$this->db->select('usr.username');
			$this->db->select('usr.group_id');
			$this->db->select('usr.kode_satuan');
			$this->db->select('usr.created_at');
			$this->db->select('psl.nrp');
			$this->db->select('psl.name');
			$this->db->from($this->table.' usr');
			$this->db->join('personel psl','psl.user_id=usr.user_id','LEFT');
			$query = $this->db->get();
			
			return $query->result();
		}

		public function find($id){
			$this->db->select('usr.user_id');
			$this->db->select('usr.username');
			$this->db->select('usr.group_id');
			$this->db->select('usr.kode_satuan');
			$this->db->select('usr.created_at');
			$this->db->select('psl.personel_id');
			$this->db->select('psl.nrp');
			$this->db->select('psl.name');
			$this->db->from($this->table.' usr');
			$this->db->join('personel psl','psl.user_id=usr.user_id','LEFT');
			$this->db->where('usr.user_id',$id);
			$query = $this->db->get();
			
			return $query->first_row();
		}
		public function insert($data) {
			$insertIdUser = '';
			$insertIdPersonel = '';
			$dataChildTable = $data['child_data'];
			$childTable = $data['child_table'];
			unset($data['child_table']);
			unset($data['child_data']);
			$dataUser = $data;

			$this->db->insert($this->table, $dataUser);
			$insertIdUser = $this->db->insert_id();
			if($insertIdUser){
				unset($dataChildTable[$childTable.'_id']);
				$dataChildTable[$this->table.'_id'] = $insertIdUser;
				$insertIdPersonel = $this->$childTable->insert($dataChildTable);
			}
			
			return [$insertIdUser,$insertIdPersonel];	
		}

		public function auth($username,$password){
			$this->createToken($username,$password);
			
			$this->db->select('user_id');
			$this->db->select('group_id');
			$this->db->select('kode_satuan');
			$this->db->select('token');
			$this->db->from($this->table);
			$this->db->where('username',$username);
			$this->db->where('password',$password);
			$query = $this->db->get();
			
			return $query->row_array();
		}
		
		public function createToken($username,$password){
			$randomInt 		= mt_rand(1000,9999);
			$permitted_chars 	= '0123456789abcdefghijklmnopqrstuvwxyz'.$randomInt;
			$data['token'] 	= substr(str_shuffle($permitted_chars), 0, 20);
			
			$this->db->where('username',$username);
			$this->db->where('password',$password);

			$data = $this->db->update($this->table,$data);
		}

		public function destroyToken($userid){
			$data['token'] 	= '';
			
			$this->db->where('user_id',$userid);
			
			$data = $this->db->update($this->table,$data);
		}

	}

?>