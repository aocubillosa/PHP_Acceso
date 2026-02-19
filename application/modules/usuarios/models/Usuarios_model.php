<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	/**
	 * Listado Usuarios
	 */
	public function get_user($arrData) 
	{			
		$this->db->select();
		$this->db->join('param_role R', 'R.id_role = U.fk_id_user_role', 'INNER');
		if (array_key_exists("idUser", $arrData)) {
			$this->db->where('U.id_user', $arrData["idUser"]);
		}
		$this->db->order_by("first_name, last_name", "ASC");
		$query = $this->db->get("usuarios U");
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else{
			return false;
		}
	}
}