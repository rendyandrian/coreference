<?php
	require_once 'BaseModel.php';
	class Pejabat extends BaseModel {

		public function __construct(){
			$this->table = parent::$tablePejabat;
			parent::__construct($this->table);
		}
		
		public function getPejabatByJadwalRapat($jadwalRapatId){
			$this->db->from($this->table);
			$this->db->where(parent::$tableJadwalRapat.'_id',$jadwalRapatId);
			$data = $this->db->get();

			return $data->result_array();
		}
	}

?>