<?php
require_once ('InterfaceController.php');

class Login extends InterfaceController {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
	}

	public function index() {
		$this->load->view('login');
	}

	public function make_login() {
		if ($this->validate_login())
			redirect(base_url() . 'home/');
		
		$this->session->set_flashdata('error', $this->lang->line('user_password_invalid'));
		redirect(base_url() . 'login/');
	}
	
	private function validate_login() {
		if ($this->validate_post_login()) {
			$login = strtolower($this->input->post('login'));
			$password = hash('sha256', $this->input->post('password'));
			
			$this->load->model('Users_model', null, true);
			$obj = $this->Users_model->get_user_by_login($login, array('id', 'login', 'password', 'last_access'));
			
			if ((! empty($obj)) && ($password == $obj->password)) {
				$this->session->set_userdata('userId', $obj->id);
				$this->session->set_userdata('userLogin', $obj->login);
				$dataLastAccess = $this->prepare_last_login_date($obj->last_access);
				$this->session->set_userdata('userLastAccess', $dataLastAccess);
				$this->write_new_access($obj->id);
				return true;
			}
		}

		return false;
	}

	private function prepare_last_login_date($argDateTime) {
		$dateTime = explode(" ", $argDateTime);
		$date = $dateTime[0];
		$hour = $dateTime[1];
		$dateTmp = explode("-", $date);
		return $dateTmp[2] . '/' . $dateTmp[1] . '/' . $dateTmp[0] . ' ' . $hour;
	}
	
	private function write_new_access($argUserId) {
		$obj->last_access = date('Y-m-d H:m:s');
		$res = $this->Users_model->update_user($argUserId, $obj);
		if (! empty($res)) {
			return true;
		}
		
		return false;
	}
	
	private function validate_post_login() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('login', 'Login', 'trim|required|alpha_numeric|min_length[4]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('password', 'Senha', 'trim|required|min_length[6]|max_length[12]|xss_clean');
		return $this->form_validation->run();
	}
	
	public function make_logout() {
		$this->session->sess_destroy();
		redirect(base_url() . 'login/');
	}

}
/* End of file login.php */
/* Location: ./system/application/controllers/login.php */