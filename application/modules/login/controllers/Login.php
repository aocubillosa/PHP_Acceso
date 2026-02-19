<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("general_model");
        $this->load->helper('form');
		$this->load->helper("cookie");
    }

	/**
	 * Login
	 */
	public function index($id = 'x')
	{
		$this->session->sess_destroy();
		$this->load->view('login');
	}
	
	/**
	 * Validar Usuario
	 */
	/*public function validateUser()
	{
		$login = $this->input->post("inputLogin");
        $passwd = $this->input->post("inputPassword");
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
        	$ldapuser = $login;
        	$ldappass = ldap_escape($passwd, ".,_,-,+,*,#,$,%,&,@", LDAP_ESCAPE_FILTER);
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
				$arrParam = array(
					"login" => $login
				);
				$user = $this->login_model->validateLogin($arrParam);
				if(($user["valid"] == true)) 
				{
					$userRole = intval($user["role"]);
					$arrParam = array(
						"idRole" => $userRole
					);
					$rolInfo = $this->general_model->get_roles($arrParam);
					$sessionData = array(
						"auth" => "OK",
						"id" => $user["id"],
						"dashboardURL" => $rolInfo[0]['dashboard_url'],
						"firstname" => $user["firstname"],
						"lastname" => $user["lastname"],
						"name" => $user["firstname"] . ' ' . $user["lastname"],
						"logUser" => $user["logUser"],
						"password" => $passwd,
						"state" => $user["state"],
						"role" => $user["role"],
						"photo" => $user["photo"],
					);
					$this->session->set_userdata($sessionData);
					set_cookie('user',$login, '350000');
					$this->login_model->redireccionarUsuario();
				} else {
					$data["msj"] = "<strong>" . $login . "</strong> no esta registrado.";
					$this->session->sess_destroy();
					$this->load->view('login', $data);
				}
            }
        }
	}*/

	public function validateUser()
	{
		$login = $this->security->xss_clean($this->input->post("inputLogin"));
		$passwd = $this->security->xss_clean($this->input->post("inputPassword"));
		$arrParam = array(
			"table" => "usuarios",
			"order" => "id_user",
			"column" => "log_user",
			"id" => $login
		);
		$userExist = $this->general_model->get_basic_search($arrParam);
		if ($userExist)
		{
			$arrParam = array(
				"login" => $login,
				"passwd" => $passwd
			);
			$user = $this->login_model->validateLogin($arrParam);
			if(($user["valid"] == true)) 
			{
				$userRole = intval($user["role"]);
				$arrParam = array(
					"idRole" => $userRole
				);
				$rolInfo = $this->general_model->get_roles($arrParam);
				$sessionData = array(
					"auth" => "OK",
					"id" => $user["id"],
					"dashboardURL" => $rolInfo[0]['dashboard_url'],
					"firstname" => $user["firstname"],
					"lastname" => $user["lastname"],
					"name" => $user["firstname"] . ' ' . $user["lastname"],
					"logUser" => $user["logUser"],
					"state" => $user["state"],
					"role" => $user["role"],
					"photo" => $user["photo"]
				);
				$this->session->set_userdata($sessionData);
				set_cookie('user',$login, '350000');
				$this->login_model->redireccionarUsuario();
			} else {					
				$data["msj"] = "<strong>" . $userExist[0]["first_name"] . "</strong> esa no es su contraseña.";
				$this->session->sess_destroy();
				$this->load->view('login', $data);
			}
		} else {
			$data["msj"] = "<strong>" . $login . "</strong> no esta registrado.";
			$this->session->sess_destroy();
			$this->load->view('login', $data);
		}
	}
}