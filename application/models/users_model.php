<?php
class Users_model extends CI_Model {

	private $table = 'users';
	private $id;
	private $login;
	private $password;
	private $last_access;

	public function __construct() {
		 parent::__construct();
	}

	public function get_all_users($argOrderBy = 'login') {
		$this->db->order_by($argOrderBy,'asc');
		$results = $this->db->get($this->table);
		return $results->result();
	}

	public function count_all_users() {
		return $this->db->count_all($this->table);
	}

	public function get_all_users_paged($argLimit = 10, $argCurrentReg = 0, $argOrderBy = 'id') {
		$this->db->order_by($argOrderBy,'asc');
		$results = $this->db->get($this->table, $argLimit, $argCurrentReg);
		return $results->result();
	}

	public function get_user_by_id($argId, $argFields = null) {
		if (($argFields) && is_array($argFields)) {
			$fields = implode(', ', $argFields);
			$this->db->select($fields);
		}

		$this->db->where('id', $argId);
		$this->db->limit(1);
		$results = $this->db->get($this->table);
		return $results->row();

	}

	public function get_user_by_login($argLogin, $argFields = null) {
		if (($argFields) && is_array($argFields)) {
			$fields = implode(', ', $argFields);
			$this->db->select($fields);
		}

		$this->db->where('login', $argLogin); 
		$this->db->limit(1);
		$results = $this->db->get($this->table);
		return $results->row();
	}
	
	public function check_duplication_login($argValue, $argId = FALSE) {
		if (is_numeric($argId) && $argId > 0) {
			$this->db->where('id <>', $argId); 
		}
		
		$this->db->where('login', $argValue);  		
		return $this->db->count_all_results($this->table);
	}	

	public function insert_user($argObj) {
		$this->db->insert($this->table, $argObj);
		return $this->db->insert_id();
	}

	public function update_user($argId, $argObj) {
		$this->db->where('id', $argId);
		return $this->db->update($this->table, $argObj);
	}

	public function delete_user($argId) {
		$this->db->where('id', $argId);
		return $this->db->delete($this->table);
	}

}
/* End of file users_model.php */
/* Location: ./system/application/models/users_model.php */