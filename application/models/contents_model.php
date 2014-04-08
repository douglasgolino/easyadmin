<?php
class Contents_model extends CI_Model {

	private $table = 'contents';
	private $id;
	private $domain_id;
	private $tag_title;
	private $tag_body;
	private $create_date;

	public function __construct() {
		 parent::__construct();
	}

	public function get_all_contents($argOrderBy = 'id') {
		$this->db->order_by($argOrderBy,'asc');
		$results = $this->db->get($this->table);
		return $results->result();
	}

	public function count_all_contents($argFildField = null) {
		$this->db->select('COUNT(1) as total');
		$this->db->join('domains', 'domains.id = contents.domain_id');
		if($argFildField){
			$this->db->like('domains.url', $argFildField);
			$this->db->or_like('contents.tag_title', $argFildField);
		}
		$results = $this->db->get($this->table);
        $retorno = $results->row();
		return $retorno->total;
	}

	public function get_all_contents_paged($argFildField, $argLimit = 10, $argCurrentReg = 0, $argOrderBy = 'id') {
		$fields = 'contents.id,
				   contents.status,	
				   domains.url,
				   contents.tag_title,
				   domains.subdomain';
		$this->db->select($fields);	
		$this->db->join('domains', 'domains.id = contents.domain_id');
		if($argFildField){
			$this->db->like('domains.url', $argFildField);
			$this->db->or_like('contents.tag_title', $argFildField);
		}
		$this->db->order_by('contents.id','desc');
		$results = $this->db->get($this->table, $argLimit, $argCurrentReg);
		return $results->result();
	}

	public function get_content_by_id($argId, $argFields = null) {
		if (($argFields) && is_array($argFields)) {
			$fields = implode(', ', $argFields);
			$this->db->select($fields);
		}

		$this->db->where('id', $argId);
		$this->db->limit(1);
		$results = $this->db->get($this->table);
		return $results->row();
	}

	public function insert_content($argObj) {
		$this->db->insert($this->table, $argObj);
		return $this->db->insert_id();
	}

	public function update_content($argId, $argObj) {
		$this->db->where('id', $argId);
		return $this->db->update($this->table, $argObj);
	}

	public function delete_content($argId) {
		$this->db->where('id', $argId);
		return $this->db->delete($this->table);
	}
	
	public function get_contents_by_domain_id($argDomainId, $argFields = null) {
		if (($argFields) && is_array($argFields)) {
			$fields = implode(', ', $argFields);
			$this->db->select($fields);
		}

		$this->db->where('domain_id', $argDomainId);
		$results = $this->db->get($this->table);
		return $results->result();
	}	

}
/* End of file contents_model.php */
/* Location: ./system/application/models/contents_model.php */