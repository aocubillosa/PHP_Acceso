<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model {

    /**
     * Consulta Basica
     * @param $TABLA: nombre de la tabla.
     * @param $ORDEN: orden por el que se quiere organizar los datos.
     * @param $COLUMNA: nombre de la columna en la tabla para realizar un filtro. (NO ES OBLIGATORIO)
     * @param $VALOR: valor de la columna para realizar un filtro. (NO ES OBLIGATORIO)
     */
    public function get_basic_search($arrData) {
        if ($arrData["id"] != 'x')
            $this->db->where($arrData["column"], $arrData["id"]);
        $this->db->order_by($arrData["order"], "ASC");
        $query = $this->db->get($arrData["table"]);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return false;
    }
	
	/**
	 * Eliminar Record
	 */
	public function deleteRecord($arrDatos) 
	{
		$query = $this->db->delete($arrDatos ["table"], array($arrDatos ["primaryKey"] => $arrDatos ["id"]));
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Actualizar Record
	 */
	public function updateRecord($arrDatos)
	{
		$data = array(
			$arrDatos ["column"] => $arrDatos ["value"]
		);
		$this->db->where($arrDatos ["primaryKey"], $arrDatos ["id"]);
		$query = $this->db->update($arrDatos ["table"], $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Listado Menu
	 */
	public function get_menu($arrData) 
	{
		if (array_key_exists("idMenu", $arrData)) {
			$this->db->where('id_menu', $arrData["idMenu"]);
		}
		if (array_key_exists("menuType", $arrData)) {
			$this->db->where('menu_type', $arrData["menuType"]);
		}
		if (array_key_exists("menuState", $arrData)) {
			$this->db->where('menu_state', $arrData["menuState"]);
		}
		if (array_key_exists("columnOrder", $arrData)) {
			$this->db->order_by($arrData["columnOrder"], 'asc');
		} else {
			$this->db->order_by('menu_order', 'asc');
		}
		$query = $this->db->get('param_menu');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}	

	/**
	 * Listado Roles
	 */
	public function get_roles($arrData) 
	{
		if (array_key_exists("filtro", $arrData)) {
			$this->db->where('id_role !=', 99);
		}
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('id_role', $arrData["idRole"]);
		}
		$this->db->order_by('role_name', 'asc');
		$query = $this->db->get('param_role');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * Listado Links
	 */
	public function get_links($arrData) 
	{
		$this->db->select();
		$this->db->join('param_menu M', 'M.id_menu = L.fk_id_menu', 'INNER');
		if (array_key_exists("idMenu", $arrData)) {
			$this->db->where('fk_id_menu', $arrData["idMenu"]);
		}
		if (array_key_exists("idLink", $arrData)) {
			$this->db->where('id_link', $arrData["idLink"]);
		}
		if (array_key_exists("linkType", $arrData)) {
			$this->db->where('link_type', $arrData["linkType"]);
		}			
		if (array_key_exists("linkState", $arrData)) {
			$this->db->where('link_state', $arrData["linkState"]);
		}
		$this->db->order_by('M.menu_order, L.order', 'asc');
		$query = $this->db->get('param_menu_links L');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * Listado Role Access
	 */
	public function get_role_access($arrData) 
	{
		$this->db->select('P.id_access, P.fk_id_menu, P.fk_id_link, P.fk_id_role, M.menu_name, M.menu_order, M.menu_type, L.link_name, L.link_url, L.order, L.link_icon, L.link_type, R.role_name, R.style');
		$this->db->join('param_menu M', 'M.id_menu = P.fk_id_menu', 'INNER');
		$this->db->join('param_menu_links L', 'L.id_link = P.fk_id_link', 'LEFT');
		$this->db->join('param_role R', 'R.id_role = P.fk_id_role', 'INNER');
		if (array_key_exists("idPermiso", $arrData)) {
			$this->db->where('id_access', $arrData["idPermiso"]);
		}
		if (array_key_exists("idMenu", $arrData)) {
			$this->db->where('P.fk_id_menu', $arrData["idMenu"]);
		}
		if (array_key_exists("idLink", $arrData)) {
			$this->db->where('P.fk_id_link', $arrData["idLink"]);
		}
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('P.fk_id_role', $arrData["idRole"]);
		}
		if (array_key_exists("menuType", $arrData)) {
			$this->db->where('M.menu_type', $arrData["menuType"]);
		}
		if (array_key_exists("linkState", $arrData)) {
			$this->db->where('L.link_state', $arrData["linkState"]);
		}
		if (array_key_exists("menuURL", $arrData)) {
			$this->db->where('M.menu_url', $arrData["menuURL"]);
		}
		if (array_key_exists("linkURL", $arrData)) {
			$this->db->where('L.link_url', $arrData["linkURL"]);
		}
		$this->db->order_by('M.menu_order, L.order', 'asc');
		$query = $this->db->get('param_menu_access P');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	/**
	 * Listado Role Menu
	 */
	public function get_role_menu($arrData) 
	{
		$this->db->select('distinct(fk_id_menu), menu_url,menu_icon,menu_name,menu_order');
		$this->db->join('param_menu M', 'M.id_menu = P.fk_id_menu', 'INNER');
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('P.fk_id_role', $arrData["idRole"]);
		}
		if (array_key_exists("menuType", $arrData)) {
			$this->db->where('M.menu_type', $arrData["menuType"]);
		}
		if (array_key_exists("menuState", $arrData)) {
			$this->db->where('M.menu_state', $arrData["menuState"]);
		} 
		$this->db->order_by('M.menu_order', 'asc');
		$query = $this->db->get('param_menu_access P');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Listado Usuarios
	 */
	public function get_users($arrData)
	{
		$this->db->select();
		$this->db->join('param_role R', 'R.id_role = U.fk_id_user_role', 'INNER');
		$this->db->join('param_tipo_documento D', 'D.id_tipo_documento = U.fk_id_tipo_documento', 'INNER');
		$this->db->where('U.fk_id_user_role != 99');
		if (array_key_exists("state", $arrData)) {
			$this->db->where('U.state', $arrData["state"]);
		}
		if (array_key_exists("filtroState", $arrData)) {
			$this->db->where('U.state !=', 2);
		}
		if (array_key_exists("idUser", $arrData)) {
			$this->db->where('U.id_user', $arrData["idUser"]);
		}
		if (array_key_exists("idRole", $arrData)) {
			$this->db->where('U.fk_id_user_role', $arrData["idRole"]);
		}
		$this->db->order_by("U.first_name, U.last_name", "ASC");
		$query = $this->db->get("usuarios U");
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else{
			return false;
		}
	}

	/**
	 * Listado Funcionarios
	 */
	public function get_employees($arrData)
	{
		$this->db->select();
		$this->db->join('param_tipo_documento D', 'D.id_tipo_documento = F.fk_id_tipo_documento', 'INNER');
		$this->db->join('param_tipo_funcionario TF', 'TF.id_tipo_funcionario = F.fk_id_tipo_funcionario', 'INNER');
		$this->db->join('param_cargo C', 'C.id_cargo = F.fk_id_cargo', 'INNER');
		if (array_key_exists("state", $arrData)) {
			$this->db->where('F.state', $arrData["state"]);
		}
		if (array_key_exists("filtroState", $arrData)) {
			$this->db->where('F.state !=', 2);
		}
		if (array_key_exists("idFuncionario", $arrData)) {
			$this->db->where('F.id_funcionario', $arrData["idFuncionario"]);
		}
		if (array_key_exists("numeroDocumento", $arrData)) {
			$this->db->where('F.numero_documento', $arrData["numeroDocumento"]);
		}
		$this->db->order_by("F.nombres, F.apellidos", "ASC");
		$query = $this->db->get("funcionarios F");
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else{
			return false;
		}
	}

	/**
	 * Listado Visitantes
	 */
	public function get_visitors($arrData)
	{
		$this->db->select();
		$this->db->join('param_tipo_documento D', 'D.id_tipo_documento = V.fk_id_tipo_documento', 'INNER');
		if (array_key_exists("state", $arrData)) {
			$this->db->where('V.state', $arrData["state"]);
		}
		if (array_key_exists("filtroState", $arrData)) {
			$this->db->where('V.state !=', 2);
		}
		if (array_key_exists("idVisitante", $arrData)) {
			$this->db->where('V.id_visitante', $arrData["idVisitante"]);
		}
		if (array_key_exists("numeroDocumento", $arrData)) {
			$this->db->where('V.numero_documento', $arrData["numeroDocumento"]);
		}
		$this->db->order_by("V.nombres, V.apellidos", "ASC");
		$query = $this->db->get("visitantes V");
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else{
			return false;
		}
	}

	/**
	 * Listado Escuelas
	 */
	public function get_schools($arrData)
	{
		$this->db->select();
		if (array_key_exists("state", $arrData)) {
			$this->db->where('estado', $arrData["state"]);
		}
		if (array_key_exists("filtroState", $arrData)) {
			$this->db->where('estado !=', 2);
		}
		if (array_key_exists("idEscuela", $arrData)) {
			$this->db->where('id_escuela', $arrData["idEscuela"]);
		}
		if (array_key_exists("nit", $arrData)) {
			$this->db->where('nit', $arrData["nit"]);
		}
		$this->db->order_by("id_escuela", "ASC");
		$query = $this->db->get("escuelas");
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else{
			return false;
		}
	}

	/**
	 * Listado Integrantes
	 */
	public function get_members($arrData)
	{
		$this->db->select();
		$this->db->join('escuelas E', 'E.id_escuela = I.fk_id_escuela', 'INNER');
		$this->db->join('param_tipo_funcion F', 'F.id_tipo_funcion = I.fk_id_tipo_funcion', 'INNER');
		$this->db->join('param_tipo_documento D', 'D.id_tipo_documento = I.fk_id_tipo_documento', 'INNER');
		if (array_key_exists("state", $arrData)) {
			$this->db->where('I.state', $arrData["state"]);
		}
		if (array_key_exists("filtroState", $arrData)) {
			$this->db->where('I.state !=', 2);
		}
		if (array_key_exists("idEscuela", $arrData)) {
			$this->db->where('E.id_escuela', $arrData["idEscuela"]);
		}
		if (array_key_exists("nit", $arrData)) {
			$this->db->where('E.nit', $arrData["nit"]);
		}
		if (array_key_exists("numeroDocumento", $arrData)) {
			$this->db->where('I.numero_documento', $arrData["numeroDocumento"]);
		}
		$this->db->order_by("I.nombres, I.apellidos", "ASC");
		$query = $this->db->get("integrantes I");
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else{
			return false;
		}
	}
}