<?php

class Login extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('config_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['title'] = 'Login';
		//date_default_timezone_set('Etc/GMT+3');
	}
	
	public function index()
	{
		$this->load->view('login/login_view.php');
	}
	
	public function verify()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$this->_validations();
		
		if($this->form_validation->run() == TRUE)
		{		
			$user = $this->users_model->login($username, $password);
			$wrongPassCount = $this->users_model->getWrongPassCount($username);
			if($user && $wrongPassCount < 4)
			{
				//Obtengo los permisos del usuario logueado
				// Load the ACL library and pas it the config array
				$config = array('userID'=>$user->id);
				$this->load->library('acl',$config);
				$data['permisos'] = $this->acl->get_permisos_activos();
				$data['perms'] = $this->acl->buildACL();
				$ciudad = $this->config_model->getCiudad($user->id_ciudad);
				$sess_array = array(
					'id' => $user->id,
					'username' => $user->username,
					'nombre' => $user->username,
					'mail' => $user->mail,
					'permisos' => $data['permisos'],
					'perms' => $data['perms'],
					'id_ciudad' => $user->id_ciudad,
					'logo_width' => $ciudad['logo_width'],
					'zoom' => $ciudad['zoom'],
					'latlng' => $ciudad['coordenadas']
						
				);
				$this->session->set_userdata('logged_user', $sess_array);
				$this->users_model->set_last_login($user->id);
				// Vuelvo a poner en la cantidad de login invalidos
				$this->users_model->resetWrongPass($user->id);
				parent::logActivity("LOGIN", "Usuarios", $user->id, "Se logue&oacute; el usuario: ". $user->username);
				redirect('home');
			}
			else
			{
				if ($wrongPassCount >= 3){
					$data["error"] = "El usuario fue bloqueado por demasiados intentos inv&aacute;lidos. Consulte a soporte@observatoriovial.com.ar";
					log_message('error', $wrongPassCount.' intentos invalidos. Usuario bloquedo.' );
				}
				else {
					$data["error"] = "El usuario o contrase&ntilde;a son inv&aacute;lidos";
					log_message('error', 'Login invalido por usuario o pass.');
				}
				//Sumo 1 a la cantidad de login invalido
				$this->users_model->addWrongPass($username);
				$this->load->view('login/login_view.php',$data);
			}
		}
		else 
		{
			$this->load->view('login/login_view.php');
		}
	}
	
	function _validations()
	{
		// Añadimos las reglas necesarias.
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		// Generamos el mensaje de error personalizado para la accion 'required'
		$this->form_validation->set_message('required', 'El campo %s es requerido.');
	}
	
	public function logout()
	{
		$userLogged = $this->session->userdata('logged_user');
		parent::logActivity("LOGOUT", "Usuarios", $userLogged['id'], "Se deslogue&oacute; el usuario: ". $userLogged['username']);
		$this->session->sess_destroy();
		redirect('login');
	}
	
}