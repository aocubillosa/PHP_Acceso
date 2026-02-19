<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("dashboard_model");
		$this->load->model("general_model");
		$this->load->helper('form');
    }
	
	/**
	 * Dashboard
	 * @since 14/07/2024
     * @author AOCUBILLOSA
	 */
	public function admin()
	{
		$data = array();
		$funcionarios = $this->dashboard_model->ingresos_funcionarios();
		$visitantes = $this->dashboard_model->ingresos_visitantes();
		$integrantes = $this->dashboard_model->ingresos_integrantes();
		$data['funcionarios'] = $funcionarios;
		$data['visitantes'] = $visitantes;
		$data['integrantes'] = $integrantes;
		$data["view"] = "dashboard";
		$this->load->view("layout_calendar", $data);
	}
}