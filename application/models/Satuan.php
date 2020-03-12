<?php
	require_once 'BaseModel.php';
	class Satuan extends BaseModel {

		public function __construct(){
			$this->table = parent::$tableSatuan;
			parent::__construct($this->table);
		}

		public function getSatuanByKodeSatuan($kodeSatuan) {
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('kode_satuan',$kodeSatuan);
			$result = $this->db->get();
			return $result->first_row();
		}
	}

?>