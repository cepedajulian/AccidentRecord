<?php

class Config extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('config_model');
		$this->load->model('users_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->helper('security');
		$this->load->helper('form');
		$data['title'] = 'Infracciones';
	}

	/***************************CONFIG********************************/
	public function index()
	{
		//parent::check_is_logged();
		if ($this->input->post('sendform') == 1)
			$this->saveConfig();
		else
		{
			$userLogged = $this->session->userdata('logged_user');
			$criteria['id_ciudad'] = $userLogged['id_ciudad'];
			$data['id_ciudad'] = $userLogged['id_ciudad'];
			$data['ciudad'] = $this->config_model->getCiudad($data['id_ciudad']);
			$data['title'] = 'Configuracion';
			$data['section'] = "ADMINISTRACION";
			$this->load->template('config/config_form_view.php', $data);
		}
	}
	
	private function saveConfig()
	{
		$this->_validations_save_config();
		$this->_validations_messages();
		
		$userLogged = $this->session->userdata('logged_user');
		$id_ciudad = $userLogged['id_ciudad'];
	
		$ciudad = array(
				'id' => parent::getValue($this->input->post('id')),
				'coordenadas' => parent::getValue($this->input->post('coordenadas')),
				'zoom' => parent::getValue($this->input->post('zoom')),
				'logo_width' => parent::getValue($this->input->post('logo_width'))
		);
		
		$userLogged['latlng'] = $ciudad['coordenadas'];
		$userLogged['zoom'] = $ciudad['zoom'];
		$userLogged['logo_width'] = $ciudad['logo_width'];
		$this->session->set_userdata('logged_user', $userLogged);
	
		$data['ciudad'] = $ciudad;
	
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'Configaraci&oacute;n de los datos del municipio';
			$this->load->template('config/config_form_view.php', $data);
		}
		else
		{
			$lastIdInserted = $this->config_model->save('config_ciudades', $ciudad);
	
			if ($lastIdInserted >= 0)
			{
				$this->session->set_flashdata('msg', 'La Configaraci&oacute;n fue editada correctamente');
				parent::logActivity("UPDATE", "config", $id_ciudad, "Edici&oacute;n de Configaraci&oacute;n: ".$this->input->post('ciudad'));
				redirect('config/index');
			}
			else
			{
				$data['error'] = "Error al grabar la informaci&oacute;n";
				$this->load->template('/config/config_form_view.php', $data);
			}
		}
	}
	
	private function save()
	{
		
		$config= array(
				'id' => $id,
				'clave' => $this->input->post('nroacta'),
				'descripcion' => $this->input->post('descripcion'),
				'valor' => $this->input->post('valor')
				
		);
		
		$data['config'] = $config;

		if ($this->form_validation->run() == FALSE)
		{
			if (!empty($id))
				$data['title'] = 'Edici&oacute;n de la infracci&oacute;n';
			$data['title'] = 'Alta del infracci&oacute;n';
			$this->load->template('infracciones/infracciones_form_view.php', $data);
		}
		else
		{
			$lastIdInserted = $this->config_model->save($config);
			if ($lastIdInserted >= 0)
			{
				if (empty($id)){
					// TODO: sumar la infraccion en la licencia.
					$this->session->set_flashdata('msg', 'La infracci&oacute;n fue agregada correctamente');
					parent::logActivity("ADD", "infracciones", $lastIdInserted, "Alta de Infracci&oacute;n: ".$this->input->post('nombre'));
				}
				else{
					$this->session->set_flashdata('msg', 'La infracci&oacute;n fue editada correctamente');
					parent::logActivity("UPDATE", "infracciones", $id, "Edici&oacute;n de Infracci&oacute;n: ".$this->input->post('nombre'));
				}
				redirect('infracciones');
			}
			else
			{
				$data['error'] = "Error al grabar la informaci&oacute;n";
				$this->load->template('/infracciones/infracciones_form_view.php', $data);
			}
		}

	}
	
	public function upload_file($id_ciudad)
	{
		$nextid = $this->config_model->getNextCiudadId();
		if(empty($id_ciudad))
			$id_ciudad= $nextid;
	
		$file_element_name = 'userfile';
		$config['upload_path'] = './assets/img/logos/';
		$config['allowed_types'] = 'gif|png';
		$config['max_size'] = 1024 * 8;
		$config['file_name'] = $id_ciudad;
		$config['overwrite'] = true;
		$this->load->library('upload', $config);
		$status = '';
		$msg = '';
	
		if (!$this->upload->do_upload($file_element_name))
		{
			$status = 'error';
			$msg = 'Error al subir la imagen.';
		}
		else
		{
			$data = $this->upload->data();
		}
		@unlink($_FILES[$file_element_name]);
	
		echo json_encode(array('status' => $status, 'msg' => $msg, 'filename' => $id_ciudad.".png"));
	}
	
	/***************************FUNCIONARIOS********************************/
	
	public function funcionarios($offset = 0 )
	{
		parent::check_is_logged();
		// Paginado - Inicializacion de parametros
		$criteria= $this->uri->uri_to_assoc(3); // pasa del segmento 3 en adelante a un array.
		array_pop($criteria); // Saca el ultimo segmento que es el paginado.
		$last = $this->uri->total_segments(); // Obtengo la pocision del ultimo segmento.
		$ultimo_elemento = $this->uri->segment($last);
	
		$itemsPerPage = $this->config->item('per_page');
		if (!empty($criteria['itemsPerPage']))
			$itemsPerPage = $criteria['itemsPerPage'];
		$config['per_page'] = $itemsPerPage;
	
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$data['id_ciudad'] = $userLogged['id_ciudad'];
	
		// Paginado - Configuracion
		$config['first_url'] = base_url().'index.php/config/funcionarios/'.$this->uri->assoc_to_uri($criteria).'/0';
		$config['base_url'] = base_url().'index.php/config/funcionarios/'.$this->uri->assoc_to_uri($criteria);
		$config['total_rows'] = $this->config_model->countFuncionarios("config_funcionarios", $criteria);
		$config['cur_page'] = $this->uri->segment($last);//CURRENT PAGE NUMBER -> fundamental para q funque sino se manbeaba con el criteria
			
		$config['last_link'] = '&Uacute;ltima';
		$config['first_link'] = 'Primera';
		$config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
		$config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li><span><b>";
		$config['cur_tag_close'] = "</b></span></li>";
	
		$this->pagination->initialize($config);
	
		// Obtengo los registros para la pagina actual
		$funcionarios = $this->config_model->findFuncionarios($criteria, $itemsPerPage, $ultimo_elemento);
		$data['funcionarios'] = $funcionarios;
		$data['criteria'] = $criteria;
		$data['itemsPerPage'] = $itemsPerPage;
	
		$data['permisos'] = $userLogged['permisos'];
		$data['total_rows'] = $config['total_rows'];
	
		$data['msg'] = $this->session->flashdata('msg');
		$data['error'] = $this->session->flashdata('error');
	
		$data['section'] = "LICENCIAS";
	
		$this->load->template('config/funcionarios_view.php', $data);
	}

	public function searchFuncionarios()
	{
		$orderby = $this->input->post('orderby');
		$order = $this->input->post('order');
		$searchtext = $this->input->post('searchtext');
		$itemsPerPage = $this->input->post('itemsPerPage');
		
	
		$criteria = "";
		if (!empty($orderby))
			$criteria .= "orderby/$orderby/";
		if (!empty($order))
			$criteria .= "order/$order/";
		if (!empty($searchtext))
			$criteria .= "searchtext/$searchtext/";
		if (!empty($itemsPerPage))
			$criteria .= "itemsPerPage/$itemsPerPage/";
		$criteria .= "0/";
	
		redirect('config/funcionarios/'.$criteria);
	}
	
	public function cfuncionarios()
	{
		parent::check_is_logged();
		if ($this->input->post('sendform') == 1)
			$this->saveFuncionario();
		else
		{
			$data['title'] = 'Alta dLa calles';
			$userLogged = $this->session->userdata('logged_user');
			$criteria['id_ciudad'] = $userLogged['id_ciudad'];
			$data['id_ciudad'] = $userLogged['id_ciudad'];
			$data['ciudades'] = $this->config_model->find("config_ciudades");
			$data['section'] = "ADMINISTRACION";
			$this->load->template('config/funcionarios_form_view.php', $data);
		}
	}
	
	public function ufuncionarios($id)
	{
		parent::check_is_logged();
		$data['title'] = 'Edici&oacute;n dLa calle';
		$data['funcionario'] = $this->config_model->get("config_funcionarios", $id);
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$data['id_ciudad'] = $userLogged['id_ciudad'];
		$data['ciudades'] = $this->config_model->find("config_ciudades");
		$data['section'] = "ADMINISTRACION";
		$this->load->template('/config/funcionarios_form_view.php', $data);
	}
	
	public function dfuncionarios($id){
		parent::check_is_logged();
		$funcionario = $this->config_model->get('config_funcionarios',$id);
		$this->config_model->delete('config_funcionarios', array("id"=>$id));
		$this->session->set_flashdata('msg', 'La calle '.$funcionario['funcionario'].'ha sido borrado.');
		parent::logActivity("DELETE", "config_funcionarios", $id, "Borrado dLa calle: ".$funcionario['funcionario']);
		redirect('config/funcionarios');
	}
	
	private function saveFuncionario()
	{
		$id = $this->input->post('id');
		if (empty($id))
			$id = null;
	
		$this->_validations_save_funcionario();
		$this->_validations_messages();
	
		$userLogged = $this->session->userdata('logged_user');
	
		$action = $this->input->post('action');
	
		$id_ciudad = $userLogged['id_ciudad'];
		if (empty($id_ciudad))
			$id_ciudad =  $this->input->post('id_ciudad');
		
		$funcionario = array(
				'id' => $id,
				'numero' => $this->input->post('numero'),
				'funcionario' => parent::getValue($this->input->post('funcionario')),
				'email' => parent::getValue($this->input->post('email')),
				'celular' => parent::getValue($this->input->post('celular')),
				'organismo' => parent::getValue($this->input->post('organismo')),
				'cargo' => parent::getValue($this->input->post('cargo')),
				'id_ciudad' => $id_ciudad
	
		);
	
		$data['funcionario'] = $funcionario;
	
		if ($this->form_validation->run() == FALSE)
		{
			if (!empty($id))
				$data['title'] = 'Edici&oacute;n de funcionarios';
			$data['title'] = 'Alta de funcionarios';
			$this->load->template('config/funcionarios_form_view.php', $data);
		}
		else
		{
			$lastIdInserted = $this->config_model->save('config_funcionarios', $funcionario);
				
			if ($lastIdInserted >= 0)
			{
				if (empty($id)){
					$this->session->set_flashdata('msg', 'La calle fue agregado correctamente');
					parent::logActivity("ADD", "funcionarios", $lastIdInserted, "Alta de funcionarios: ".$this->input->post('funcionario'));
				}
				else{
					$this->session->set_flashdata('msg', 'La calle fue editado correctamente');
					parent::logActivity("UPDATE", "funcionarios", $id, "Edici&oacute;n de funcionarios: ".$this->input->post('funcionario'));
				}
				redirect('config/funcionarios');
			}
			else
			{
				$data['error'] = "Error al grabar la informaci&oacute;n";
				$this->load->template('/funcionarios/funcionarios_form_view.php', $data);
			}
		}
	}
	
	/***************************CALLES********************************/
	
	public function calles($offset = 0 )
	{
		parent::check_is_logged();
		// Paginado - Inicializacion de parametros
		$criteria= $this->uri->uri_to_assoc(3); // pasa del segmento 3 en adelante a un array.
		array_pop($criteria); // Saca el ultimo segmento que es el paginado.
		$last = $this->uri->total_segments(); // Obtengo la pocision del ultimo segmento.
		$ultimo_elemento = $this->uri->segment($last);
	
		$itemsPerPage = $this->config->item('per_page');
		if (!empty($criteria['itemsPerPage']))
			$itemsPerPage = $criteria['itemsPerPage'];
		$config['per_page'] = $itemsPerPage;
	
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$id_ciudad = $userLogged['id_ciudad'];
		$data['id_ciudad'] = $id_ciudad;
		$data['localidades'] = $this->config_model->findLocalidades($id_ciudad);
		
		// Paginado - Configuracion
		$config['first_url'] = base_url().'index.php/config/calles/'.$this->uri->assoc_to_uri($criteria).'/0';
		$config['base_url'] = base_url().'index.php/config/calles/'.$this->uri->assoc_to_uri($criteria);
		$config['total_rows'] = $this->config_model->count("config_calles", $criteria);
		$config['cur_page'] = $this->uri->segment($last);//CURRENT PAGE NUMBER -> fundamental para q funque sino se manbeaba con el criteria
			
		$config['last_link'] = '&Uacute;ltima';
		$config['first_link'] = 'Primera';
		$config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
		$config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li><span><b>";
		$config['cur_tag_close'] = "</b></span></li>";
	
		$this->pagination->initialize($config);
	
		// Obtengo los registros para la pagina actual
		$calles = $this->config_model->findCalles($criteria, $itemsPerPage, $ultimo_elemento);
		$data['calles'] = $calles;
		$data['criteria'] = $criteria;
		$data['itemsPerPage'] = $itemsPerPage;
	
		$data['permisos'] = $userLogged['permisos'];
		$data['total_rows'] = $config['total_rows'];
	
		$data['msg'] = $this->session->flashdata('msg');
		$data['error'] = $this->session->flashdata('error');
	
		$data['section'] = "ADMINISTRACION";
	
		$this->load->template('config/calles_view.php', $data);
	}
	
	public function searchCalles()
	{
		$orderby = $this->input->post('orderby');
		$order = $this->input->post('order');
		$searchtext =  urldecode($this->input->post('searchtext'));
		$itemsPerPage = $this->input->post('itemsPerPage');
	
	
		$criteria = "";
		if (!empty($orderby))
			$criteria .= "orderby/$orderby/";
		if (!empty($order))
			$criteria .= "order/$order/";
		if (!empty($searchtext))
			$criteria .= "searchtext/$searchtext/";
		if (!empty($itemsPerPage))
			$criteria .= "itemsPerPage/$itemsPerPage/";
		$criteria .= "0/";
	
		redirect('config/calles/'.$criteria);
	}
	
	public function ccalles()
	{
		parent::check_is_logged();
		if ($this->input->post('sendform') == 1)
			$this->saveCalle();
		else
		{
			$userLogged = $this->session->userdata('logged_user');
			$criteria['id_ciudad'] = $userLogged['id_ciudad'];
			$data['id_ciudad'] = $userLogged['id_ciudad'];
			$data['ciudades'] = $this->config_model->find("config_ciudades");
			$data['localidades'] = $this->config_model->findLocalidades($data['id_ciudad']);
			$data['title'] = 'Alta de la Calle';
			$data['section'] = "ADMINISTRACION";
			$this->load->template('config/calles_form_view.php', $data);
		}
	}
	
	public function ucalles($id)
	{
		parent::check_is_logged();
		$data['title'] = 'Edici&oacute;n de Calles';
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$data['id_ciudad'] = $userLogged['id_ciudad'];
		$data['ciudades'] = $this->config_model->find("config_ciudades");
		$data['localidades'] = $this->config_model->findLocalidades($data['id_ciudad']);
		$data['calle'] = $this->config_model->get("config_calles", $id);
		$data['section'] = "ADMINISTRACION";
		$this->load->template('/config/calles_form_view.php', $data);
	}
	
	public function dcalles($id){
		parent::check_is_logged();
		$calle = $this->config_model->get('config_calles',$id);
		$this->config_model->delete('config_calles', array("id"=>$id));
		$this->session->set_flashdata('msg', 'La calle '.$calle['calle'].'ha sido borrada.');
		parent::logActivity("DELETE", "config_calles", $id, "Borrado de la calle: ".$calle['calle']);
		redirect('config/calles');
	}
	
	private function saveCalle()
	{
		$id = $this->input->post('id');
		if (empty($id))
			$id = null;
	
		$this->_validations_save_calle();
		$this->_validations_messages();
	
		$userLogged = $this->session->userdata('logged_user');
	
		$action = $this->input->post('action');
	
		$id_ciudad = $userLogged['id_ciudad'];
		if (empty($id_ciudad))
			$id_ciudad =  $this->input->post('id_ciudad');
		
		$calle = array(
				'id' => $id,
				'calle' => parent::getValue($this->input->post('calle')),
				'id_localidad' => parent::getValue($this->input->post('id_localidad')),
				'id_ciudad' => $id_ciudad
	
		);
	
		$localidad = $this->config_model->get("config_localidades", $calle['id_localidad']);
		$data['calle'] = $calle;
	
		if ($this->form_validation->run() == FALSE)
		{
			if (!empty($id))
				$data['title'] = 'Edici&oacute;n de calles';
			$data['title'] = 'Alta de calles';
			$this->load->template('config/calles_form_view.php', $data);
		}
		else
		{
			$calleExistente = $this->config_model->existeCalle($calle['id_localidad'], $calle['calle']);
			if (empty($id) && $calleExistente == null || !empty($id) && $id == $calleExistente['id'] ){
				$lastIdInserted = $this->config_model->save('config_calles', $calle);
		
				if ($lastIdInserted >= 0)
				{
					if (empty($id)){
						$this->session->set_flashdata('msg', 'La calle fue agregado correctamente');
						parent::logActivity("ADD", "calles", $lastIdInserted, "Alta de calles: ".$this->input->post('calle'));
					}
					else{
						$this->session->set_flashdata('msg', 'La calle fue editado correctamente');
						parent::logActivity("UPDATE", "calles", $id, "Edici&oacute;n de calles: ".$this->input->post('calle'));
					}
					redirect('config/calles');
				}
			}
			else
			{
				$data['localidades'] = $this->config_model->findLocalidades($id_ciudad);
				$data['error'] = "Ya existe la calle ".$calle['calle']." para la localidad ".$localidad['localidad'] ;
				$this->load->template('/config/calles_form_view.php', $data);
			}
		}
	}
	
	public function importcalles()
	{
		parent::check_is_logged();
		if ($this->input->post('sendform') == 1)
		{
			$data = $this->doImportCalles();
		}else{
			$data['title'] = 'Importar Calles';
			$userLogged = $this->session->userdata('logged_user');
			$id_ciudad = $userLogged['id_ciudad'];
			$data['localidades'] = $this->config_model->findLocalidades($id_ciudad);
			$this->load->template('config/calles_import_view.php', $data);
		}
	}
	
	public function doImportCalles()
	{
		$userLogged = $this->session->userdata('logged_user');
		$id_ciudad = $userLogged['id_ciudad'];
		$id_localidad = parent::getValue($this->input->post('id_localidad'));
	
		$name	  = $_FILES['userfile']['name'];
		$tname 	  = $_FILES['userfile']['tmp_name'];
	
		if (!empty($tname)){
			$this->load->library('excel');
			$objPHPExcel = PHPExcel_IOFactory::load($tname);
		
			$procesados = 0;
			$nuevas = 0;
			$repetidas = 0;
		
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow(); // e.g. 10
		
				for ($row = 1; $row <= $highestRow; ++ $row) {
		
					$cell = $worksheet->getCellByColumnAndRow(0, $row);
					$calle = trim(($cell->getValue()));
		
					$calleObj = array();
					$calleObj['calle'] = $calle;
					$calleObj['id_localidad'] = $id_localidad;
					$calleObj['id_ciudad'] = $id_ciudad;
		
					if (!empty($calle)){
						if ($this->config_model->existeCalle($id_localidad, $calle) == null){
							$this->config_model->save("config_calles", $calleObj);
							$nuevas++;
						}else{
							$repetidas++;
						}
						$procesados++;
					}
				}
	
			}
		
			$data['title'] = 'Importar Info de Calles';
			$this->session->set_flashdata('nuevas', $nuevas);
			$this->session->set_flashdata('repetidas', $repetidas);
			$this->session->set_flashdata('total', $procesados);
		}
		else{
			$this->session->set_flashdata('error', "Seleccione el archivo con las calles a importar.");
		}
		redirect('config/calles');
	}
	
	/***************************LOCALIDADES********************************/
	
	function localidades(){
		$data['section'] = "LOCALIDADES";
		$userLogged = $this->session->userdata('logged_user');
		$data['permisos'] = $userLogged['permisos'];
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$id_ciudad = $userLogged['id_ciudad'];
		$data['ciudad'] = $this->config_model->get("config_ciudades", $id_ciudad);
		$data['localidades'] = $this->config_model->findLocalidades($id_ciudad);
		$this->load->template('config/localidades_view.php', $data);
	}
	
	public function clocalidades()
	{
		parent::check_is_logged();
		if ($this->input->post('sendform') == 1)
			$this->saveLocalidad();
		else
		{
			$data['title'] = 'Alta de localidades';
			$userLogged = $this->session->userdata('logged_user');
			$criteria['id_ciudad'] = $userLogged['id_ciudad'];
			$id_ciudad = $userLogged['id_ciudad'];
			if (!empty($id_ciudad)){
				$data['id_ciudad'] = $id_ciudad;
				$data['ciudad'] = $this->config_model->getCiudad($data['id_ciudad']);
			}
			$data['ciudades'] = $this->config_model->find("config_ciudades");
			$data['section'] = "ADMINISTRACION";
			$this->load->template('config/localidades_form_view.php', $data);
		}
	}
	
	public function ulocalidades($id_localidad)
	{
		parent::check_is_logged();
		$data['title'] = 'Edici&oacute;n de localidades';
		$data['localidad'] = $this->config_model->get("config_localidades", $id_localidad);
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$id_ciudad = $userLogged['id_ciudad'];
		if (!empty($id_ciudad)){
			$data['id_ciudad'] = $id_ciudad;
			$data['ciudad'] = $this->config_model->getCiudad($data['id_ciudad']);
		}
		$data['section'] = "ADMINISTRACION";
		$this->load->template('/config/localidades_form_view.php', $data);
	}
	
	public function dlocalidades($id_localidad){
		parent::check_is_logged();
		$localidad = $this->config_model->get('config_localidades',$id_localidad);
		$this->config_model->delete('config_localidades', array("id"=>$id_localidad));
		$this->session->set_flashdata('msg', 'La localidad '.$localidad['localidad'].'ha sido borrada.');
		parent::logActivity("DELETE", "config_localidades", $id_localidad, "Borrado de la localidad: ".$localidad['localidad']);
		redirect('config/localidades');
	}
	
	private function saveLocalidad()
	{
		$id = $this->input->post('id');
		if (empty($id))
			$id = null;
	
		$this->_validations_save_localidad();
		$this->_validations_messages();
	
		$userLogged = $this->session->userdata('logged_user');
	
		$action = $this->input->post('action');
	
		$id_ciudad = $userLogged['id_ciudad'];
		if (empty($id_ciudad))
			$id_ciudad =  $this->input->post('id_ciudad');
	
		$localidad = array(
				'id' => $id,
				'localidad' => parent::getValue($this->input->post('localidad')),
				'id_ciudad' => $id_ciudad
		);
	
		$data['localidad'] = $localidad;
	
		if ($this->form_validation->run() == FALSE)
		{
			if (!empty($id))
				$data['title'] = 'Edici&oacute;n de localidades';
			$data['title'] = 'Alta de localidades';
			$this->load->template('config/localidades_form_view.php', $data);
		}
		else
		{
			$localidadExistente = $this->config_model->existeLocalidad($localidad['localidad'], $id_ciudad);
			if (empty($id) && $localidadExistente == null || !empty($id) && $id == $localidadExistente['id'] ){
				$lastIdInserted = $this->config_model->save('config_localidades', $localidad);
				if ($lastIdInserted >= 0)
				{
					if (empty($id)){
						$this->session->set_flashdata('msg', 'La localidad fue agregada correctamente');
						parent::logActivity("ADD", "localidades", $lastIdInserted, "Alta de localidades: ".$this->input->post('localidad'));
					}
					else{
						$this->session->set_flashdata('msg', 'La localidad fue editada correctamente');
						parent::logActivity("UPDATE", "localidades", $id, "Edici&oacute;n de localidades: ".$this->input->post('localidad'));
					}
					redirect('config/localidades');
				}
				else
				{
					$data['error'] = "Error al grabar la informaci&oacute;n";
					$this->load->template('/config/localidades_form_view.php', $data);
				}
			}
			else 
			{
				$data['ciudad'] = $this->config_model->getCiudad($id_ciudad);
				$data['error'] = "La localidad ya se encuentra registrada en el sistema.";
				$this->load->template('/config/localidades_form_view.php', $data);
			}
		}
	}
	
	public function importlocalidades()
	{
		parent::check_is_logged();
		if ($this->input->post('sendform') == 1)
		{
			$data = $this->doImportLocalidades();
		}else{
			$data['title'] = 'Importar Localidades';
			$userLogged = $this->session->userdata('logged_user');
			$id_ciudad = $userLogged['id_ciudad'];
			$this->load->template('config/localidades_import_view.php', $data);
		}
	}
	
	public function doImportLocalidades()
	{
		$userLogged = $this->session->userdata('logged_user');
		$id_ciudad = $userLogged['id_ciudad'];
	
		$name	  = $_FILES['userfile']['name'];
		$tname 	  = $_FILES['userfile']['tmp_name'];
	
		$this->load->library('excel');
		$objPHPExcel = PHPExcel_IOFactory::load($tname);
	
		$procesados = 0;
		$nuevas = 0;
		$repetidas = 0;
	
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$highestRow = $worksheet->getHighestRow(); // e.g. 10
	
			for ($row = 1; $row <= $highestRow; ++ $row) {
	
				$cell = $worksheet->getCellByColumnAndRow(0, $row);
				$localidad = trim(($cell->getValue()));
	
				$localidadObj = array();
				$localidadObj['localidad'] = $localidad;
				$localidadObj['id_ciudad'] = $id_ciudad;
	
				if (!empty($localidad)){
					if ($this->config_model->existeLocalidad($localidad, $id_ciudad) == null){
						$this->config_model->save("config_localidades", $localidadObj);
						$nuevas++;
					}else{
						$repetidas++;
					}
					$procesados++;
				}
				
			}
			
		}
	
		$data['title'] = 'Importar Info de Localidades';
		$this->session->set_flashdata('nuevas', $nuevas);
		$this->session->set_flashdata('repetidas', $repetidas);
		$this->session->set_flashdata('total', $procesados);
		redirect('config/localidades');
	}
	
	
	
	/***************************CIUDADES********************************/
	
	public function ciudades(){
		parent::check_is_logged();
		$data['section'] = "MUNICIPIOS";
		$userLogged = $this->session->userdata('logged_user');
		$data['permisos'] = $userLogged['permisos'];
		$data['ciudades'] = $this->config_model->findCiudades();
		$this->load->template('config/ciudades_view.php', $data);
	}
	
	public function cciudades()
	{
		parent::check_is_logged();
		if ($this->input->post('sendform') == 1)
			$this->saveCiudad();
		else
		{
			$data['title'] = 'Alta de Munucipios';
			$userLogged = $this->session->userdata('logged_user');
			$id_ciudad = $userLogged['id_ciudad'];
			if (empty($id_ciudad)){
				$data['section'] = "ADMINISTRACION";
				$this->load->template('config/ciudades_form_view.php', $data);
			}
		}
	}
	
	public function uciudades($id_ciudad)
	{
		parent::check_is_logged();
		$data['title'] = 'Edici&oacute;n de municipios';
		$data['ciudad'] = $this->config_model->get("config_ciudades", $id_ciudad);
		$data['section'] = "ADMINISTRACION";
		$this->load->template('/config/ciudades_form_view.php', $data);
	}
	
	public function dciudades($id_ciudad){
		parent::check_is_logged();
		$ciudad = $this->config_model->get('config_ciudades',$id_ciudad);
		$this->config_model->delete('config_ciudades', array("id"=>$id_ciudad));
		$this->session->set_flashdata('msg', 'El municipio '.$ciudad['ciudad'].'ha sido borrada.');
		parent::logActivity("DELETE", "config_ciudades", $id_ciudad, "Borrado del municipio: ".$ciudad['ciudad']);
		redirect('config/ciudades');
	}
	
	private function saveCiudad()
	{
		$id = parent::getValue($this->input->post('id'));
		$this->_validations_save_ciudad();
		$this->_validations_messages();
	
		$userLogged = $this->session->userdata('logged_user');
	
		$ciudad = array(
				'id' => $id,
				'ciudad' => parent::getValue($this->input->post('ciudad')),
				'coordenadas' => parent::getValue($this->input->post('coordenadas')),
				'zoom' => parent::getValue($this->input->post('zoom')),
				'logo_width' => parent::getValue($this->input->post('logo_width'))
		);
	
		$data['ciudad'] = $ciudad;
	
		if ($this->form_validation->run() == FALSE)
		{
			if (!empty($id))
				$data['title'] = 'Edici&oacute;n de municipios';
			$data['title'] = 'Alta de municipios';
			$this->load->template('config/ciudades_form_view.php', $data);
		}
		else
		{
			$ciudadExistente = $this->config_model->existeCiudad($ciudad['ciudad']);
			if (empty($id) && $ciudadExistente == null || !empty($id) && $id == $ciudadExistente['id'] ){
				$lastIdInserted = $this->config_model->save('config_ciudades', $ciudad);
		
				if ($lastIdInserted >= 0)
				{
					if (empty($id)){
						$this->session->set_flashdata('msg', 'El municipio fue agregada correctamente');
						parent::logActivity("ADD", "ciudades", $lastIdInserted, "Alta de municipios: ".$this->input->post('ciudad'));
					}
					else{
						$this->session->set_flashdata('msg', 'El municipio fue editada correctamente');
						parent::logActivity("UPDATE", "ciudades", $id, "Edici&oacute;n de municipios: ".$this->input->post('ciudad'));
					}
					redirect('config/ciudades');
				}
				else
				{
					$data['error'] = "Error al grabar la informaci&oacute;n";
					$this->load->template('/config/ciudades_form_view.php', $data);
				}
			}
			else
			{
				$data['error'] = "El municipio ya se encuentra registrado en el sistema.";
				$this->load->template('/config/ciudades_form_view.php', $data);
			}
		}
	}
	
	/***************************RUTAS********************************/
	
	function rutas(){
		$data['section'] = "RUTAS";
		$userLogged = $this->session->userdata('logged_user');
		$data['permisos'] = $userLogged['permisos'];
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$id_ciudad = $userLogged['id_ciudad'];
		$data['ciudad'] = $this->config_model->get("config_ciudades", $id_ciudad);
		$data['rutas'] = $this->config_model->findRutas($id_ciudad);
		$this->load->template('config/rutas_view.php', $data);
	}
	
	public function crutas()
	{
		parent::check_is_logged();
		if ($this->input->post('sendform') == 1)
			$this->saveRuta();
		else
		{
			$data['title'] = 'Alta de rutas';
			$data['section'] = "ADMINISTRACION";
			$this->load->template('config/rutas_form_view.php', $data);
		}
	}
	
	public function urutas($id_ruta)
	{
		parent::check_is_logged();
		$data['title'] = 'Edici&oacute;n de rutas';
		$data['ruta'] = $this->config_model->get("config_rutas", $id_ruta);
		$data['section'] = "ADMINISTRACION";
		$this->load->template('/config/rutas_form_view.php', $data);
	}
	
	public function drutas($id_ruta){
		parent::check_is_logged();
		$ruta = $this->config_model->get('config_rutas', $id_ruta);
		$this->config_model->delete('config_rutas', array("id"=> $id_ruta));
		$this->session->set_flashdata('msg', 'La ruta '.$ruta['ruta'].'ha sido borrada.');
		parent::logActivity("DELETE", "config_rutas", $id_ruta, "Borrado de la ruta: ".$ruta['ruta']);
		redirect('config/rutas');
	}
	
	private function saveRuta()
	{
		$id = $this->input->post('id');
		if (empty($id))
			$id = null;
	
		$this->_validations_save_ruta();
		$this->_validations_messages();
	
		$userLogged = $this->session->userdata('logged_user');
	
		$action = $this->input->post('action');
	
		$ruta = array(
				'id' => $id,
				'ruta' => parent::getValue($this->input->post('ruta'))
		);
	
		$data['ruta'] = $ruta;
	
		if ($this->form_validation->run() == FALSE)
		{
			if (!empty($id))
				$data['title'] = 'Edici&oacute;n de rutas';
			$data['title'] = 'Alta de rutas';
			$this->load->template('config/rutas_form_view.php', $data);
		}
		else
		{
			$rutaExistente = $this->config_model->existeRuta($ruta['ruta']);
			if (empty($id) && $rutaExistente == null || !empty($id) && $id == $rutaExistente['id'] ){
				$lastIdInserted = $this->config_model->save('config_rutas', $ruta);
				
				if ($lastIdInserted >= 0)
				{
					if (empty($id)){
						$this->session->set_flashdata('msg', 'La ruta fue agregada correctamente');
						parent::logActivity("ADD", "rutas", $lastIdInserted, "Alta de rutas: ".$this->input->post('ruta'));
					}
					else{
						$this->session->set_flashdata('msg', 'La ruta fue editada correctamente');
						parent::logActivity("UPDATE", "rutas", $id, "Edici&oacute;n de rutas: ".$this->input->post('ruta'));
					}
					redirect('config/rutas');
				}
				else
				{
					$data['error'] = "Error al grabar la informaci&oacute;n";
					$this->load->template('/config/rutas_form_view.php', $data);
				}
			}else
			{
				$data['error'] = "La ruta ya se encuentra registrada en el sistema.";
				$this->load->template('/config/rutas_form_view.php', $data);
			}
		}
	}
	
	public function importrutas()
	{
		parent::check_is_logged();
		if ($this->input->post('sendform') == 1)
		{
			$data = $this->doImportRutas();
		}else{
			$data['title'] = 'Importar Rutas';
			$userLogged = $this->session->userdata('logged_user');
			$id_ciudad = $userLogged['id_ciudad'];
			$this->load->template('config/rutas_import_view.php', $data);
		}
	}
	
	public function doImportRutas()
	{
		$userLogged = $this->session->userdata('logged_user');
		$id_ciudad = $userLogged['id_ciudad'];
	
		$name	  = $_FILES['userfile']['name'];
		$tname 	  = $_FILES['userfile']['tmp_name'];
	
		$this->load->library('excel');
		$objPHPExcel = PHPExcel_IOFactory::load($tname);
	
		$procesados = 0;
		$nuevas = 0;
		$repetidas = 0;
	
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$highestRow = $worksheet->getHighestRow(); // e.g. 10
	
			for ($row = 1; $row <= $highestRow; ++ $row) {
	
				$cell = $worksheet->getCellByColumnAndRow(0, $row);
				$ruta = trim(($cell->getValue()));
	
				$rutaObj = array();
				$rutaObj['ruta'] = $ruta;
	
				if (!empty($ruta)){
					if ($this->config_model->existeRuta($ruta) == null){
						$this->config_model->save("config_rutas", $rutaObj);
						$nuevas++;
					}else{
						$repetidas++;
					}
					$procesados++;
				}
				
			}
			
		}
	
		$data['title'] = 'Importar Info de Rutas';
		$this->session->set_flashdata('nuevas', $nuevas);
		$this->session->set_flashdata('repetidas', $repetidas);
		$this->session->set_flashdata('total', $procesados);
		redirect('config/rutas');
	}
	
	function _validations_save()
	{
		$this->form_validation->set_rules('nombre', 'Nombre',  'trim|required|min_length[3]|xss_clean');
	}
	
	function _validations_save_funcionario()
	{
		$this->form_validation->set_rules('funcionario', 'Nombre',  'trim|required|min_length[3]|xss_clean');
	}
	
	function _validations_save_calle()
	{
		$this->form_validation->set_rules('calle', 'Calle',  'trim|required|min_length[3]|xss_clean');
	}
	
	function _validations_save_localidad()
	{
		$this->form_validation->set_rules('localidad', 'Localidad',  'trim|required|min_length[3]|xss_clean');
	}
	
	function _validations_save_ciudad()
	{
		$this->form_validation->set_rules('ciudad', 'Municipio',  'trim|required|min_length[3]|xss_clean');
	}
	
	function _validations_save_config()
	{
		$this->form_validation->set_rules('coordenadas', 'Coordenadas',  'trim|min_length[3]|xss_clean');
	}
	
	function _validations_save_ruta()
	{
		$this->form_validation->set_rules('ruta', 'Ruta',  'trim|min_length[3]|xss_clean');
	}

	function _validations_messages()
	{
		$this->form_validation->set_message('required', 'El campo "%s" es obligatorio');
		$this->form_validation->set_message('min_length', 'El Campo "%s" debe tener un M&iacute;nimo de %d Caracteres');
		$this->form_validation->set_message('max_length', 'El Campo "%s" debe tener un M&aacute;ximo de %d Caracteres');
		$this->form_validation->set_message('matches', 'El confirmaci&oacute;n de la Contrase&ntilde;a no es correcta');
		$this->form_validation->set_message('valid_email', 'El E-Mail no tiene un formato v&aacute;lido');
	}

	
}