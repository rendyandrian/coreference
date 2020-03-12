<?php
	require_once 'BaseModel.php';
	class Group extends BaseModel {

		public function __construct(){
			$this->table = parent::$tableGroups;
			parent::__construct($this->table);
		}

		public function getGroupByGroupId($groupId) {
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('group_id',$groupId);
			$result = $this->db->get();
			return $result->first_row();
		}
	}

?>