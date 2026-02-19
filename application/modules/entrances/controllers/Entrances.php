<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Entrances extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("entrances_model");
        $this->load->model("general_model");
        $this->load->helper('form');
    }

    /**
	 * Buscar Funcionarios
	 */
	public function searchEmployees()
	{
		$data["view"] = 'search_employees';
		$this->load->view("layout_calendar", $data);
	}

	/**
	 * Verificar Funcionario
	 */
	public function verifyEmployee()
	{
		header('Content-Type: application/json');
		$data = array();
		$arrParam['numeroDocumento'] = $this->input->post('documento');
		$infoEmployees = $this->general_model->get_employees($arrParam);
		if (!empty($infoEmployees)) {
			$data["result"] = true;
			if ($infoEmployees[0]['state'] == 1) {
				$data['estado'] = true;
				$arrParam['idFuncionario'] = $infoEmployees[0]['id_funcionario'];
				$infoAccess = $this->entrances_model->get_access_by_employee($arrParam);
				if (!empty($infoAccess)) {
					$data['ingreso'] = true;
				} else {
					$data['ingreso'] = false;
				}
			} else {
				$data['estado'] = false;
			}
		} else {
			$data["result"] = false;
		}
		echo json_encode($data);
	}

	/**
	 * Buscar Visitantes
	 */
	public function searchVisitors()
	{
		$data["view"] = 'search_visitors';
		$this->load->view("layout_calendar", $data);
	}

	/**
	 * Verificar Visitante
	 */
	public function verifyVisitor()
	{
		header('Content-Type: application/json');
		$data = array();
		$arrParam['numeroDocumento'] = $this->input->post('documento');
		$infoVisitors = $this->general_model->get_visitors($arrParam);
		if (!empty($infoVisitors)) {
			$data["result"] = true;
			if ($infoVisitors[0]['state'] == 1) {
				$data['estado'] = true;
				$arrParam['idVisitante'] = $infoVisitors[0]['id_visitante'];
				$infoAccess = $this->entrances_model->get_access_by_visitor($arrParam);
				if (!empty($infoAccess)) {
					$data['ingreso'] = true;
				} else {
					$data['ingreso'] = false;
				}
			} else {
				$data['estado'] = false;
			}
		} else {
			$data["result"] = false;
		}
		echo json_encode($data);
	}

	/**
	 * Buscar Escuelas
	 */
	public function searchSchools()
	{
		$data["view"] = 'search_schools';
		$this->load->view("layout_calendar", $data);
	}

	/**
	 * Verificar Escuela
	 */
	public function verifySchool()
	{
		header('Content-Type: application/json');
		$data = array();
		$arrParam['nit'] = $this->input->post('nit');
		$infoSchools = $this->general_model->get_schools($arrParam);
		if (!empty($infoSchools)) {
			$data["result"] = true;
			if ($infoSchools[0]['estado'] == 1) {
				$data['estado'] = true;
				$data['idSchool'] = $infoSchools[0]['id_escuela'];
				$arrParam['idSchool'] = $infoSchools[0]['id_escuela'];
				$infoMembers = $this->general_model->get_members($arrParam);
				if (!empty($infoMembers)) {
					$data['members'] = true;
				} else {
					$data['members'] = false;
				}
			} else {
				$data['estado'] = false;
			}
		} else {
			$data["result"] = false;
		}
		echo json_encode($data);
	}

	/**
	 * Generar Acceso
	 */
	public function generateAccess($documento, $tipo)
	{
		$data['tipo'] = $tipo;
		$data['infoEmployees'] = $data['infoVisitors'] = $data['infoMembers'] = "";
		$arrParam['numeroDocumento'] = $documento;
		if ($tipo == 1) {
			$data['infoEmployees'] = $this->general_model->get_employees($arrParam);
		}
		if ($tipo == 2) {
			$data['infoVisitors'] = $this->general_model->get_visitors($arrParam);
		}
		if ($tipo == 3) {
			$data['infoMembers'] = $this->general_model->get_members($arrParam);
		}
		$data["view"] = 'generate_access';
		$this->load->view("layout_calendar", $data);
	}

	/**
	 * Guardar Acceso
	 */
	public function save_access()
	{
		header('Content-Type: application/json');
		$data = array();
		$tipo = $this->input->post('hddTipo');
		$documento = $this->input->post('numeroDocumento');
		$pass = $this->generaPass();
        $this->load->library('ciqrcode');
        $llave = $pass . $documento;
        if ($tipo == 1) {
        	$rutaImagen = "images/funcionarios/QR/" . $llave . "_qr_code.png";
        }
        if ($tipo == 2) {
        	$rutaImagen = "images/visitantes/QR/" . $llave . "_qr_code.png";
        }
        if ($tipo == 3) {
        	$rutaImagen = "images/integrantes/QR/" . $llave . "_qr_code.png";
        }
        $params['data'] = $documento;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = FCPATH . $rutaImagen;
        $this->ciqrcode->generate($params);
        $data_qr = [
            'rutaImagen' => $rutaImagen,
            'llave' => $llave
        ];
		if ($idPermiso = $this->entrances_model->saveAccess($data_qr)) {
			$this->email($idPermiso, $tipo);
			$data["result"] = true;
			$data["permiso"] = $idPermiso;
			$data["tipo"] = $tipo;
		} else {
			$data["result"] = "error";
			$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
		}
		echo json_encode($data);
	}

	/**
	 * Generar Pass Codigo QR
	 */
	public function generaPass()
	{
		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$longitudCadena = strlen($cadena);
		$pass = "";
		$longitudPass=20;
		for($i=1; $i<=$longitudPass ; $i++) {
			$pos = rand(0,$longitudCadena-1);
			$pass .= substr($cadena,$pos,1);
		}
		return $pass;
	}

	/**
	 * Mostrar Codigo QR
	 */
	public function show_qrcode($idPermiso, $tipo)
	{
		$arrParam = array(
			"idPermiso" => $idPermiso,
			"tipo" => $tipo
		);
		$data['infoPermiso'] = $this->entrances_model->get_access_by_permissions($arrParam);
		$data["view"] = 'show_qrcode';
		$this->load->view("layout_calendar", $data);
	}

	/**
	 * Envio de Correo Electronico
     * @since 22/10/2025
     * @author AOCUBILLOSA
	 */
	public function email($idPermiso, $tipo)
	{
		$arrParam = array(
			"table" => "parametros",
			"order" => "id_parametro",
			"id" => "x"
		);
		$parametric = $this->general_model->get_basic_search($arrParam);
		$paramHost = $parametric[0]["parametro_valor"];
		$paramUsername = $parametric[1]["parametro_valor"];
		$paramPassword = $parametric[2]["parametro_valor"];
		$paramFromName = $parametric[3]["parametro_valor"];
		$arrParam = array(
			"idPermiso" => $idPermiso,
			"tipo" => $tipo
		);
		$infoPermiso = $this->entrances_model->get_access_by_permissions($arrParam);
		$subjet = 'Código QR de Acceso';
		$to = $infoPermiso['correo'];
		$msj = '<p>Estimado(a) <strong>' . $infoPermiso['nombres'] . ' ' . $infoPermiso['apellidos'] . '</strong>.</p>';
		if ($tipo == 1) {
			$msj .= '<p>Se le ha asignado un código QR personal para el ingreso a las instalaciones de nuestra institución <strong>Colegio Colombo Hebreo</strong>.</p>';
			$msj .= '<p>Por favor, conserve este correo y presente el siguiente código QR cada vez que requiera acceder al recinto.</p>';
		} else {
			$cadena = explode(' ', $infoPermiso['fecha_entrada']);
			$cadena_fecha = explode('-', $cadena[0]);
			$cadena_hora = explode(':', $cadena[1]);
			$fecha = $cadena_fecha[2] . '/' . $cadena_fecha[1] . '/' . $cadena_fecha[0];
			$hora = $cadena_hora[0] . ':' . $cadena_hora[1];
			$msj .= '<p>Le confirmamos su acceso a las instalaciones de nuestra institución <strong>Colegio Colombo Hebreo</strong> el día <strong>' . $fecha . '</strong> a las <strong>' . $hora . '</strong>.</p>';
			$msj .= '<p>Adjuntamos su código QR personal que deberá presentar en la entrada para validar su ingreso.</p>';
		}
		$msj .= '<br><br>';
		$msj .= "<img src=" . base_url($infoPermiso['qr_code_img_doc']) . " class='img-rounded' width='200' height='200'/>";
		$msj .= '<br><br>';
		$msj .= '<p><strong>Instrucciones:</strong></p>';
		$msj .= '<ul>
					<li>Presente este código QR en formato digital o impreso al ingresar.</li>
					<li>El código es de uso personal e intransferible.</li>';
		if ($tipo == 1) {
			$msj .= '<li>En caso de pérdida, comuníquese con el area de seguridad para generar un nuevo código.</li>
				</ul>';
			$msj .= '<p>Agradecemos su colaboración con las normas de acceso y seguridad.</p>';
		}
		if ($tipo == 2) {
			$msj .= '<li>El código es válido únicamente para la fecha y hora indicadas.</li>
				</ul>';
			$msj .= '<p>Gracias por su visita.</p>';
		}
		if ($tipo == 3) {
			$msj .= '<li>El código es válido únicamente para el ingreso a escuelas.</li>
				</ul>';
			$msj .= '<p>Agradecemos su colaboración con las normas de acceso y seguridad.</p>';
		}
		$mensaje = "<p>$msj</p>
					<p>Atentamente,</p>
					<p><strong>Colegio Colombo Hebreo</strong></p>
					<p>Dirección: Cra 50 # 152 A - 55 Bogotá</p>
					<p>Teléfono: +57 321 456 7306</p>
					<p>Email: admisiones@cch.edu.co</p>";
		require_once(APPPATH.'libraries/PHPMailer_5.2.4/class.phpmailer.php');
	    $mail = new PHPMailer(true);
	    try {
            $mail->IsSMTP();
            $mail->Host = $paramHost;
            $mail->SMTPSecure= "tls";
            $mail->Port = 587;
            $mail->SMTPAuth = true;
			$mail->Username = $paramUsername;
            $mail->Password = $paramPassword;
            $mail->FromName = $paramFromName;
            $mail->From = $paramUsername;
            $mail->AddAddress($to, 'Control de Acceso');
            $mail->WordWrap = 50;
            $mail->CharSet = 'UTF-8';
            $mail->IsHTML(true);
            $mail->Subject = $subjet;
            $mail->Body = $mensaje;
            $mail->SMTPDebug = 0;
            if($mail->Send()) {
            	$this->session->set_flashdata('retorno_exito', 'Creación de acceso exitoso y correo enviado.');
            	return TRUE;
            } else {
            	log_message('error', 'PHPMailer: Fallo en envío - ' . $mail->ErrorInfo);
            	$this->session->set_flashdata('retorno_error', 'Se creó el acceso, pero no se pudo enviar el correo electrónico. Error: ' . $mail->ErrorInfo);
            	return FALSE;
            }
        } catch (Exception $e) {
        	log_message('error', 'PHPMailer Exception: ' . $e->getMessage());
        	$this->session->set_flashdata('retorno_error', 'Se creó el acceso, pero no se pudo enviar el correo electrónico. Excepción: ' . $e->getMessage());
        	return FALSE;
        }
	}

	/**
	 * Listado Permisos Funcionarios
	 */
	public function permissionsFuncionarios()
	{
		$data['infoPermisosFun'] = $this->entrances_model->get_permissionsFun();
		$data['tipo'] = 1;
		$data["view"] = 'permissionsFun';
		$this->load->view("layout_calendar", $data);
	}

	/**
	 * Listado Permisos Visitantes
	 */
	public function permissionsVisitantes()
	{
		$data['infoPermisosVis'] = $this->entrances_model->get_permissionsVis();
		$data['tipo'] = 2;
		$data["view"] = 'permissionsVis';
		$this->load->view("layout_calendar", $data);
	}

	/**
	 * Listado Permisos Integrantes
	 */
	public function permissionsIntegrantes()
	{
		$data['infoPermisosInt'] = $this->entrances_model->get_permissionsInt();
		$data['tipo'] = 3;
		$data["view"] = 'permissionsInt';
		$this->load->view("layout_calendar", $data);
	}

	/**
     * Detalle Permisos
     */
    public function cargarModalPermisos()
	{
		$arrParam = array(
			"idPermiso" => $this->input->post("idPermiso"),
			"tipo" => $this->input->post("tipo")
		);
		$data['infoPermiso'] = $this->entrances_model->get_access_by_permissions($arrParam);
		$this->load->view("permisos_modal", $data);
    }

    /**
     * Eliminar Permisos
     */
    public function deletePermissions()
	{
		header('Content-Type: application/json');
		$msj = "Se eliminó el Permiso!";
		if ($this->entrances_model->delete_permissions()) {
			$data["result"] = true;
			$this->session->set_flashdata('retornoExito', '<strong>Correcto!</strong> ' . $msj);
		} else {
			$data["result"] = "error";
			$this->session->set_flashdata('retornoError', '<strong>Error!</strong> Ask for help');
		}
		echo json_encode($data);
    }
}