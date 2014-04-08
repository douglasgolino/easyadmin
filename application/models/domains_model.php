<?php
class Domains_model extends CI_Model {

	private $table = 'domains';
	private $id;
	private $url;
	private $theme;
	private $image_logo;
	private $tag_title;
	private $scripts_js;
	private $tag_description;
	private $tag_keywords;	
	private $subdomain;
	private $facebook_like;
	private $fixed_text;
	private $create_date;

	public function __construct() {
		 parent::__construct();
	}

	public function get_all_domains($argOrderBy = 'id') {
		$this->db->order_by($argOrderBy,'desc');
		$results = $this->db->get($this->table);
		return $results->result();
	}

	public function count_all_domains() {
		return $this->db->count_all($this->table);
	}

	public function get_all_domains_paged($argLimit = 10, $argCurrentReg = 0, $argOrderBy = 'id') {
		$this->db->order_by($argOrderBy,'desc');
		$results = $this->db->get($this->table, $argLimit, $argCurrentReg);
		return $results->result();
	}

	public function get_domain_by_id($argId, $argFields = null) {
		if (($argFields) && is_array($argFields)) {
			$fields = implode(', ', $argFields);
			$this->db->select($fields);
		}

		$this->db->where('id', $argId);
		$this->db->limit(1);
		$results = $this->db->get($this->table);
		return $results->row();

	}

	public function get_domain_by_url($argurl, $argFields = null) {
		if (($argFields) && is_array($argFields)) {
			$fields = implode(', ', $argFields);
			$this->db->select($fields);
		}

		$this->db->where('url', $argurl); 
		$this->db->limit(1);
		$results = $this->db->get($this->table);
		return $results->row();
	}

	public function insert_domain($argObj) {
		$this->db->insert($this->table, $argObj);
		return $this->db->insert_id();
	}

	public function update_domain($argId, $argObj) {
		$this->db->where('id', $argId);
		return $this->db->update($this->table, $argObj);
	}

	public function delete_domain($argId) {
		$this->db->where('id', $argId);
		return $this->db->delete($this->table);
	}

}
/* End of file domains_model.php */
/* Location: ./system/application/models/domains_model.php */