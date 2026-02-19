<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("settings_model");
        $this->load->model("entrances/entrances_model");
        $this->load->model("general_model");
		$this->load->helper('form');
    }
	
	/**
	 * Listado Usuarios
	 */
	public function users($state=1)
	{
		$data['state'] = $state;
		if($state == 1){
			$arrParam = array("filtroState" => TRUE);
		} else {
			$arrParam = array("state" => $state);
		}
		$data['info'] = $this->general_model->get_users($arrParam);
		$data["view"] = 'users';
		$this->load->view("layout_calendar", $data);
	}
	
    /**
     * Formulario Usuario
     */
    public function cargarModalUsers() 
	{
		header("Content-Type: text/plain; charset=utf-8");
		$data['information'] = FALSE;
		$data["idUser"] = $this->input->post("idUser");
		$arrParam = array("filtro" => TRUE);
		$data['roles'] = $this->general_model->get_roles($arrParam);
		$arrParam = array(
			"table" => "param_tipo_documento",
			"order" => "tipo_documento",
			"id" => "x"
		);
		$data['tipo_documento'] = $this->general_model->get_basic_search($arrParam);
		if ($data["idUser"] != 'x') {
			$arrParam = array(
				"table" => "usuarios",
				"order" => "id_user",
				"column" => "id_user",
				"id" => $data["idUser"]
			);
			$data['information'] = $this->general_model->get_basic_search($arrParam);
		}
		$this->load->view("users_modal", $data);
    }
	
	/**
	 * Guardar Usuario
	 */
	public function save_user()
	{			
		header('Content-Type: application/json');
		$data = array();
		$idUser = $this->input->post('hddId');
		$msj = "Se adicionó un nuevo Usuario!";
		if ($idUser != '') {
			$msj = "Se actualizó el Usuario!";
		}
		$num_doc = $this->input->post('numeroDocumento');
		$log_user = $this->input->post('user');
		$email_user = $this->input->post('email');
		$result_user = false;
		$result_email = false;
		$result_ldap = false;
		$arrParam = array(
			"idUser" => $idUser,
			"column" => "numero_documento",
			"value" => $num_doc
		);
		$result_documento = $this->settings_model->verifyUser($arrParam);
		$arrParam = array(
			"idUser" => $idUser,
			"column" => "log_user",
			"value" => $log_user
		);
		$result_user = $this->settings_model->verifyUser($arrParam);
		$arrParam = array(
			"idUser" => $idUser,
			"column" => "email",
			"value" => $email_user
		);
		$result_email = $this->settings_model->verifyUser($arrParam);
		$data["state"] = $this->input->post('state');
		if ($idUser == '') {
			$data["state"] = 1;
			$arrParam = array(
				"table" => "parametros",
				"order" => "id_parametro",
				"id" => "x"
			);
			$parametric = $this->general_model->get_basic_search($arrParam);
			$ldap_host = $parametric[6]["parametro_valor"];
			$ldap_port = $parametric[7]["parametro_valor"];
			$ldap_domain = $parametric[8]["parametro_valor"];
			$ldap_binddn = $parametric[9]["parametro_valor"];
			$ds = ldap_connect("$ldap_host", "$ldap_port") or die("No es posible conectar con el directorio activo.");
	        if (!$ds) {
	            echo "<br /><h4>Servidor LDAP no disponible</h4>";
	            @ldap_close($ds);
	        } else {
	        	$ldapuser = $this->session->userdata('logUser');
				$ldappass = ldap_escape($this->session->userdata('password'), ".,_,-,+,*,#,$,%,&,@", LDAP_ESCAPE_FILTER);
	            $ldapdominio = "$ldap_domain";
	            $ldapusercn = $ldapdominio . "\\" . $ldapuser;
	            $binddn = "$ldap_binddn";
	            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        		ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
	            $r = @ldap_bind($ds, $ldapusercn, $ldappass);
	            if (!$r) {
	                @ldap_close($ds);
	                $data["msj"] = "Error de autenticación. Por favor revisar usuario y contraseña de red.";
	                $this->session->sess_destroy();
					$this->load->view('login', $data);
	            } else {
	            	$filter = "(&(sAMAccountName=" . $log_user . ")(mail=" . $email_user . "))";
	            	$attributes = array('sAMAccountName', 'mail');
	            	$result = @ldap_search($ds, $binddn, $filter, $attributes);
	            	if (@ldap_count_entries($ds, $result) == 1) {
	            		$result_ldap = false;
	            	} else {
	            		$result_ldap = true;
	            	}
	            }
	        }
		}
		if ($result_documento || $result_user || $result_email || $result_ldap)
		{
			$data["result"] = "error";
			if($result_documento)
			{
				$data["mensaje"] = " Error. El número de documento ya existe.";
			}
			if($result_user)
			{
				$data["mensaje"] = " Error. El usuario ya existe.";
			}
			if($result_email)
			{
				$data["mensaje"] = " Error. El correo ya existe.";
			}
			if($result_user && $result_email)
			{
				$data["mensaje"] = " Error. El usuario y el correo ya existen.";
			}
			if ($result_ldap) {
				$data["mensaje"] = " Error. El usuario no existe en el directorio activo.";
			}
		} else {
			if ($this->settings_model->saveUser()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}
		}
		echo json_encode($data);
    }

    /**
	 * Listado Funcionarios
	 */
	public function employees($state=1)
	{
		$data['state'] = $state;
		if($state == 1){
			$arrParam = array("filtroState" => TRUE);
		} else {
			$arrParam = array("state" => $state);
		}
		$data['info'] = $this->general_model->get_employees($arrParam);
		$data["view"] = 'employees';
		$this->load->view("layout_calendar", $data);
	}
	
    /**
     * Formulario Funcionario
     */
    public function cargarModalEmployees() 
	{
		header("Content-Type: text/plain; charset=utf-8");
		$data['information'] = FALSE;
		$data["idEmployee"] = $this->input->post("idEmployee");
		$arrParam = array(
			"table" => "param_tipo_documento",
			"order" => "tipo_documento",
			"id" => "x"
		);
		$data['tipo_documento'] = $this->general_model->get_basic_search($arrParam);
		$arrParam = array(
			"table" => "param_tipo_funcionario",
			"order" => "tipo_funcionario",
			"id" => "x"
		);
		$data['tipo_funcionario'] = $this->general_model->get_basic_search($arrParam);
		$arrParam = array(
			"table" => "param_cargo",
			"order" => "cargo",
			"id" => "x"
		);
		$data['cargo'] = $this->general_model->get_basic_search($arrParam);
		if ($data["idEmployee"] != 'x') {
			$arrParam = array(
				"table" => "funcionarios",
				"order" => "id_funcionario",
				"column" => "id_funcionario",
				"id" => $data["idEmployee"]
			);
			$data['information'] = $this->general_model->get_basic_search($arrParam);
		}
		$this->load->view("employees_modal", $data);
    }

    /**
	 * Guardar Funcionario
	 */
	public function save_employee()
	{
		header('Content-Type: application/json');
		$data = array();
		$idEmployee = $this->input->post('hddId');
		$msj = "Se adicionó un nuevo Funcionario!";
		if ($idEmployee != '') {
			$msj = "Se actualizó el Funcionario!";
		}
		$num_doc = $this->input->post('numeroDocumento');
		$arrParam = array(
			"idEmployee" => $idEmployee,
			"column" => "numero_documento",
			"value" => $num_doc
		);
		$result_documento = $this->settings_model->verifyEmployee($arrParam);
		$data["state"] = $this->input->post('state');
		if ($idEmployee == '') {
			$data["state"] = 1;
		}
		$data["result"] = "error";
		if($result_documento)
		{
			$data["mensaje"] = " Error. El número de documento ya existe.";
		} else {
			if ($this->settings_model->saveEmployee()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}
		}
		echo json_encode($data);
	}

	/**
	 * Listado Visitantes
	 */
	public function visitors($state=1)
	{
		$data['state'] = $state;
		if($state == 1){
			$arrParam = array("filtroState" => TRUE);
		} else {
			$arrParam = array("state" => $state);
		}
		$data['info'] = $this->general_model->get_visitors($arrParam);
		$data["view"] = 'visitors';
		$this->load->view("layout_calendar", $data);
	}
	
    /**
     * Formulario Visitante
     */
    public function cargarModalVisitors() 
	{
		header("Content-Type: text/plain; charset=utf-8");
		$data['information'] = FALSE;
		$data["idVisitor"] = $this->input->post("idVisitor");
		$arrParam = array(
			"table" => "param_tipo_documento",
			"order" => "tipo_documento",
			"id" => "x"
		);
		$data['tipo_documento'] = $this->general_model->get_basic_search($arrParam);
		if ($data["idVisitor"] != 'x') {
			$arrParam = array(
				"table" => "visitantes",
				"order" => "id_visitante",
				"column" => "id_visitante",
				"id" => $data["idVisitor"]
			);
			$data['information'] = $this->general_model->get_basic_search($arrParam);
		}
		$this->load->view("visitors_modal", $data);
    }

    /**
	 * Guardar Visitante
	 */
	public function save_visitor()
	{
		header('Content-Type: application/json');
		$data = array();
		$idVisitor = $this->input->post('hddId');
		$msj = "Se adicionó un nuevo Visitante!";
		if ($idVisitor != '') {
			$msj = "Se actualizó el Visitante!";
		}
		$num_doc = $this->input->post('numeroDocumento');
		$arrParam = array(
			"idVisitor" => $idVisitor,
			"column" => "numero_documento",
			"value" => $num_doc
		);
		$result_documento = $this->settings_model->verifyVisitor($arrParam);
		$data["state"] = $this->input->post('state');
		if ($idVisitor == '') {
			$data["state"] = 1;
		}
		$data["result"] = "error";
		if($result_documento)
		{
			$data["mensaje"] = " Error. El número de documento ya existe.";
		} else {
			if ($this->settings_model->saveVisitor()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}
		}
		echo json_encode($data);
	}

	/**
	 * Listado Escuelas
	 */
	public function schools($state=1)
	{
		$data['state'] = $state;
		if($state == 1){
			$arrParam = array("filtroState" => TRUE);
		} else {
			$arrParam = array("state" => $state);
		}
		$data['info'] = $this->general_model->get_schools($arrParam);
		if(!empty($data['info'])) {
			for ($i=0; $i<count($data['info']); $i++) {
				$arrParam = array("idEscuela" => $data['info'][$i]['id_escuela']);
				$members = $this->general_model->get_members($arrParam);
				if (!empty($members)) {
					$data['info'][$i]['miembros'] = count($members);
				} else {
					$data['info'][$i]['miembros'] = 0;
				}
			}
		}
		$data["view"] = 'schools';
		$this->load->view("layout_calendar", $data);
	}
	
    /**
     * Formulario Escuela
     */
    public function cargarModalSchools() 
	{
		header("Content-Type: text/plain; charset=utf-8");
		$data['information'] = FALSE;
		$data["idSchool"] = $this->input->post("idSchool");
		if ($data["idSchool"] != 'x') {
			$arrParam = array(
				"table" => "escuelas",
				"order" => "id_escuela",
				"column" => "id_escuela",
				"id" => $data["idSchool"]
			);
			$data['information'] = $this->general_model->get_basic_search($arrParam);
		}
		$this->load->view("schools_modal", $data);
    }

    /**
	 * Guardar Escuela
	 */
	public function save_school()
	{
		header('Content-Type: application/json');
		$data = array();
		$idSchool = $this->input->post('hddId');
		$msj = "Se adicionó una nueva Escuela!";
		if ($idSchool != '') {
			$msj = "Se actualizó la Escuela!";
		}
		$nit = $this->input->post('nit');
		$arrParam = array(
			"idSchool" => $idSchool,
			"column" => "nit",
			"value" => $nit
		);
		$result_nit = $this->settings_model->verifySchool($arrParam);
		$data["state"] = $this->input->post('state');
		if ($idSchool == '') {
			$data["state"] = 1;
		}
		$data["result"] = "error";
		if($result_nit)
		{
			$data["mensaje"] = " Error. El nit ya existe.";
		} else {
			if ($this->settings_model->saveSchool()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}
		}
		echo json_encode($data);
	}

	/**
	 * Listado Integrantes
	 */
	public function members($idSchool, $state=1)
	{
		$data['state'] = $state;
		$data['idSchool'] = $idSchool;
		if($state == 1){
			$arrParam = array(
				"filtroState" => TRUE,
				'idEscuela' => $idSchool
			);
		} else {
			$arrParam = array(
				"state" => $state,
				'idEscuela' => $idSchool
			);
		}
		$data['info'] = $this->general_model->get_members($arrParam);
		if ($data['info']) {
			$i = 0;
			foreach ($data['info'] as $lista):
				$arrParam = array(
					"numeroDocumento" => $lista['numero_documento'],
					"tipo" => 3
				);
				$infoPermiso = $this->entrances_model->get_access_by_permissions($arrParam);
				if ($infoPermiso) {
					$data['info'][$i]['permiso'] = $infoPermiso['id_permiso'];
				} else {
					$data['info'][$i]['permiso'] = "";
				}
				$i++;
			endforeach;
		}
		$data["view"] = 'members';
		$this->load->view("layout_calendar", $data);
	}
	
    /**
     * Formulario Integrantes
     */
    public function cargarModalMembers()
	{
		header("Content-Type: text/plain; charset=utf-8");
		$data['information'] = FALSE;
		$data["idMember"] = $this->input->post("idMember");
		$data["idSchool"] = $this->input->post("idSchool");
		$arrParam = array(
			"table" => "param_tipo_funcion",
			"order" => "tipo_funcion",
			"id" => "x"
		);
		$data['tipo_funcion'] = $this->general_model->get_basic_search($arrParam);
		$arrParam = array(
			"table" => "param_tipo_documento",
			"order" => "tipo_documento",
			"id" => "x"
		);
		$data['tipo_documento'] = $this->general_model->get_basic_search($arrParam);
		if ($data["idMember"] != 'x') {
			$arrParam = array(
				"table" => "integrantes",
				"order" => "id_integrante",
				"column" => "id_integrante",
				"id" => $data["idMember"]
			);
			$data['information'] = $this->general_model->get_basic_search($arrParam);
		}
		$this->load->view("members_modal", $data);
    }

    /**
	 * Guardar Integrante
	 */
	public function save_member()
	{
		header('Content-Type: application/json');
		$data = array();
		$idMember = $this->input->post('hddId');
		$msj = "Se adicionó un nuevo Integrante!";
		if ($idMember != '') {
			$msj = "Se actualizó el Integrante!";
		}
		$num_doc = $this->input->post('numeroDocumento');
		$arrParam = array(
			"idMember" => $idMember,
			"column" => "numero_documento",
			"value" => $num_doc
		);
		$result_documento = $this->settings_model->verifyMember($arrParam);
		$data["state"] = $this->input->post('state');
		if ($idMember == '') {
			$data["state"] = 1;
		}
		$data["result"] = "error";
		if($result_documento)
		{
			$data["mensaje"] = " Error. El número de documento ya existe.";
		} else {
			if ($this->settings_model->saveMember()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
			}
		}
		echo json_encode($data);
	}

	/**
     * Cargar Integrantes
     */
    public function subir_archivo($idSchool, $error="", $success="") 
	{
		$data["error"] = $error;
		$data["success"] = $success;
		$arrParam['idEscuela'] = $idSchool;
		$data['idEscuela'] = $idSchool;
		$infoSchools = $this->general_model->get_schools($arrParam);
		if(!empty($infoSchools)) {
			$data['escuela'] = $infoSchools[0]['nombre_escuela'];
		}
		$data["view"] = "cargar_archivo";
		$this->load->view("layout_calendar", $data);
    }

    /**
     * Cargar Archivo Integrantes
     */
    public function do_upload($idSchool)
	{
	    $arrParam['idEscuela'] = $idSchool;
	    $infoSchools = $this->general_model->get_schools($arrParam);
	    $nit = $infoSchools[0]['nit'];
	    $config['upload_path'] = './tmp/';
	    $config['overwrite'] = true;
	    $config['allowed_types'] = 'csv';
	    $config['max_size'] = '5000';
	    $config['file_name'] = $nit . '.csv';
	    $this->load->library('upload', $config);
	    if (!$this->upload->do_upload()) {
	        $error = $this->upload->display_errors();
	        $msgError = html_escape(substr($error, 3, -4));
	    } else {
	        $file_info = $this->upload->data();
	        $data = array('upload_data' => $this->upload->data());
	        $archivo = $file_info['file_name'];
	        $registros = array();
	        $errores = array();
	        if (($fichero = fopen(FCPATH . 'tmp/' . $archivo, "a+")) !== FALSE) {
	            $nombres_campos = fgetcsv($fichero, 0, ";");
	            $num_campos = count($nombres_campos);
	            $campos_esperados = ['tipo_funcion', 'tipo_documento', 'numero_documento', 'nombres', 'apellidos', 'correo', 'telefono'];
	            if ($nombres_campos !== $campos_esperados) {
	                $errores[] = 'Los campos del CSV no coinciden con los esperados: ' . implode(', ', $campos_esperados);
	            } else {
	                $x = 0;
	                while (($datos = fgetcsv($fichero, 0, ";")) !== FALSE) {
	                    $x++;
	                    $registro = array();
	                    for ($icampo = 0; $icampo < $num_campos; $icampo++) {
	                        $registro[$nombres_campos[$icampo]] = utf8_encode($datos[$icampo]);
	                    }
	                    $error_fila = $this->validar_registro($registro, $idSchool, $x);
	                    if (!empty($error_fila)) {
	                        $errores = array_merge($errores, $error_fila);
	                        continue;
	                    }
	                    $registros[] = $registro;
	                    $this->settings_model->cargar_integrantes($registro, $idSchool);
	                }
	            }
	            fclose($fichero);
	        }
	    }
	    if (!empty($msgError) || !empty($errores)) {
	        $mensaje_error = !empty($msgError) ? $msgError : '';
	        if (!empty($errores)) {
	            $mensaje_error .= ' Errores en los datos.<br>' . implode('<br>', $errores);
	        }
	        $this->subir_archivo($idSchool, $mensaje_error, '');
	    } else {
	        $success = 'El archivo se cargó correctamente.';
	        $this->subir_archivo($idSchool, '', $success);
	    }
	}

	/**
     * Validaciones Cargue Archivo
     */
	private function validar_registro($registro, $idSchool, $numero_fila)
	{
	    $errores = array();
	    $campos_numericos = ['tipo_funcion', 'tipo_documento', 'numero_documento', 'telefono'];
	    foreach ($campos_numericos as $campo) {
	        if (!isset($registro[$campo]) || !is_numeric($registro[$campo])) {
	            $errores[] = "Fila $numero_fila: El campo '$campo' debe ser numérico.";
	        }
	    }
	    if (!isset($registro['correo']) || !filter_var($registro['correo'], FILTER_VALIDATE_EMAIL)) {
	        $errores[] = "Fila $numero_fila: El campo 'correo' no tiene un formato válido de email.";
	    }
	    if (isset($registro['numero_documento']) && $this->settings_model->numero_documento_existe($registro['numero_documento'])) {
	        $errores[] = "Fila $numero_fila: El 'numero_documento' ya existe en la tabla.";
	    }
	    if (empty(trim($registro['nombres']))) {
	        $errores[] = "Fila $numero_fila: El campo 'nombres' no puede estar vacío.";
	    }
	    if (empty(trim($registro['apellidos']))) {
	        $errores[] = "Fila $numero_fila: El campo 'apellidos' no puede estar vacío.";
	    }
	    return $errores;
	}
}