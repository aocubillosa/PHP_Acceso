<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Access_model extends CI_Model {

	/**
	 * Add/Edit Menu
	 */
	public function saveMenu()
	{
		$idMenu = $this->input->post('hddId');
		$data = array(
			'menu_name' => $this->input->post('menu_name'),
			'menu_url' => $this->input->post('menu_url'),
			'menu_icon' => $this->input->post('menu_icon'),
			'menu_order' => $this->input->post('order'),
			'menu_type' => $this->input->post('menu_type'),
			'menu_state' => $this->input->post('menu_state')
		);
		if ($idMenu == '') {
			$query = $this->db->insert('param_menu', $data);
		} else {
			$this->db->where('id_menu', $idMenu);
			$query = $this->db->update('param_menu', $data);
		}
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Add/Edit Link
	 */
	public function saveLink()
	{
		$idLink = $this->input->post('hddId');
		$data = array(
			'fk_id_menu' => $this->input->post('id_menu'),
			'link_name' => $this->input->post('link_name'),
			'link_url' => $this->input->post('link_url'),
			'link_icon' => $this->input->post('link_icon'),
			'order' => $this->input->post('order'),
			'link_state' => $this->input->post('link_state'),
			'link_type' => $this->input->post('link_type')
		);
		if ($idLink == '') {
			$query = $this->db->insert('param_menu_links', $data);
		} else {
			$this->db->where('id_link', $idLink);
			$query = $this->db->update('param_menu_links', $data);
		}
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Add/Edit Role Access
	 */
	public function saveRoleAccess() 
	{
		$idPermiso = $this->input->post('hddId');
		$data = array(
			'fk_id_menu' => $this->input->post('id_menu'),
			'fk_id_link' => $this->input->post('id_link'),
			'fk_id_role' => $this->input->post('id_role')
		);
		if ($idPermiso == '') {
			$query = $this->db->insert('param_menu_access', $data);
		} else {
			$this->db->where('id_access', $idPermiso);
			$query = $this->db->update('param_menu_access', $data);
		}
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
}