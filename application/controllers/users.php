<?php
require_once ('InterfaceController.php');

class Users extends InterfaceController {
	
	private $RegByPage = 10;
	
	public function __construct() {
		parent::__construct();
		$this->validate_session();
		$this->load->model('Users_model', null, true);
	}
		
	public function prepare_update($argId) {
		$obj = $this->Users_model->recuperarUsuarioPorId($argId);
		
		if (! empty($obj)) {
			$data['acao'] = base_url() . 'users/alterar/';
			$data['id'] = $argId;
			$data['login'] = $obj->login;
			$data['senha'] = null;
			$data['confirmacao_senha'] = null;
			$this->load_template('users_form', $data);
		}
	}
	
	public function update() {
		$validacao = $this->validate('update');
		
		if ($validacao == true) {
			$this->write_registry('update');
		}
		
		$id = $this->input->post('id');
		redirect(base_url() . 'users/preparaAlterar/' . $id);
	}
	
	public function change_password() {
		$id = $this->session->userdata('userId');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('new_password', 'senha', 'trim|required|min_length[6]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('password_confirmation', 'confirmacao senha', 'trim|required|min_length[6]|max_length[12]|xss_clean');
		
		if ($this->form_validation->run() == true) {
			$new_password = $this->input->post('new_password');
			$passwordConfirmation = $this->input->post('password_confirmation');
			
			if ($new_password != $passwordConfirmation) {
				$this->session->set_flashdata('error', $this->lang->line('password_confirmation_differ'));
			} else {
				$obj->password = hash('sha256', $new_password);
				$res = $this->Users_model->update_user($id, $obj);
				if (! empty($res)) {
					$this->session->set_flashdata('msg', $this->lang->line('update_password_success'));
				} else {
					$this->session->set_flashdata('error', $this->lang->line('update_error'));
				}
			}
		} else {
			$this->session->set_flashdata('error', validation_errors());
		}

		redirect(base_url() . 'users/prepare_change_password/');
	}

	public function prepare_change_password() {
		$data = array();
		$data['action'] = base_url() . 'users/change_password/';
		$data['new_password'] = null;
		$data['password_confirmation'] = null;
		$this->load_template('change_password_form', $data);
	}

}
/* End of file users.php */
/* Location: ./application/controllers/users.php */