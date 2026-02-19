<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("usuarios_model");
        $this->load->model("general_model");
        $this->load->helper('form');
    }
	
	/**
	 * Detalle Usuario
	 */
	public function detalle($error = '')
	{
		$idUser = $this->session->userdata("id");
		$arrParam = array(
			"idUser" => $idUser
		);
		$data['UserInfo'] = $this->usuarios_model->get_user($arrParam);
		$data['error'] = $error;
		$data["view"] = 'detalle_usuario';
		$this->load->view("layout_calendar", $data);
	}
	
    /**
	 * Cargar Foto
	 */
    function do_upload() 
	{
		$config['upload_path'] = './images/usuarios/';
		$config['overwrite'] = true;
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size'] = '3000';
		$config['max_width'] = '2024';
		$config['max_height'] = '2024';
		$idUser = $this->session->userdata("id");
		$config['file_name'] = $idUser;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload()) {
			$error = $this->upload->display_errors();
			$this->detalle($error);
		} else {
			$file_info = $this->upload->data();
			$this->_create_thumbnail($file_info['file_name']);
			$data = array('upload_data' => $this->upload->data());
			$imagen = $file_info['file_name'];
			$path = "images/usuarios/" . $imagen;
			$arrParam = array(
				"table" => "usuarios",
				"primaryKey" => "id_user",
				"id" => $idUser,
				"column" => "photo",
				"value" => $path
			);
			$this->load->model("general_model");
			$data['linkBack'] = "usuarios/detalle";
			$data['titulo'] = "<i class='fa fa-user fa-fw'></i> FOTO USUARIO";
			if($this->general_model->updateRecord($arrParam))
			{
				$data['clase'] = "alert-success";
				$data['msj'] = "Se actualizó la foto del usuario.";
			}else{
				$data['clase'] = "alert-danger";
				$data['msj'] = "Ask for help.";
			}
			$data["view"] = 'template/answer';
			$this->load->view("layout_calendar", $data);
		}
    }
	
	/**
	 * Crear Miniatura
	*/
    function _create_thumbnail($filename) 
	{
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'images/usuarios/' . $filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['new_image'] = 'images/usuarios/thumbs/';
        $config['width'] = 150;
        $config['height'] = 150;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
    }
}