<?php
require_once 'BaseModel.php';
class Sprint extends BaseModel {
    public function __construct() {
        $this->table    = parent::$tableSprint;
        $this->idColumn = $this->table . '_id';
        parent::__construct($this->table);
    }

    public function getDataSprint($where) {
        $this->db->from($this->table);
        $this->db->join(parent::$tablePenomoranSurat, parent::$tablePenomoranSurat . '_id');
        if ($where == 'belum_set_waktu') {
            $this->db->where($this->table . '.tanggal_start is null');
        } elseif ($where == 'double_sprint') {
            $this->db->where($this->table . '.double_sprint', true);
        } else {
            $this->db->where($this->table . '.tanggal_start is not null');
            $this->db->where($this->table . '.double_sprint', false);
        }
        $this->db->where($this->table . '.status_aktif', true);
        $this->db->order_by($this->idColumn, 'desc');
        $data = $this->db->get();
        return $data->result();
    }


    public function checkDoubleSprint($dateStart, $dateEnd) {
        $sql  = "SELECT penomoran_surat_id FROM " . $this->table . " WHERE ((? between tanggal_start AND  tanggal_end OR ? between tanggal_start AND  tanggal_end) AND status_aktif = ?) OR (tanggal_start between ? AND ? AND status_aktif = ?) OR (tanggal_end between ? AND ? AND status_aktif = ?) AND status_aktif = ? ";
        $data = $this->db->query($sql, array($dateStart, $dateEnd, 1, $dateStart, $dateEnd, 1, $dateStart, $dateEnd, 1, 1));
        return $data->result();
    }

    public function checkDoubleSprintByPenomoranSuratId($penomoranSuratId) {
        $sql  = "SELECT penomoran_surat_id FROM " . $this->table . " WHERE ((? between tanggal_start AND  tanggal_end OR ? between tanggal_start AND  tanggal_end) AND status_aktif = ?) OR (tanggal_start between ? AND ? AND status_aktif = ?) OR (tanggal_end between ? AND ? AND status_aktif = ?) AND status_aktif = ? ";
        $data = $this->db->query($sql, array($dateStart, $dateEnd, 1, $dateStart, $dateEnd, 1, $dateStart, $dateEnd, 1, 1));
        return $data->result();
    }

    public function setDoubleStatus($sprintId, $status) {
        $data['double_sprint'] = $status;
        $this->db->where_in($this->table . '_id', $sprintId);
        $this->db->update($this->table, $data);
        echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function find($id) {
        $this->db->from($this->table);
        $this->db->join(parent::$tablePenomoranSurat, parent::$tablePenomoranSurat . '_id');
        $this->db->where($this->idColumn, $id);
        $data = $this->db->get();
        return $data->first_row();
    }

    public function getPenomoranSuratIdBySprint($id) {
        $this->db->select('penomoran_surat_id');
        $this->db->from($this->table);
        $this->db->where($this->idColumn, $id);
        $data = $this->db->get();
        return $data->first_row();
    }

}

?>