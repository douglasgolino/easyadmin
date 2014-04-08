<?php
class Polls_model extends CI_Model {

	private $table = 'poll_questions';
	private $id;
	private $domain_id;
	private $question;
	private $status;
	private $create_date;

	public function __construct() {
		parent::__construct();
	}

	public function count_all_polls() {
		return $this->db->count_all($this->table);
	}

	public function get_all_polls_paged($argLimit = 10, $argCurrentReg = 0) {
		$fields = 'poll_questions.id,
				   poll_questions.question,
				   poll_questions.status,
				   poll_questions.domain_id,
				   domains.url,
				   domains.subdomain';
		$this->db->select($fields);
		$this->db->join('domains', 'domains.id = poll_questions.domain_id');
		$this->db->order_by('poll_questions.id', 'desc');
		$results = $this->db->get($this->table, $argLimit, $argCurrentReg);
		return $results->result();
	}
	
	public function get_all_poll_answers_by_poll_id($argId, $argFields = null) {
		if (($argFields) && is_array($argFields)) {
			$fields = implode(', ', $argFields);
			$this->db->select($fields);
		}
		$this->db->where('poll_question_id', $argId);
		$results = $this->db->get('poll_answers');
		return $results->result_array();
	}	

	public function get_poll_by_id($argId, $argFields = null) {
		if (($argFields) && is_array($argFields)) {
			$fields = implode(', ', $argFields);
			$this->db->select($fields);
		}

		$this->db->where('id', $argId);
		$this->db->limit(1);
		$results = $this->db->get($this->table);
		return $results->row();
	}

	public function insert_poll($argObj) {
		$this->db->insert($this->table, $argObj);
		$id = $this->db->insert_id();

		foreach($argObj->answers as $answer){
			$obj->poll_question_id = $id;
			$obj->answer = $answer;
			$obj->votes = 0;
			$this->db->insert('poll_answers', $obj);
		}
		return $id;
	}

	public function change_status($argId, $argObj) {
		$this->db->where('id', $argId);
		return $this->db->update($this->table, $argObj);
	}
	
	public function update_poll($argId, $argObj) {
		$this->db->where('id', $argId);
		$qtde = $this->db->update($this->table, $argObj);
		
		$this->db->where('poll_question_id', $argId);// apaga todas as respostas da enquete
		$this->db->delete('poll_answers');

		foreach($argObj->answers as $answer){
			$obj->poll_question_id = $argId;
			$obj->answer = $answer;
			$obj->votes = 0;
			$this->db->insert('poll_answers', $obj);
		}
		return $qtde;
	}

	public function delete_poll($argId) {
		$this->db->where('poll_question_id', $argId);// apaga todas as respostas da enquete
		$this->db->delete('poll_answers');

		$this->db->where('id', $argId);
		return $this->db->delete($this->table);
	}

	public function get_all_votes_by_poll_id($argId) {
		$results = $this->db->query("SELECT SUM(votes) AS total FROM poll_answers WHERE poll_question_id = $argId");
		return $results->row();
	}

}
/* End of file polls_model.php */
/* Location: ./system/application/models/polls_model.php */