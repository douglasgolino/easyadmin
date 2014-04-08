<?php
abstract class InterfaceController extends CI_Controller {

	protected $_menu;
	protected $_subMenu;

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->lang->load('system', 'pt_br');
		$this->load->helper(array('url', 'form'));
		$this->set_menu($this->uri->segment(1));
		$this->set_sub_menu($this->uri->segment(2));
	}

	public function set_menu($menu) {
		$this->_menu = $menu;
	}

	public function get_menu() {
		return $this->_menu;
	}

	public function set_sub_menu($subMenu) {
		if ($subMenu === false) {
			$subMenu = 'index';
		}
		$this->_subMenu = $subMenu;
	}

	public function get_sub_menu() {
		return $this->_subMenu;
	}

	protected function _encrypt($argData) {
		$string = trim($argData);
		return base64_encode($string);
	}

	protected function _decrypt($argData) {
		$string = trim($argData);
		return base64_decode($string);
	}

	private function get_menu_active() {
		$menu = $this->get_Menu();
		$arrMenu['home'] = $menu == 'home'?'current':null;
		$arrMenu['domains'] = $menu == 'domains'?'current':null;
		$arrMenu['contents'] = $menu == 'contents'?'current':null;
		$arrMenu['polls'] = $menu == 'polls'?'current':null;
		$arrMenu['users'] = $menu == 'users'?'current':null;
		$arrMenu['logout'] = $menu == 'logout'?'current':null;
		return $arrMenu;
	}

	private function get_sub_menu_active() {
		$menu = $this->get_Menu();
		$subMenu = $this->get_sub_menu();
		$arrSubMenu['domains_list'] = $menu == 'domains' && $subMenu == 'index'?'current':null;
		$arrSubMenu['insert_update_domains'] = $menu == 'domains' && ($subMenu == 'prepare_insert' || $subMenu == 'prepare_update')?'current':null;
		$arrSubMenu['contents_list'] = $menu == 'contents' && $subMenu == 'index'?'current':null;
		$arrSubMenu['insert_update_contents'] = $menu == 'contents' && ($subMenu == 'prepare_insert' || $subMenu == 'prepare_update')?'current':null;
		$arrSubMenu['polls_list'] = $menu == 'polls' && $subMenu == 'index'?'current':null;
		$arrSubMenu['insert_update_polls'] = $menu == 'polls' && ($subMenu == 'prepare_insert' || $subMenu == 'prepare_update')?'current':null;
		$arrSubMenu['change_password'] = $menu == 'users' && ($subMenu == 'prepare_change_password')?'current':null;
		return $arrSubMenu;
	}

	protected function prepare_menu() {
		$menu = $this->get_menu_active();
		$subMenu = $this->get_sub_menu_active();
		$arrMenu = array_merge ($menu, $subMenu);
		return $arrMenu;
	}

	protected function validate_session() {
		if (! $this->session->userdata('userId')) {
			$this->session->set_flashdata('msg', $this->lang->line('session_invalid'));
			redirect(base_url() . 'login/');
			exit();
		}
	}

	protected function load_template($template = 'home', $data = null) {
		$this->template->write_view('menu', 'menu', $this->prepare_menu());
		$this->template->write_view('body', $template, $data);
		$this->template->render();
	}

}
/* End of file InterfaceController.php */
/* Location: ./system/application/controllers/InterfaceController.php */