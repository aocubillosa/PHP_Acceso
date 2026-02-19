<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model {

	/**
	 * Verificar Usuario
	 */
	public function verifyUser($arrData)
	{
		$this->db->select();
		if (array_key_exists("idUser", $arrData)) {
			$this->db->where('id_user !=', $arrData["idUser"]);
		}
		$this->db->where($arrData["column"], $arrData["value"]);
		$query = $this->db->get("usuarios");
		if ($query->num_rows() > 0) {
			return true;
		} else { 
			return false; 
		}
	}
	
	/**
	 * Add/Edit Usuario
	 */
	public function saveUser()
	{
		$idUser = $this->input->post('hddId');
		$data = array(
			'fk_id_user_role' => $this->input->post('idRole'),
			'fk_id_tipo_documento' => $this->input->post('tipoDocumento'),
			'numero_documento' => $this->input->post('numeroDocumento'),
			'first_name' => $this->input->post('firstName'),
			'last_name' => $this->input->post('lastName'),
			'log_user' => $this->input->post('user'),
			'email' => $this->input->post('email'),
			'movil' => $this->input->post('movilNumber')
		);
		if ($idUser == '') {
			$data['state'] = 1;
			$query = $this->db->insert('usuarios', $data);
		} else {
			$data['state'] = $this->input->post('state');
			$this->db->where('id_user', $idUser);
			$query = $this->db->update('usuarios', $data);
		}
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Verificar Funcionario
	 */
	public function verifyEmployee($arrData)
	{
		$this->db->select();
		if (array_key_exists("idEmployee", $arrData)) {
			$this->db->where('id_funcionario !=', $arrData["idEmployee"]);
		}
		$this->db->where($arrData["column"], $arrData["value"]);
		$query = $this->db->get("funcionarios");
		if ($query->num_rows() > 0) {
			return true;
		} else { 
			return false; 
		}
	}

	/**
	 * Add/Edit Funcionario
	 */
	public function saveEmployee()
	{
		$idEmployee = $this->input->post('hddId');
		$data = array(
			'fk_id_tipo_funcionario' => $this->input->post('tipoFuncionario'),
			'fk_id_cargo' => $this->input->post('cargo'),
			'fk_id_tipo_documento' => $this->input->post('tipoDocumento'),
			'numero_documento' => $this->input->post('numeroDocumento'),
			'nombres' => $this->input->post('firstName'),
			'apellidos' => $this->input->post('lastName'),
			'correo' => $this->input->post('email'),
			'telefono' => $this->input->post('movilNumber')
		);
		if ($idEmployee == '') {
			$data['state'] = 1;
			$query = $this->db->insert('funcionarios', $data);
		} else {
			$data['state'] = $this->input->post('state');
			$this->db->where('id_funcionario', $idEmployee);
			$query = $this->db->update('funcionarios', $data);
		}
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Verificar Visitante
	 */
	public function verifyVisitor($arrData)
	{
		$this->db->select();
		if (array_key_exists("idVisitor", $arrData)) {
			$this->db->where('id_visitante !=', $arrData["idVisitor"]);
		}
		$this->db->where($arrData["column"], $arrData["value"]);
		$query = $this->db->get("visitantes");
		if ($query->num_rows() > 0) {
			return true;
		} else { 
			return false; 
		}
	}

	/**
	 * Add/Edit Visitante
	 */
	public function saveVisitor()
	{
		$idVisitor = $this->input->post('hddId');
		$data = array(
			'fk_id_tipo_documento' => $this->input->post('tipoDocumento'),
			'numero_documento' => $this->input->post('numeroDocumento'),
			'nombres' => $this->input->post('firstName'),
			'apellidos' => $this->input->post('lastName'),
			'correo' => $this->input->post('email'),
			'telefono' => $this->input->post('movilNumber')
		);
		if ($idVisitor == '') {
			$data['state'] = 1;
			$query = $this->db->insert('visitantes', $data);
		} else {
			$data['state'] = $this->input->post('state');
			$this->db->where('id_visitante', $idVisitor);
			$query = $this->db->update('visitantes', $data);
		}
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Verificar Escuela
	 */
	public function verifySchool($arrData)
	{
		$this->db->select();
		if (array_key_exists("idSchool", $arrData)) {
			$this->db->where('id_escuela !=', $arrData["idSchool"]);
		}
		$this->db->where($arrData["column"], $arrData["value"]);
		$query = $this->db->get("escuelas");
		if ($query->num_rows() > 0) {
			return true;
		} else { 
			return false; 
		}
	}

	/**
	 * Add/Edit Escuela
	 */
	public function saveSchool()
	{
		$idSchool = $this->input->post('hddId');
		$data = array(
			'nit' => $this->input->post('nit'),
			'nombre_escuela' => $this->input->post('nombre'),
			'numero_telefono' => $this->input->post('telefono'),
			'direccion' => $this->input->post('direccion'),
		);
		if ($idSchool == '') {
			$data['estado'] = 1;
			$query = $this->db->insert('escuelas', $data);
		} else {
			$data['estado'] = $this->input->post('state');
			$this->db->where('id_escuela', $idSchool);
			$query = $this->db->update('escuelas', $data);
		}
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Verificar Integrante
	 */
	public function verifyMember($arrData)
	{
		$this->db->select();
		if (array_key_exists("idMember", $arrData)) {
			$this->db->where('id_integrante !=', $arrData["idMember"]);
		}
		$this->db->where($arrData["column"], $arrData["value"]);
		$query = $this->db->get("integrantes");
		if ($query->num_rows() > 0) {
			return true;
		} else { 
			return false; 
		}
	}

	/**
	 * Add/Edit Integrante
	 */
	public function saveMember()
	{
		$idMember = $this->input->post('hddId');
		$data = array(
			'fk_id_escuela' => $this->input->post('idSchool'),
			'fk_id_tipo_funcion' => $this->input->post('tipoFuncion'),
			'fk_id_tipo_documento' => $this->input->post('tipoDocumento'),
			'numero_documento' => $this->input->post('numeroDocumento'),
			'nombres' => $this->input->post('firstName'),
			'apellidos' => $this->input->post('lastName'),
			'correo' => $this->input->post('email'),
			'telefono' => $this->input->post('movilNumber')
		);
		if ($idMember == '') {
			$data['state'] = 1;
			$query = $this->db->insert('integrantes', $data);
		} else {
			$data['state'] = $this->input->post('state');
			$this->db->where('id_integrante', $idMember);
			$query = $this->db->update('integrantes', $data);
		}
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Cargar Escuela
	 */
	public function cargar_integrantes($lista, $idSchool) 
	{
		$data = array(
			'fk_id_escuela' => $idSchool,
			'fk_id_tipo_funcion' => $lista["tipo_funcion"],
			'fk_id_tipo_documento' => $lista["tipo_documento"],
			'numero_documento' => $lista["numero_documento"],
			'nombres' => $lista["nombres"],
			'apellidos' => $lista["apellidos"],
			'correo' => $lista["correo"],
			'telefono' => $lista["telefono"],
			'state' => 1,
		);
		$query = $this->db->insert('integrantes', $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Validar Numero Documento Integrantes
	 */
	public function numero_documento_existe($numero_documento)
	{
	    $this->db->where('numero_documento', $numero_documento);
	    $query = $this->db->get('integrantes');
	    return $query->num_rows() > 0;
	}
}