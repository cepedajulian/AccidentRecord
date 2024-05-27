<?php


class Users extends MY_Controller  {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('users_model');
		$this->load->model('config_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->helper('security');
		$this->load->helper('form');
		$data['title'] = 'Usuarios';
		$data['section'] = "USUARIOS";
		
	}
	
	public function index($offset = 0 )
	{
		// Paginado
		$config['base_url'] = base_url().'index.php/users/index';
		$config['total_rows'] = $this->users_model->count();
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		$this->pagination->initialize($config);
		
		$userLogged = $this->session->userdata('logged_user');
		
		// Obtengo los registros para la pagina actual
		$criteria['id_ciudad'] = $userLogged['id_ciudad']; 
		$data['users'] = $this->users_model->get_users($criteria);
				
		
		$data['permisos'] = $userLogged['permisos'];
		
		$data['msg'] = $this->session->flashdata('msg');
		$data['error'] = $this->session->flashdata('error');
		
		$data['section'] = "USUARIOS";
		$this->load->template('users/users_view.php', $data);
	}
	
	public function add()
	{
		if ($this->input->post('sendform') == 1)
			$this->save();
		else
		{
			$data['title'] = 'Alta de Usuario';
			$data['roles'] = $this->users_model->get_roles();
			$userLogged = $this->session->userdata('logged_user');
			$criteria['id_ciudad'] = $userLogged['id_ciudad'];
			$data['id_ciudad'] = $userLogged['id_ciudad'];
			$data['ciudades'] = $this->config_model->find("config_ciudades"); 
			$data['section'] = "USUARIOS";
			$this->load->template('users/users_form_view.php', $data);
		}
	}
	
	public function update($id)
	{
		$data['title'] = 'Edici&oacute;n de Usuario';
		$data['user'] = $this->users_model->get_user($id);
		$data['roles'] = $this->users_model->get_roles();
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$data['id_ciudad'] = $userLogged['id_ciudad'];
		$data['ciudades'] = $this->config_model->find("config_ciudades");
		$data['section'] = "USUARIOS";
		$this->load->template('/users/users_form_view.php', $data);
	}
	
	private function save()
	{	
		$userId = parent::getValue($this->input->post('id'));
	
		$existeUser = $this->users_model->existeUsername($this->input->post('username'));
		if ($existeUser && empty($userId)){
			$this->session->set_flashdata('error', 'El nombre de usuario no est&aacute; disponible.');
			redirect('users/add');
		}
			
		
		$this->_validations_save();
		$this->_validations_messages();
		
		$userLogged = $this->session->userdata('logged_user');
		$id_ciudad = $userLogged['id_ciudad'];
		if (empty($id_ciudad))
			$id_ciudad =  parent::getValue($this->input->post('id_ciudad'));
		
		$pass = $this->input->post('password');
		$user = array(
			'id' => $userId,
			'username' => $this->input->post('username'),
			'password' => MD5($pass),
			'mail' => $this->input->post('mail'),
			'id_ciudad' => $id_ciudad
		);
		
		$data['user'] = $user;
		
		if ($this->form_validation->run() == FALSE)
		{
			if (!empty($userId))
				$data['title'] = 'Edici&oacute;n de Usuario';
			$data['title'] = 'Alta de Usuario';
			$data['roles'] = $this->users_model->get_roles();
			$this->load->template('users/users_form_view.php', $data);
		}
		else
		{
			$lastIdInserted = $this->users_model->save('users', $user);
			if ($lastIdInserted >= 0)
			{
				if (!empty($userId))
					$this->users_model->delete('user_roles', array("userID"=>$userId));
				else
					$userId = $lastIdInserted;
				$user_roles = array();
				$user_roles[] = array(
							'userID' => $userId,
							'roleID' => $this->input->post('roles'),
							'addDate' => date('Y-m-d H:i:s')
							);
				$this->users_model->insertUserRoles($user_roles, 'user_roles');
				if ($lastIdInserted > 1){
					$this->session->set_flashdata('msg', 'El usuario fue agregado correctamente');
					parent::logActivity("ADD", "users", $lastIdInserted, "Alta del usuario: ".$this->input->post('username'));
				}else{ 
					$this->session->set_flashdata('msg', 'El usuario fue editado correctamente');
					parent::logActivity("UPDATE", "users", $userId, "Edici&oacute;n del usuario: ".$this->input->post('username'));
				}
				redirect('users');
			}
			else 
			{
				$data['error'] = "Error al grabar la informaci&oacute;n";
				$this->load->template('/users/users_form_view.php', $data);
			}
		}
		
	}
	
	public function reset($id)
	{
		$this->users_model->resetWrongPass($id);
		redirect('users');
	}
	
	public function delete($id){
		$user = $this->users_model->get_user($id);
		$this->users_model->delete('users', array("id"=>$id));
		$this->users_model->delete('user_roles', array("userID"=>$id));
		$this->users_model->delete('user_perms', array("userID"=>$id));
		parent::logActivity("DELETE", "users", $id, "Borrado del usuario: ".$user['nombre']);
		$this->session->set_flashdata('msg', 'El usuario ha sido borrado.');
		redirect('users');
	}
	
