<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("access_model");
        $this->load->model("general_model");
		$this->load->helper('form');
    }
	
	/**
	 * Listado Menu
	 */
	public function menu()
	{
		$arrParam = array();
		$data['info'] = $this->general_model->get_menu($arrParam);
		$data["view"] = 'menu';
		$this->load->view("layout_calendar", $data);
	}
	
    /**
     * Formulario Menu
     */
    public function cargarModalMenu() 
	{
		header("Content-Type: text/plain; charset=utf-8");
		$data['information'] = FALSE;
		$data["idMenu"] = $this->input->post("idMenu");	
		if ($data["idMenu"] != 'x') {
			$arrParam = array("idMenu" => $data["idMenu"]);
			$data['information'] = $this->general_model->get_menu($arrParam);
		}
		$this->load->view("menu_modal", $data);
    }
	
	/**
	 * Guardar Menu
	 */
	public function save_menu()
	{			
		header('Content-Type: application/json');
		$data = array();
		$idEnlace = $this->input->post('hddId');
		$msj = "Se adicionó un nuevo Menú!";
		if ($idEnlace != '') {
			$msj = "Se actualizó el Menú!";
		}
		if ($this->access_model->saveMenu()) {
			$data["result"] = true;
			$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
		} else {
			$data["result"] = "error";
			$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
		}
		echo json_encode($data);
    }
	
	/**
	 * Listado Links
	 */
	public function links()
	{
		$arrParam = array();
		$data['info'] = $this->general_model->get_links($arrParam);
		$data["view"] = 'links';
		$this->load->view("layout_calendar", $data);
	}
	
    /**
     * Formulario Link
     */
    public function cargarModalLink()
	{
		header("Content-Type: text/plain; charset=utf-8");
		$data['information'] = FALSE;
		$data["idLink"] = $this->input->post("idLink");
		$arrParam = array("columnOrder" => "menu_name");
		$data['menuList'] = $this->general_model->get_menu($arrParam);
		if ($data["idLink"] != 'x') {
			$arrParam = array("idLink" => $data["idLink"]);
			$data['information'] = $this->general_model->get_links($arrParam);
		}
		$this->load->view("links_modal", $data);
    }
	
	/**
	 * Guardar Link
	 */
	public function save_link()
	{
		header('Content-Type: application/json');
		$data = array();
		$idLink = $this->input->post('hddId');
		$msj = "Se adicionó un nuevo Submenú!";
		if ($idLink != '') {
			$msj = "Se actualizó el Submenú!";
		}
		if ($this->access_model->saveLink()) {
			$data["result"] = true;
			$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
		} else {
			$data["result"] = "error";
			$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
		}
		echo json_encode($data);
    }

	/**
	 * Listado Role Access
	 */
	public function role_access()
	{
		$arrParam = array();
		$data['info'] = $this->general_model->get_role_access($arrParam);
		$data["view"] = 'role_access';
		$this->load->view("layout_calendar", $data);
	}
	
    /**
     * Formulario Role Acesss
     */
    public function cargarModalRoleAccess() 
	{
		header("Content-Type: text/plain; charset=utf-8");
		$data['information'] = FALSE;
		$data['linkList'] = FALSE;
		$data["idPermiso"] = $this->input->post("idPermiso");
		$arrParam = array(
			"columnOrder" => "menu_name",
			"menuState" => 1
		);
		$data['menuList'] = $this->general_model->get_menu($arrParam);
		$arrParam = array();
		$data['roles'] = $this->general_model->get_roles($arrParam);
		if ($data["idPermiso"] != 'x') {
			$arrParam = array("idPermiso" => $data["idPermiso"]);
			$data['information'] = $this->general_model->get_role_access($arrParam);
			//busca lista de links para el menu guardado
			$arrParam = array("idMenu" => $data['information'][0]['fk_id_menu']);
			$data['linkList'] = $this->general_model->get_links($arrParam);
		}
		$this->load->view("role_access_modal", $data);
    }
	
	/**
	 * Guardar Role Access
	 */
	public function save_role_access()
	{			
		header('Content-Type: application/json');
		$data = array();
		$idPermiso = $this->input->post('hddId');
		$msj = "Se adicionó el nuevo acceso!";
		if ($idPermiso != '') {
			$msj = "Se actualizó el acceso!";
		}
		$result_access = FALSE;
		$arrParam = array(
			"idMenu" => $this->input->post('id_menu'),
			"idLink" => $this->input->post('id_link'),
			"idRole" => $this->input->post('id_role')
		);
		$result_access = $this->general_model->get_role_access($arrParam);
		if ($result_access) {
			$data["result"] = "error";
			$data["mensaje"] = " Error. El acceso ya existe.";
			$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> El acceso ya existe.');
		} else {
			if ($this->access_model->saveRoleAccess()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$data["mensaje"] = " Error. Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}
		}
		echo json_encode($data);
    }
	
	/**
	 * Listado Link Información
	 */
    public function linkListInfo() {
        header("Content-Type: text/plain; charset=utf-8");
        $idMenu = $this->input->post('idMenu');
		$arrParam = array(
			"idMenu" => $idMenu,
			"linkState" => 1
		);
		$linkList = $this->general_model->get_links($arrParam);
        echo "<option value=''>Seleccione...</option>";
        if ($linkList) {
            foreach ($linkList as $fila) {
                echo "<option value='" . $fila["id_link"] . "' >" . $fila["link_name"] . "</option>";
            }
        }
    }	
	
	/**
	 * Eliminar Role Access
	 */
	public function delete_role_access()
	{			
		header('Content-Type: application/json');
		$data = array();
		$idPermiso = $this->input->post('identificador');
		$arrParam = array(
			"table" => "param_menu_access",
			"primaryKey" => "id_access",
			"id" => $idPermiso
		);
		if ($this->general_model->deleteRecord($arrParam)) 
		{
			$data["result"] = true;
			$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> Has eliminado el acceso al enlace.');
		} else {
			$data["result"] = "error";
			$data["mensaje"] = "Error!!! Ask for help.";
			$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
		}
		echo json_encode($data);
    }
}