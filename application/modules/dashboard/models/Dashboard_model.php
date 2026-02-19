<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	/**
	 * Consulta Ingresos Funcionarios
	 */
	public function ingresos_funcionarios()
	{
		$this->db->where('fk_id_funcionario IS NOT NULL');
		$this->db->where('((fecha_entrada IS NULL AND fecha_finaliza IS NULL) OR (NOW() BETWEEN fecha_entrada AND fecha_finaliza))');
		$this->db->where('estado', 1);
		$funcionarios = $this->db->count_all_results('permisos');
		return $funcionarios;
	}

	/**
	 * Consulta Ingresos Visitantes
	 */
	public function ingresos_visitantes()
	{
		$this->db->join('visitantes V', 'V.id_visitante = P.fk_id_visitante AND P.estado = 1', 'INNER');
		$this->db->join('ingresos I', 'V.id_visitante = I.fk_id_visitante', 'LEFT');
		$this->db->where('V.state', 1);
		$this->db->where('P.fk_id_visitante IS NOT NULL');
		$this->db->where("((NOW() <= P.fecha_finaliza) OR (NOW() >= I.fecha_ingreso AND I.fecha_salida IS NULL))");
		$visitantes = $this->db->count_all_results('permisos P');
		return $visitantes;
	}

	/**
	 * Consulta Ingresos Integrantes
	 */
	public function ingresos_integrantes()
	{
		$this->db->where('fk_id_integrante IS NOT NULL');
		$this->db->where('NOW() BETWEEN fecha_entrada AND fecha_finaliza');
		$this->db->where('estado', 1);
		$integrantes = $this->db->count_all_results('permisos');
		return $integrantes;
	}
}