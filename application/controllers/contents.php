<?php
require_once ('InterfaceController.php');

class Contents extends InterfaceController {

	private $regByPage = 20;

	public function __construct() {
		parent::__construct();
		$this->validate_session();
		$this->load->model('Contents_model', null, true);
	}
	
	public function index() {
		if($this->validate_search()){
			$find_content = $this->input->post('find_content');
			$this->session->set_userdata('find_content', $find_content);
		}elseif($this->session->userdata('find_content')){
			$find_content = $this->session->userdata('find_content');
		}else{
			$find_content = "";
		}

		$this->load->library('pagination');
		$config = array();
		$data = array();
		$data['find_content'] = $find_content;
		$config['base_url'] = base_url() . 'contents/index/';
		$config['per_page'] = $this->regByPage;
		$config['first_link'] = $this->lang->line('first');
		$config['last_link'] = $this->lang->line('last');
		$CurrentReg = $this->uri->segment(3);
		$listContents = $this->Contents_model->get_all_contents_paged($find_content, $this->regByPage, $CurrentReg, 'id');
		$data['list'] = $this->prepare_content_listing($listContents);
		$config['total_rows'] = $this->Contents_model->count_all_contents($find_content);
		$this->pagination->initialize($config);
		$data['paginacao'] = $this->pagination->create_links();
		$this->load_template('contents_list', $data);
	}
	
	public function clear_research(){
		$this->session->unset_userdata('find_content');
		redirect(base_url() . 'contents/');
	}
	
	private function prepare_content_listing($argListContents){
		$contents = null;
		$i = 0;
		foreach($argListContents as $content) {
			$contents[$i]->id = $content->id;
			$contents[$i]->domain = 'www.'.$content->url;
			if($content->subdomain){
				$contents[$i]->domain = $content->url;
			}
			
			$size = strlen($contents[$i]->domain);
			if($size > 30) {
				$contents[$i]->domain = substr_replace($contents[$i]->domain, " ...", 30, $size - 30);
			}

			$contents[$i]->tag_title = $content->tag_title;
			$size = strlen($contents[$i]->tag_title);			
			if($size > 20) {
				$contents[$i]->tag_title = substr_replace($contents[$i]->tag_title, " ...", 25, $size - 25);
			}			
			$contents[$i]->subdomain = $content->subdomain;
			$contents[$i]->status = $content->status;
			$i++;
		}

		return $contents;
	}
	
	public function prepare_insert() {
		$data = array();
		$data['action'] = base_url() . 'contents/insert/';
		$data['id'] = null;
		$this->load->model('Domains_model', null, true);
		$domains_list = $this->Domains_model->get_all_domains();
		foreach ($domains_list as $domain) {
			$domains[$domain->id] = $domain->url;
		}
		$data['domains'] = (count($domains_list)>0) ? $domains : array(''  => '<< nenhum >>');
		$data['domainId'] = null;
		$data['tag_title'] = null;
		$data['tag_body'] = null;

		$data['ckeditor_text'] = $this->prepare_ckeditor();	
		$this->load_template('contents_form', $data);
	}
	
	public function insert() {
		$validation = $this->validate('insert');
		
		if ($validation == true) {
			$this->write_registry('insert');
		}
		
		redirect(base_url() . 'contents/prepare_insert/');
		exit();
	
	}
	
	public function prepare_update($argId) {
		$obj = $this->Contents_model->get_content_by_id($argId);

		if (! empty($obj)) {
			$data['action'] = base_url() . 'contents/update/';
			$data['id'] = $obj->id;
			$this->load->model('Domains_model', null, true);
			$domains_list = $this->Domains_model->get_all_domains();
			foreach ($domains_list as $domain) {
				$domains[$domain->id] = $domain->url;
			}
			$data['domains'] = $domains;
			$data['domainId'] = $obj->domain_id;
			$data['tag_title'] = $obj->tag_title;
			$data['tag_body'] = $obj->tag_body;
			$data['ckeditor_text'] = $this->prepare_ckeditor();	
		
			$this->load_template('contents_form', $data);
		}
	}
	
	public function update() {
		$validation = $this->validate('update');
		
		if ($validation == true) {
			$this->write_registry('update');
		}
		
		$id = $this->input->post('id');
		redirect(base_url() . 'contents/prepare_update/' . $id);
	}
	
	protected function validate($argAction) {
		$this->load->library('form_validation');
		
		if ($argAction == 'update') {
			$this->form_validation->set_rules('id', 'id', 'required|numeric|is_numeric');
		}
		
		$this->form_validation->set_rules('domains', 'Dom&iacute;nio', 'required|numeric|is_numeric|xss_clean');
		$this->form_validation->set_rules('tag_title', 't&iacute;tulo', 'trim|required|xss_clean');	
		$validation = $this->form_validation->run();
		
		if ($validation == false) {
			$this->session->set_flashdata('error', validation_errors());
			return false;
		}
		return true;
	}
	
	private function validate_search(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('find_content', 'Campo de pesquisa', 'trim|xss_clean|min_length[3]|max_length[60]');
		$validation = $this->form_validation->run();			
		if ($validation == false) {
			$this->session->set_flashdata('error', validation_errors());
			return false;
		}
		return true;
	}
	
	private function write_registry($argAction) {
		$obj->domain_id = $this->input->post('domains');
		$obj->tag_title = $this->input->post('tag_title');
		$obj->tag_body = $this->input->post('tag_body');
		
		if ($argAction == 'update') {
			$id = $this->input->post('id');			
			$res = $this->Contents_model->update_content($id, $obj);
			
			if (! empty($res)) {
				$this->session->set_flashdata('msg', $this->lang->line('update_success'));
			} else {
				$this->session->set_flashdata('error', $this->lang->line('update_error'));
			}
		} else {
			$id = $this->Contents_model->insert_content($obj);
			if (is_numeric($id)) {
				$this->session->set_flashdata('msg', $this->lang->line('insert_success'));
			} else {
				$this->session->set_flashdata('error', $this->lang->line('insert_error'));
			}
		}
	}

	public function delete($id){
            $res = $this->Contents_model->delete_content($id);
            if (! empty($res)) {
                    $this->session->set_flashdata('msg', $this->lang->line('delete_success'));
                    redirect('contents/index/', 'refresh');
            }
	}
	
	public function change_status($argId) {
		$obj = $this->Contents_model->get_content_by_id($argId, array('status'));	
		if (! empty($obj)) {
			$obj->status = $obj->status == 1?$obj->status = 0:$obj->status = 1;
			$res = $this->Contents_model->update_content($argId, $obj);
			
			if (! empty($res)) {
				$this->session->set_flashdata('msg', $this->lang->line('status_sucess'));
			} else {
				$this->session->set_flashdata('error', $this->lang->line('status_fail'));
			}
		}
		redirect('contents/index/', 'refresh');
	}

	private function prepare_ckeditor(){
        $this->load->helper('ckeditor');
        $ckeditor = array
        (            
			'id'   => 'tag_body',
			'path' => 'resources/plugins/ckeditor',
            'config' => array
            (
                'toolbar' => "Full",
                'width'   => "650px",
                'height'  => "450px",
            )
        );

		return $ckeditor;
	}	

}
/* End of file contents.php */
/* Location: ./application/controllers/contents.php */