	public function permisos($id)
	{
		$todosLosPermisos = $this->users_model->get_permisos();
		$data['permisos'] = $todosLosPermisos; 
		if ($this->input->post('sendform') == 1)
		{
			$this->savePermisos($id, $todosLosPermisos);
		}
		$permisos_personalizados = $this->users_model->get_permisos_user($id);
		$permisos_roles = $this->users_model->get_permisos_roles_activos_user($id);
		$data['permisos_activos'] = array_merge($permisos_roles, $permisos_personalizados);
		$data['user'] = $this->users_model->get_user($id);
		$this->load->template('users/users_permisos_view.php', $data);
		
	}
	
	private function savePermisos($userId, $todosLosPermisos)
	{
		$permisosArray = $this->input->post('permisosArray');
		$permisosArrayIndex = array();
		foreach ($permisosArray as $permiso){
			$permisosArrayIndex[$permiso] = 1;
		}
		$this->users_model->delete('user_perms', array("id"=>$userId));
		foreach ($todosLosPermisos as $permiso){
			if (isset($permisosArrayIndex[$permiso->ID]))
				$this->users_model->insertPermiso($userId, $permiso->ID, 1);
			else 
				$this->users_model->insertPermiso($userId, $permiso->ID, 0);
		}
		$this->session->set_flashdata('msg', 'Los permisos fueron modificados.');
		redirect('users');
	}
	
	public function roles()
	{
		if ($this->input->post('sendform') == 1)
		{
			$this->saveRoles();
		}
		// Obtengo los registros para la pagina actual
		$data['permisos'] = $this->users_model->get_permisos();
		$data['roles_permisos'] = $this->users_model->get_roles_permisos_activos();
		$data['roles'] = $this->users_model->get_roles();
		$data['section'] = "USUARIOS";
		$this->load->template('users/users_roles_view.php', $data);
	}
	
	private function saveRoles()
	{
		$rolesPermisosArray = $this->input->post('rolesPermisosArray');
		$this->users_model->truncate('role_perms');
		foreach ($rolesPermisosArray as $rolPermiso){
			$rolPermisoArray = explode('-',$rolPermiso);
			$this->users_model->insertRolesPermisos($rolPermisoArray[0], $rolPermisoArray[1]);
		}
		$this->session->set_flashdata('msg', 'Los roles fueron modificados.');
		redirect('users');
	}
	
	public function account()
	{
		if ($this->input->post('sendform') == 1)
		{
			$this->_validations_account();
			$this->_validations_messages();
			
			$user = array(
					'id' => $this->input->post('id'),
					'username' => $this->input->post('username'),
					'password' => MD5($this->input->post('password')),
					'mail' => $this->input->post('mail')
			);
			
			$data['user'] = $user;
			
			if ($this->form_validation->run() == FALSE)
			{
				$data['error'] = "Error, verifique los datos";
				$this->load->template('/users/users_account_view.php', $data);
			}
			else
			{
				if ($this->_validate_password($this->input->post('password_old')))
				{
					if ($this->users_model->insert($user))
					{
						$this->session->set_flashdata('msg', 'Los datos de la cuenta fueron editados correctamente.');
						redirect('home'); 
					}
					else
					{
						$data['error'] = "Error, verifique los datos";
						$this->load->template('/users/users_account_view.php', $data);
					}
				}
				else
				{
					$data['error'] = "Error, la contrase&ntilde;a actual es incorrecta.";
					$this->load->template('/users/users_account_view.php', $data);
				}
					
			}
		}
		else 
		{
			$data['user'] = $this->session->userdata('logged_user');
			$data['title'] = 'Mi cuenta';
			$data['section'] = "USUARIOS";
			$this->load->template('/users/users_account_view', $data);
		}
	}
	
	function reenviar_password()
	{
		//TODO: Ver como es mejor hacer esto, mandarla por mail o mandar un link para cambiarla directamente.	
	}
	
	function _validations_save()
	{
		$this->form_validation->set_rules('username', 'Usuario',  'trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('mail', 'E-Mail', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Contrase�a', 'trim|required|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Confirmaci�n de contrase�a', 'trim|required');

	}
	
	function _validations_account()
	{
		$this->form_validation->set_rules('username', 'Usuario',  'trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('mail', 'E-Mail', 'trim|required|valid_email');
		$this->form_validation->set_rules('password_old', 'Contrase�a anterior', 'trim|required|md5');
		$this->form_validation->set_rules('password', 'Contrase�a', 'trim|required|matches[passconf]|md5');
		$this->form_validation->set_rules('passconf', 'Confirmaci�n de contrase�a', 'trim|required');
	}
	
	function _validations_messages()
	{
		$this->form_validation->set_message('required', 'El campo "%s" es obligatorio');
		$this->form_validation->set_message('min_length', 'El Campo "%s" debe tener un M&iacute;nimo de %d Caracteres');
		$this->form_validation->set_message('max_length', 'El Campo "%s" debe tener un M&aacute;ximo de %d Caracteres');
		$this->form_validation->set_message('matches', 'El confirmaci&oacute;n de la Contrase�a no es correcta');
		$this->form_validation->set_message('valid_email', 'El E-Mail no tiene un formato v&aacute;lido');
	}
	
	function _validate_password($pass)
	{
		$id = $this->input->post('id');
		return $this->users_model->validate_password($id, $pass);
	}
}