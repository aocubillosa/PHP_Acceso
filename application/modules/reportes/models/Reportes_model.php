<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reportes_model extends CI_Model {

	/**
	 * Consulta Turnos
	 */
	public function get_turnos($arrData)
	{
		$this->db->select();
		$this->db->join('visitantes V', 'V.id_visitante = T.fk_id_visitante', 'INNER');
		$this->db->join('param_tipo_servicio S', 'T.fk_id_tipo_servicio = S.id_tipo_servicio', 'INNER');
		$this->db->join('param_categorias C', 'T.fk_id_categoria = C.id_categoria', 'INNER');
		$this->db->join('param_estado_turno E', 'T.fk_id_estado_turno = E.id_estado_turno', 'INNER');
		$this->db->join('usuarios U', 'U.id_user = T.fk_id_user', 'LEFT');
		$this->db->join('param_tipo_documento D', 'V.fk_id_tipo_documento = D.id_tipo_documento', 'INNER');
		$this->db->join('param_genero G', 'V.fk_id_genero = G.id_genero', 'INNER');
		$this->db->join('param_nacionalidad N', 'V.fk_id_nacionalidad = N.id_nacionalidad', 'INNER');
		$this->db->where('T.fecha BETWEEN "'. $arrData["from"] .'" AND "'. $arrData["to"] .'"');
		$this->db->order_by('T.id_turno DESC');
		$query = $this->db->get('turnos T');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Consulta Atencion al Ciudadano
	 */
	public function get_atencion($arrData)
	{
		$this->db->select('*, A.nombres nombre, A.apellidos apellido, A.telefono phone, G1.genero genero1, TIMEDIFF(A.fecha_finalizacion, A.fecha_atencion) AS indicador');
		$this->db->join('visitantes V', 'V.id_visitante = A.fk_id_visitante', 'LEFT');
		$this->db->join('usuarios U', 'U.id_user = A.fk_id_user', 'LEFT');
		$this->db->join('param_tipo_servicio TS', 'A.fk_id_tipo_servicio = TS.id_tipo_servicio', 'INNER');
		$this->db->join('param_tipo_atencion TA', 'A.fk_id_tipo_atencion = TA.id_tipo_atencion', 'INNER');
		$this->db->join('param_solucion_solicitud SS', 'A.fk_id_solucion_solicitud = SS.id_solucion', 'INNER');
		$this->db->join('param_genero G1', 'A.fk_id_genero = G1.id_genero', 'LEFT');
		$this->db->join('param_genero G2', 'V.fk_id_genero = G2.id_genero', 'LEFT');
		$this->db->where('A.fecha BETWEEN "'. $arrData["from"] .'" AND "'. $arrData["to"] .'"');
		$this->db->order_by('A.id_atencion ASC');
		$query = $this->db->get('atencion A');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}





	/**
	 * Consulta Funcionarios
	 */
	public function get_employees()
	{
		$this->db->select();
		$this->db->join('permisos P', 'F.id_funcionario = P.fk_id_funcionario', 'INNER');
		$this->db->join('param_tipo_documento D', 'F.fk_id_tipo_documento = D.id_tipo_documento', 'INNER');
		$this->db->join('param_tipo_funcionario TF', 'F.fk_id_tipo_funcionario = TF.id_tipo_funcionario', 'INNER');
		$this->db->join('param_cargo C', 'F.fk_id_cargo = C.id_cargo', 'INNER');
		$this->db->where('F.state', 1);
		$this->db->order_by('F.numero_documento ASC');
		$query = $this->db->get('funcionarios F');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Consulta Visitantes
	 */
	public function get_visitors()
	{
		$this->db->select();
		$this->db->join('permisos P', 'V.id_visitante = P.fk_id_visitante', 'INNER');
		$this->db->join('param_tipo_documento D', 'V.fk_id_tipo_documento = D.id_tipo_documento', 'INNER');
		$this->db->where('V.state', 1);
		$this->db->order_by('V.numero_documento ASC');
		$query = $this->db->get('visitantes V');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	/**
	 * Consulta Integrantes
	 */
	public function get_members()
	{
		$this->db->select();
		$this->db->join('permisos P', 'I.id_integrante = P.fk_id_integrante', 'INNER');
		$this->db->join('escuelas E', 'I.fk_id_escuela = E.id_escuela', 'INNER');
		$this->db->join('param_tipo_documento D', 'I.fk_id_tipo_documento = D.id_tipo_documento', 'INNER');
		$this->db->join('param_tipo_funcion F', 'I.fk_id_tipo_funcion = F.id_tipo_funcion', 'INNER');
		$this->db->where('I.state', 1);
		$this->db->order_by('I.numero_documento ASC');
		$query = $this->db->get('integrantes I');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
}