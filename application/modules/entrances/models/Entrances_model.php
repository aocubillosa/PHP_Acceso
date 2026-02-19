<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Entrances_model extends CI_Model {

	/**
	 * Consultar Accesos X Funcionario
	 */
	public function get_access_by_employee($arrData)
	{
		$this->db->select();
		$this->db->join('funcionarios F', 'F.id_funcionario = P.fk_id_funcionario', 'INNER');
		$this->db->join('param_tipo_funcionario T', 'T.id_tipo_funcionario = F.fk_id_tipo_funcionario', 'INNER');
		$this->db->where('P.fk_id_funcionario', $arrData["idFuncionario"]);
		$this->db->where('F.state', 1);
		$this->db->where('P.fk_id_funcionario IS NOT NULL');
		$this->db->where("((P.fecha_entrada IS NULL AND P.fecha_finaliza IS NULL) OR (NOW() BETWEEN P.fecha_entrada AND P.fecha_finaliza))");
		$this->db->where('P.estado', 1);
		$query = $this->db->get("permisos P");
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else{
			return false;
		}
	}

	/**
	 * Consultar Accesos X Visitante
	 */
	public function get_access_by_visitor($arrData)
	{
		$this->db->select();
		$this->db->join('visitantes V', 'V.id_visitante = P.fk_id_visitante AND P.estado = 1', 'INNER');
		$this->db->join('ingresos I', 'V.id_visitante = I.fk_id_visitante', 'LEFT');
		$this->db->where('P.fk_id_visitante', $arrData["idVisitante"]);
		$this->db->where('V.state', 1);
		$this->db->where('P.fk_id_visitante IS NOT NULL');
		$this->db->where("((NOW() <= P.fecha_finaliza) OR (NOW() >= I.fecha_ingreso AND I.fecha_salida IS NULL))");
		$query = $this->db->get("permisos P");
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else{
			return false;
		}
	}

	/**
	 * Guardar Acceso
	 */
	public function saveAccess($data_qr)
	{
		$idUser = $this->session->userdata("id");
		$tipo = $this->input->post('hddTipo');
		if ($tipo == 1) {
			$idFuncionario = $this->input->post('hddId');
			$idVisitante = NULL;
			$idIntegrante = NULL;
			$idTipoFuncionario = $this->input->post('hddIdTipoFun');
			if ($idTipoFuncionario == 1) {
				$fechaDesde = NULL;
				$fechaHasta = NULL;
				$motivo = NULL;
			} else {
				$fechaDesde = $this->input->post('start_date') . ' 00:00:00';
				$fechaHasta = $this->input->post('finish_date') . ' 23:59:59';
				$motivo = NULL;
			}
		}
		if ($tipo == 2) {
			$idFuncionario = NULL;
			$idVisitante = $this->input->post('hddId');
			$idIntegrante = NULL;
			$fechaDesde = $this->input->post('start_date') . ' ' . $this->input->post('start_time') . ':00';
			$fechaHasta = $this->input->post('start_date') . ' ' . $this->input->post('finish_time') . ':00';
			$motivo = $this->input->post('motivo');
		}
		if ($tipo == 3) {
			$idFuncionario = NULL;
			$idVisitante = NULL;
			$idIntegrante = $this->input->post('hddId');
			$fechaDesde = $this->input->post('start_date') . ' 00:00:00';
			$fechaHasta = $this->input->post('finish_date') . ' 23:59:59';
			$motivo = NULL;
		}
		$rutaImagen = $data_qr['rutaImagen'];
		$llave = $data_qr['llave'];
		$data = array(
			'fk_id_user' => $idUser,
			'fk_id_funcionario' => $idFuncionario,
			'fk_id_visitante' => $idVisitante,
			'fk_id_integrante' => $idIntegrante,
			'fecha_entrada' => $fechaDesde,
			'fecha_finaliza' => $fechaHasta,
			'motivo' => $motivo,
			'qr_code_img_doc' => $rutaImagen,
			'qr_code_llave_doc' => $llave,
			'estado' => 1
		);
		$query = $this->db->insert('permisos', $data);
		$id_permiso = $this->db->insert_id();
		if ($query) {
			return $id_permiso;
		} else {
			return false;
		}
	}

	/**
	 * Consultar Accesos X Permisos
	 */
	public function get_access_by_permissions($arrData)
	{
		$this->db->select();
		if ($arrData['tipo'] == 1) {
			$this->db->join('funcionarios F', 'F.id_funcionario = P.fk_id_funcionario', 'INNER');
			$this->db->join('param_tipo_documento D', 'D.id_tipo_documento = F.fk_id_tipo_documento', 'INNER');
			$this->db->join('param_tipo_funcionario TF', 'TF.id_tipo_funcionario = F.fk_id_tipo_funcionario', 'INNER');
			$this->db->join('param_cargo C', 'C.id_cargo = F.fk_id_cargo', 'INNER');
		}
		if ($arrData['tipo'] == 2) {
			$this->db->join('visitantes V', 'V.id_visitante = P.fk_id_visitante', 'INNER');
			$this->db->join('param_tipo_documento D', 'D.id_tipo_documento = V.fk_id_tipo_documento', 'INNER');
		}
		if ($arrData['tipo'] == 3) {
			$this->db->join('integrantes I', 'I.id_integrante = P.fk_id_integrante', 'INNER');
			$this->db->join('escuelas E', 'E.id_escuela = I.fk_id_escuela', 'INNER');
			$this->db->join('param_tipo_funcion F', 'F.id_tipo_funcion = I.fk_id_tipo_funcion', 'INNER');
			$this->db->join('param_tipo_documento D', 'D.id_tipo_documento = I.fk_id_tipo_documento', 'INNER');
		}
		if (array_key_exists("idPermiso", $arrData)) {
			$this->db->where('P.id_permiso', $arrData["idPermiso"]);
		}
		if (array_key_exists("numeroDocumento", $arrData)) {
			$this->db->where('I.numero_documento', $arrData["numeroDocumento"]);
		}
		$query = $this->db->get("permisos P");
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else{
			return false;
		}
	}

	/**
	 * Listado Permisos Funcionarios
	 */
	public function get_permissionsFun()
	{			
		$this->db->select();
		$this->db->join('funcionarios F', 'F.id_funcionario = P.fk_id_funcionario', 'INNER');
		$this->db->join('param_tipo_documento D', 'D.id_tipo_documento = F.fk_id_tipo_documento', 'INNER');
		$this->db->join('param_tipo_funcionario T', 'T.id_tipo_funcionario = F.fk_id_tipo_funcionario', 'INNER');
		$this->db->join('param_cargo C', 'C.id_cargo = F.fk_id_cargo', 'INNER');
		$this->db->where('F.state', 1);
		$this->db->where('P.fk_id_funcionario IS NOT NULL');
		$this->db->where("((P.fecha_entrada IS NULL AND P.fecha_finaliza IS NULL) OR (NOW() BETWEEN P.fecha_entrada AND P.fecha_finaliza))");
		$this->db->where('P.estado', 1);
		$query = $this->db->get("permisos P");
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else{
			return false;
		}
	}

	/**
	 * Listado Permisos Visitantes
	 */
	public function get_permissionsVis()
	{			
		$this->db->select();
		$this->db->join('visitantes V', 'V.id_visitante = P.fk_id_visitante AND P.estado = 1', 'INNER');
		$this->db->join('param_tipo_documento D', 'D.id_tipo_documento = V.fk_id_tipo_documento', 'INNER');
		$this->db->join('ingresos I', 'V.id_visitante = I.fk_id_visitante', 'LEFT');
		$this->db->where('V.state', 1);
		$this->db->where('P.fk_id_visitante IS NOT NULL');
		$this->db->where("((NOW() <= P.fecha_finaliza) OR (NOW() >= I.fecha_ingreso AND I.fecha_salida IS NULL))");
		$query = $this->db->get("permisos P");
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else{
			return false;
		}
	}

	/**
	 * Listado Permisos Integrantes
	 */
	public function get_permissionsInt()
	{			
		$this->db->select();
		$this->db->join('Integrantes I', 'I.id_integrante = P.fk_id_integrante', 'INNER');
		$this->db->join('escuelas E', 'E.id_escuela = I.fk_id_escuela', 'INNER');
		$this->db->join('param_tipo_documento D', 'D.id_tipo_documento = I.fk_id_tipo_documento', 'INNER');
		$this->db->join('param_tipo_funcion F', 'F.id_tipo_funcion = I.fk_id_tipo_funcion', 'INNER');
		$this->db->where('I.state', 1);
		$this->db->where('P.fk_id_integrante IS NOT NULL');
		$this->db->where("NOW() BETWEEN P.fecha_entrada AND P.fecha_finaliza");
		$this->db->where('P.estado', 1);
		$query = $this->db->get("permisos P");
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else{
			return false;
		}
	}
	
	/**
	 * Eliminar Permiso
	 */
	public function delete_permissions()
	{
		$idPermiso = $this->input->post("identificador");
		$data = array(
			'estado' => 2
		);
		$this->db->where('id_permiso', $idPermiso);
		$query = $this->db->update('permisos', $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
}