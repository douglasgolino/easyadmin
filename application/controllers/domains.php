<?php
require_once ('InterfaceController.php');

class Domains extends InterfaceController {

    private $regByPage = 20;

    public function __construct() {
        parent::__construct();
        $this->validate_session();
        $this->load->model('Domains_model', null, true);
    }

    public function index() {
        $this->load->library('pagination');
        $config = array();
        $data = array();

        $config['base_url'] = base_url() . 'domains/index/';
        $config['per_page'] = $this->regByPage;
        $config['first_link'] = $this->lang->line('first');
        $config['last_link'] = $this->lang->line('last');
        $CurrentReg = $this->uri->segment(3);

        $data['list'] = $this->Domains_model->get_all_domains_paged($this->regByPage, $CurrentReg, 'id');
        $config['total_rows'] = $this->Domains_model->count_all_domains();

        $this->pagination->initialize($config);
        $data['paginacao'] = $this->pagination->create_links();
        $this->load_template('domains_list', $data);
    }

    public function prepare_insert() {
        $data = array();
        $data['action'] = base_url() . 'domains/insert/';
        $data['id'] = null;
        $data['url'] = null;
		$data['theme'] = null;		
        $data['subdomain'] = 0;
        $data['tag_title'] = null;
        $data['tag_description'] = null;
        $data['tag_keywords'] = null;
        $data['scripts_js'] = null;
		$data['fixed_text'] = null;
        $data['facebook_like'] = null;
		$data['ckeditor_text'] = $this->prepare_ckeditor();			

        $this->load_template('domains_form', $data);
    }

    public function insert() {
        $validation = $this->validate('insert');

        if ($validation == true) {
            $this->write_registry('insert');
        }

        redirect(base_url() . 'domains/prepare_insert/');
        exit();
    }

    public function prepare_update($argId) {
        $obj = $this->Domains_model->get_domain_by_id($argId);

        if (!empty($obj)) {
            $data['action'] = base_url() . 'domains/update/';
            $data['id'] = $argId;
            $data['url'] = $obj->url;
			$data['theme'] = $obj->theme;
            $data['subdomain'] = $obj->subdomain;
            $data['tag_title'] = $obj->tag_title;
            $data['tag_description'] = $obj->tag_description;
            $data['tag_keywords'] = $obj->tag_keywords;
            $data['scripts_js'] = $obj->scripts_js;
            $data['facebook_like'] = $obj->facebook_like;
			$data['fixed_text'] = $obj->fixed_text;
			$data['ckeditor_text'] = $this->prepare_ckeditor();				
            $this->load_template('domains_form', $data);
        }
    }

    public function update() {
        $validation = $this->validate('update');

        if ($validation == true) {
            $this->write_registry('update');
        }

        $id = $this->input->post('id');
        redirect(base_url() . 'domains/prepare_update/' . $id);
    }

    protected function validate($argAction) {
        $this->load->library('form_validation');

        if ($argAction == 'update') {
            $this->form_validation->set_rules('id', 'id', 'required|numeric|is_numeric');
        }

        $this->form_validation->set_rules('url', 'Url', 'trim|required');
        $this->form_validation->set_rules('subdomain', 'SubDominio', 'trim|numeric|is_numeric');
        $this->form_validation->set_rules('tag_title', 't&iacute;tulo', 'trim|required|xss_clean');
		$this->form_validation->set_rules('theme', 'Tema', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tag_description', 'Tag Description', 'trim|xss_clean');
        $this->form_validation->set_rules('tag_keywords', 'Tag Keywords', 'trim|xss_clean');		
        $this->form_validation->set_rules('scripts_js', 'Java Script', 'trim');
        $this->form_validation->set_rules('facebook_like', 'C&oacute;digo Facebook Curtir', 'trim');
		$this->form_validation->set_rules('fixed_text', 'Texto fixo', 'trim');		
        $validation = $this->form_validation->run();

        if ($validation == false) {
            $this->session->set_flashdata('error', validation_errors());
            return false;
        }
        return true;
    }

    private function write_registry($argAction) {
        $url = $this->input->post('url');
        $url = str_replace('http://', '', $url);
        $url = str_replace('www.', '', $url);
        $obj->url = $url;
		$obj->theme = $this->input->post('theme');
        $obj->subdomain = $this->input->post('subdomain');
        $obj->tag_title = $this->input->post('tag_title');
        $obj->scripts_js = $this->input->post('scripts_js');
        $obj->tag_description = $this->input->post('tag_description');
        $obj->tag_keywords = $this->input->post('tag_keywords');
        $obj->facebook_like = $this->input->post('facebook_like');
		$obj->fixed_text = $this->input->post('fixed_text');

		$config['allowed_types'] = 'jpg|jpeg|gif|png';
		$config['max_size'] = 3000;
		$config['upload_path'] = realpath(APPPATH . '../resources/uploads');
		$config['overwrite'] = true;
		$config['remove_spaces'] = true;
		$this->load->library('upload', $config);
		$this->upload->do_upload('image_logo');
		$data = array('upload_data' => $this->upload->data());
		if($data['upload_data']['file_name']){
			$obj->image_logo = trim($data['upload_data']['file_name']);
		}

        if ($argAction == 'update') {
            $id = $this->input->post('id');
            $res = $this->Domains_model->update_domain($id, $obj);

            if (!empty($res)) {
                $this->session->set_flashdata('msg', $this->lang->line('update_success'));
            } else {
                $this->session->set_flashdata('error', $this->lang->line('update_error'));
            }
        } else {
            $id = $this->Domains_model->insert_domain($obj);
            if (is_numeric($id)) {
                $this->session->set_flashdata('msg', $this->lang->line('insert_success'));
            } else {
                $this->session->set_flashdata('error', $this->lang->line('insert_error'));
            }
        }
    }

    function delete($id) {
        $this->load->model('Contents_model', null, true);
        $contents = $this->Contents_model->get_contents_by_domain_id($id);
        foreach ($contents as $contents) {
            $this->Contents_model->delete_content($contents->id);
        }

        $res = $this->Domains_model->delete_domain($id);
        if (!empty($res)) {
            $this->session->set_flashdata('msg', $this->lang->line('delete_success'));
            redirect('domains/index/', 'refresh');
        }
    }
	
	private function prepare_ckeditor(){
        $this->load->helper('ckeditor');
        $ckeditor = array
        (            
			'id'   => 'fixed_text',
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

/* End of file domains.php */
/* Location: ./application/controllers/domains.php */