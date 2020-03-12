<?php

	require_once 'DomainConfig.php';

	class BaseModel extends CI_Model {
		private $headers = array();
		protected static $tableGroups 				= "group";
		protected static $tableUser 				= "user";
		protected static $tablePersonel 			= "personel";
		protected static $tableSatuan 				= "satuan";
		protected static $tablePeserta 				= "lampiran_peserta";
		protected static $tablePejabat 				= "pejabat";
		protected static $tableJenisSurat 			= "jenis_surat";
		protected static $tableRuangRapat 			= "ruang_rapat";
		protected static $tablePenomoranSurat 		= "penomoran_surat";
		protected static $tableJadwalRapat 			= "jadwal_rapat";
		protected static $tableLampiranPeserta 		= "lampiran_peserta";
		protected static $tableTglSuratTerupdate	= "log_tgl_surat_terupdate";
		protected static $tableTembusan				= "tembusan";
		protected static $tableSprint				= "sprint";
		protected static $tableInbox				= "inbox";
	
		private $idColumn = "";

		public function __construct()
		{
			parent::__construct();
		    	$this->headers = API_HEADERS;
			$this->idColumn = $this->table . "_id";
	   	}

	   	public function all() {
	   		$this->db->from($this->table);
	   		$this->db->order_by($this->idColumn, 'desc');
			$data = $this->db->get();
			return $data->result();
		}
		   
	   	public function find($id) {
	   		$this->db->from($this->table);
	   		$this->db->where($this->idColumn, $id);
			$data = $this->db->get();
			return $data->first_row();	
		}
		   
	   	public function insert($data) {
			$this->db->insert($this->table, $data);
			return $this->db->insert_id();	
		}
		   
		public function insertBatch($data) {
			$result = $this->db->insert_batch($this->table, $data);
			return $result;	
		}
		   
	   	public function update($data, $id) {
	   		$this->db->where($this->idColumn, $id);
			$this->db->update($this->table, $data);
			return $this->db->affected_rows();
		}
		   
	   	public function delete($id) {
	   		$this->db->where($this->idColumn, $id);
			$this->db->delete($this->table); 
			return $this->db->affected_rows();
		}

		public function getColumnName($table=''){
			!empty($table) ? $this->table=$table : false;
			$this->db->select('COLUMN_NAME');
			$this->db->from('INFORMATION_SCHEMA.COLUMNS');
			$this->db->where('TABLE_SCHEMA',$this->db->database);
			$this->db->where('TABLE_NAME',$this->table);
			$result = $this->db->get();
			return $result->result_Array();
		}

		public function getTableName($columns){
			$this->db->select('TABLE_NAME');
			$this->db->from('INFORMATION_SCHEMA.COLUMNS');
			$this->db->where('COLUMN_NAME',$columns);
			$this->db->where('COLUMN_KEY','PRI');
			$this->db->where('TABLE_SCHEMA',$this->db->database);
			$result = $this->db->get();
			// echo $this->db->last_query();
			return $result->first_row();
		}
		
		public function http_get($endpoint){
			$this->curl->set_headers($this->headers);
			$result = $this->curl->simple_get($endpoint);
			
			return $result;
		}
		public function userLoggedInKodeSatuan() {
			$userData = $this->session->{KEY_USER};
			$kodeSatuan = $userData['satuan']->kode_satuan;
			return $kodeSatuan;
		}
		protected function isMabes(){
			return $this->userLoggedInKodeSatuan()==1 ? true : false;
		}
	}

?>