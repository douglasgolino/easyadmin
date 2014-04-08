<?php
require_once ('InterfaceController.php');

class Polls extends InterfaceController {

	private $regByPage = 20;

	public function __construct() {
		parent::__construct();
		$this->validate_session();
		$this->load->model('Polls_model', null, true);
	}

	public function index() {
		$this->load->library('pagination');
		$config = array();
		$data = array();
		$config['base_url'] = base_url() . 'polls/index/';
		$config['per_page'] = $this->regByPage;
		$config['first_link'] = $this->lang->line('first');
		$config['last_link'] = $this->lang->line('last');
		$CurrentReg = $this->uri->segment(3);
		$listPolls = $this->Polls_model->get_all_polls_paged($this->regByPage, $CurrentReg, 'id');
		$data['list'] = $this->prepare_polls_listing($listPolls);
		$config['total_rows'] = $this->Polls_model->count_all_polls();
		$this->pagination->initialize($config);
		$data['paginacao'] = $this->pagination->create_links();
		$this->load_template('polls_list', $data);
	}

	private function prepare_polls_listing($argListPolls){
		$polls = null;
		$i = 0;
		foreach($argListPolls as $poll) {
			$polls[$i]->id = $poll->id;
			$polls[$i]->domain = 'www.'.$poll->url;
			if($poll->subdomain){
				$polls[$i]->domain = $poll->url;
			}

			$size = strlen($polls[$i]->domain);
			if($size > 30) {
				$polls[$i]->domain = substr_replace($polls[$i]->domain, " ...", 30, $size - 30);
			}

			$polls[$i]->question = $poll->question;
			$size = strlen($polls[$i]->question);
			if($size > 35) {
				$polls[$i]->question = substr_replace($polls[$i]->question, " ...", 35, $size - 35);
			}
			$polls[$i]->subdomain = $poll->subdomain;
			$polls[$i]->status = $poll->status;
			$i++;
		}

		return $polls;
	}

	public function prepare_insert() {
		$data = array();
		$data['action'] = base_url() . 'polls/insert/';
		$data['id'] = null;
		$this->load->model('Domains_model', null, true);
		$domains_list = $this->Domains_model->get_all_domains();
		foreach ($domains_list as $domain) {
			$domains[$domain->id] = $domain->url;
		}
		$data['domains'] = (count($domains_list)>0) ? $domains : array(''  => '<< nenhum >>');
		$data['domainId'] = null;
		$data['question'] = null;
		$data['answer_1'] = null;
		$data['answer_2'] = null;
		$data['answer_3'] = null;

		$this->load_template('polls_form', $data);
	}

	public function insert() {
		$validation = $this->validate('insert');

		if ($validation == true) {
			$this->write_registry('insert');
		}

		redirect(base_url() . 'polls/prepare_insert/');
		exit();

	}

	public function prepare_update($argId) {
		$obj = $this->Polls_model->get_poll_by_id($argId);

		if (! empty($obj)) {
			$data['action'] = base_url() . 'polls/update/';
			$data['id'] = $obj->id;
			$this->load->model('Domains_model', null, true);
			$domains_list = $this->Domains_model->get_all_domains();
			foreach ($domains_list as $domain) {
				$domains[$domain->id] = $domain->url;
			}
			$data['domains'] = $domains;
			$data['domainId'] = $obj->domain_id;
			$data['question'] = $obj->question;
			$answers_list = $this->Polls_model->get_all_poll_answers_by_poll_id($argId);
			$y = 1;
			for($x=0;$x<=2;$x++){
				$data['answer_'.$y] = "";
				if(array_key_exists($x, $answers_list)){
					$data['answer_'.$y] = $answers_list[$x]['answer'];
				}
				$y++;
			}
			$this->load_template('polls_form', $data);
		}
	}

	public function update() {
		$validation = $this->validate('update');

		if ($validation == true) {
			$this->write_registry('update');
		}

		$id = $this->input->post('id');
		redirect(base_url() . 'polls/prepare_update/' . $id);
	}

	protected function validate($argAction) {
		$this->load->library('form_validation');

		if ($argAction == 'update') {
			$this->form_validation->set_rules('id', 'id', 'required|numeric|is_numeric');
		}

		$this->form_validation->set_rules('domains', 'Dom&iacute;nio', 'required|numeric|is_numeric|xss_clean');
		$this->form_validation->set_rules('question', 'Pergunta', 'trim|required|xss_clean');
		$this->form_validation->set_rules('answer_1', '1&#170; Alternativa', 'trim|xss_clean|required');
		$this->form_validation->set_rules('answer_2', '2&#170; Alternativa', 'trim|xss_clean|required');
		$this->form_validation->set_rules('answer_3', '3&#170; Alternativa', 'trim|xss_clean');

		$validation = $this->form_validation->run();

		if ($validation == false) {
			$this->session->set_flashdata('error', validation_errors());
			return false;
		}
		return true;
	}


	private function write_registry($argAction) {
		$obj->domain_id = $this->input->post('domains');
		$obj->question = $this->input->post('question');
		$obj->answers[] = $this->input->post('answer_1');
		$obj->answers[] = $this->input->post('answer_2');
		if($this->input->post('answer_3')!=""){
			$obj->answers[] = $this->input->post('answer_3');
		}

		if ($argAction == 'update') {
			$id = $this->input->post('id');
			$res = $this->Polls_model->update_poll($id, $obj);

			if (! empty($res)) {
				$this->session->set_flashdata('msg', $this->lang->line('update_success'));
			} else {
				$this->session->set_flashdata('error', $this->lang->line('update_error'));
			}
		} else {
			$id = $this->Polls_model->insert_poll($obj);
			if (is_numeric($id)) {
				$this->session->set_flashdata('msg', $this->lang->line('insert_success'));
			} else {
				$this->session->set_flashdata('error', $this->lang->line('insert_error'));
			}
		}
	}

	public function delete($id){
		$this->load->model('Polls_model', null, true);
		$res = $this->Polls_model->delete_poll($id);
		if (! empty($res)) {
			$this->session->set_flashdata('msg', $this->lang->line('delete_success'));
			redirect('polls/index/', 'refresh');
		}
	}

	public function change_status($argId) {
		$obj = $this->Polls_model->get_poll_by_id($argId, array('status'));
		if (! empty($obj)) {
			$obj->status = $obj->status == 1?$obj->status = 0:$obj->status = 1;
			$res = $this->Polls_model->change_status($argId, $obj);

			if (! empty($res)) {
				$this->session->set_flashdata('msg', $this->lang->line('status_sucess'));
			} else {
				$this->session->set_flashdata('error', $this->lang->line('status_fail'));
			}
		}
		redirect('polls/index/', 'refresh');
	}

}
/* End of file polls.php */
/* Location: ./application/controllers/polls.php */