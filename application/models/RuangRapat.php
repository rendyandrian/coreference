<?php
	require_once 'BaseModel.php';
	class RuangRapat extends BaseModel {

		public function __construct(){
			$this->table = parent::$tableRuangRapat;
			parent::__construct($this->table);
		}

		public function getRuangRapatByRuangRapatId($ruangRapatId) {
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('ruang_rapat_id',$ruangRapatId);
			$result = $this->db->get();
			return $result->first_row();
		}
	}

?>