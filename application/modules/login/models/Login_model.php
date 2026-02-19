<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }
    
    /**
     * Validar Login
     */
    public function validateLogin($arrData)
	{
    	$user = array();
    	$user["valid"] = false;
    	$login = str_replace(array("<",">","[","]","*","^","-","'","="),"",$arrData["login"]);
    	//$sql = "SELECT * FROM usuarios WHERE log_user = '$login'";
    	$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$arrData["passwd"]); 
		$passwd = md5($passwd);
    	$sql = "SELECT * FROM usuarios WHERE log_user = '$login' and password = '$passwd'";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach($query->result() as $row){
				$user["valid"] = true;
				$user["id"] = $row->id_user;
				$user["firstname"] = $row->first_name;
				$user["lastname"] = $row->last_name;
				$user["logUser"] = $row->log_user;
				$user["movil"] = $row->movil;
				$user["state"] = $row->state;
				$user["role"] = $row->fk_id_user_role;
				$user["photo"] = $row->photo;
    		}
    	}
    	$this->db->close();
    	return $user;
    }
	
    /**
     * Redireccionar Usuario
     */
    public function redireccionarUsuario()
	{
		$state = $this->session->userdata("state");
		$userRole = $this->session->userdata("rol");
		$dashboardURL = $this->session->userdata("dashboardURL");
    	switch($state){
    		case 0:
    				redirect("/usuarios","location",301);
    				break;
    		case 1:
					redirect($dashboardURL,"location",301);
    				break;
    		case 2:
    				$this->session->sess_destroy();
    				redirect("/login","location",301);
    				break;
    		case 99:
					$data['linkBack'] = "dashboard/";
					$data['titulo'] = "<i class='fa fa-unlock fa-fw'></i>QR CODE SCAN";
					$data["msj"] = "<strong>Error!!!</strong> This QR code doesn't have an inspection form.";
					$data["clase"] = "alert-danger";
					$data["view"] = "template/answer";
					$this->load->view("layout", $data);
    				break;
    		default:
    				$this->session->sess_destroy();
    				redirect("/login","location",301);
    				break;
    	}
    }
}