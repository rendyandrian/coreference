<?php
	require_once 'BaseModel.php';
	class Inbox extends BaseModel {

		public function __construct(){
			$this->table = parent::$tablePeserta;
			parent::__construct($this->table);
		}
		public function allPenomoranSuratByKodeSatuan($kodesatuan){
			$this->db->select('
			DISTINCT(penomoran_surat_id) as penomoran_surat_id,
			js.jenis_surat_name as jenis_surat, 
			js.jenis_surat_id as jenis_surat_id, 
			ps.nomor_surat_prefix as nomor_surat_prefix,
			ps.tgl_surat as tgl_surat,
			ps.nomor_surat as nomor_surat,
			ps.nomor_surat_suffix as nomor_surat_suffix
			');  
			$this->db->from($this->table);
			$this->db->join('penomoran_surat ps', 'penomoran_surat_id');
			$this->db->join('jenis_surat js', 'jenis_surat_id');
			$this->db->where('status_nomor_surat','publish');
        	$this->db->where('status_file_scan','closed');
			$this->db->where('kode_satuan', $kodesatuan);
			// $this->db->where('js.jenis_surat_id','7');
			$this->db->not_like('js.jenis_surat_id', '7'); 
			$this->db->order_by($this->table.'.penomoran_surat_id', 'asc');
			$data = $this->db->get();
			// print_r($this->db->last_query());
			return $data->result();	
		}
		
		public function allJadwalRapatByKodeSatuan($kodesatuan){
			$this->db->select('
			DISTINCT(ps.penomoran_surat_id) as penomoran_surat_id,
			js.jenis_surat_name as jenis_surat, 
			js.jenis_surat_id as jenis_surat_id, 
			ps.nomor_surat_prefix as nomor_surat_prefix,
			ps.tgl_surat as tgl_surat,
			ps.nomor_surat as nomor_surat,
			ps.nomor_surat_suffix as nomor_surat_suffix,
			jr.jadwal_rapat_id as jadwal_rapat_id
			');  
			$this->db->from($this->table);
			$this->db->join('jadwal_rapat jr', 'jadwal_rapat_id');
			$this->db->join('penomoran_surat ps', 'ps.penomoran_surat_id=jr.penomoran_surat_id');
			$this->db->join('jenis_surat js', 'js.jenis_surat_id=ps.jenis_surat_id');
			$this->db->join('pejabat pj', 'jr.jadwal_rapat_id=pj.jadwal_rapat_id');
			// $this->db->join('pejabat pj', 'jr.jadwal_rapat_id');
			$this->db->where('status_nomor_surat','publish');
        	$this->db->where('status_file_scan','closed');
			$this->db->where($this->table.'.kode_satuan', $kodesatuan);
			$this->db->or_where('pj.kode_satuan', $kodesatuan);
			// $this->db->order_by($this->table.'.penomoran_surat_id', 'asc');
			$data = $this->db->get();
			return $data->result();	
		}

		public function allSprintByKodeSatuan($kodesatuan){
			$this->db->select('
			DISTINCT(ps.penomoran_surat_id) as penomoran_surat_id,
			js.jenis_surat_name as jenis_surat, 
			js.jenis_surat_id as jenis_surat_id, 
			ps.nomor_surat_prefix as nomor_surat_prefix,
			ps.tgl_surat as tgl_surat,
			ps.nomor_surat as nomor_surat,
			sp.sprint_id as sprint_id,
			ps.nomor_surat_suffix as nomor_surat_suffix,
			');  
			$this->db->from($this->table);
			$this->db->join('penomoran_surat ps', 'penomoran_surat_id');
			$this->db->join('sprint sp', 'ps.penomoran_surat_id=sp.penomoran_surat_id');
			$this->db->join('jenis_surat js', 'js.jenis_surat_id=ps.jenis_surat_id');
			$this->db->where($this->table.'.kode_satuan', $kodesatuan);
			$this->db->where('status_nomor_surat','publish');
        	$this->db->where('status_file_scan','closed');
			// $this->db->order_by($this->table.'.penomoran_surat_id', 'asc');
			$data = $this->db->get();
			// print_r($this->db->last_query());
			return $data->result();	
		}

		public function allPesertaByNomorSurat($nomorsurat,$jadwalRapatId,$kodeSatuan){
			$this->db->from($this->table);
			$this->db->join('jadwal_rapat jr', $this->table.'.jadwal_rapat_id=jr.jadwal_rapat_id','LEFT');
			$this->db->where($this->table.'.kode_satuan', $kodeSatuan);
			$this->db->where($this->table.'.status_aktif',1);
			if($jadwalRapatId!=0){
				$this->db->where('jr.jadwal_rapat_id',$jadwalRapatId);
			}else{
				$this->db->where($this->table.'.penomoran_surat_id', $nomorsurat);
			}
			$this->db->order_by($this->table.'.penomoran_surat_id', 'asc');
			$data = $this->db->get();
			return $data->result();	
		}
		
		public function valueJadwalRapatByNomorSurat($nomorsurat){
			$this->db->select('
			jadwal_rapat_id as jadwalRapat
			');
			$this->db->from('jadwal_rapat');
			$this->db->where('penomoran_surat_id', $nomorsurat);
			$data = $this->db->get();
			// print_r($this->db->last_query());
			return $data->result();	

		}
		public function allPejabatByNomorSurat($nomorsurat,$kodeSatuan){
			$this->db->from('pejabat');
			$this->db->join('jadwal_rapat jr', 'jadwal_rapat_id');
			$this->db->join('pejabat pj', 'jr.jadwal_rapat_id=pj.jadwal_rapat_id');
			$this->db->where('jr.penomoran_surat_id', $nomorsurat);
			$this->db->where('pejabat.kode_satuan', $kodeSatuan);
			$this->db->order_by('jr.penomoran_surat_id', 'asc');
			$data = $this->db->get();
			return $data->result();	
		}

	}

?>