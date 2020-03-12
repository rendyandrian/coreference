<?php
	require_once 'BaseModel.php';
	class Personel extends BaseModel {

		public function __construct(){
			$this->table = parent::$tablePersonel;
			parent::__construct($this->table);
		}

		public function getPersonelByUserId($userId) {
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('user_id',$userId);
			$result = $this->db->get();
			return $result->first_row();
		}
	}

?>