<?php

class Siniestros extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('siniestros_model');
		$this->load->model('config_model');
		$this->load->model('users_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->helper('security');
		$this->load->helper('form');
		$data['title'] = 'Siniestros';
		$data['section'] = "SINIESTROS";
	}

	public function index(){
		parent::check_is_logged();
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$data['id_ciudad'] = $userLogged['id_ciudad'];
		$data['ciudades'] = $this->config_model->find("config_ciudades");
		$data['localidades'] = $this->config_model->findLocalidades($userLogged['id_ciudad']);
		
		$data['tipoaccidentes'] = $this->config_model->find("config_tipoaccidentes");
		$data['tipovehiculos'] = $this->config_model->find("config_tipovehiculos");
		
		$data['permisos'] = $userLogged['permisos'];

		$data['section'] = "SINIESTROS";
		$this->load->template('siniestros/siniestros_view.php', $data);
	}
	
	public function buscar(){
		$userLogged = $this->session->userdata('logged_user');
		$data['permisos'] = $userLogged['permisos'];
		$data['id_ciudad'] = $userLogged['id_ciudad'];
		
		$filtro=$this->input->get('filtro');
		
		$data['nml'] = $this->input->get('nml');
		
		$sql="SELECT DISTINCT
					siniestros.id AS id,
					(SELECT ciudad FROM config_ciudades WHERE config_ciudades.id=siniestros.id_ciudad) AS ciudad, 
					(SELECT localidad FROM config_localidades WHERE config_localidades.id=siniestros.id_localidad) AS localidad,
					date_format(fecha, '%d-%m-%Y') AS fecha,
					LEFT(TIME(fecha),5) as tiempo,
					(SELECT tipoaccidente FROM config_tipoaccidentes WHERE id=siniestros.tipoaccidente) AS tipoaccidente,
					tipocalle as lugar,
					nro AS nro,
					calle1 AS calle1,
					calle2 AS calle2,
					calle3 as calle3,
					(SELECT COUNT(id) FROM vehiculos WHERE vehiculos.id_siniestro = siniestros.id) AS c_vehiculos,
					(SELECT COUNT(id) FROM victimas WHERE victimas.id_siniestro = siniestros.id AND victimas.lesion='FALLECIDO') AS c_fatales,
					(SELECT COUNT(id) FROM victimas WHERE victimas.id_siniestro = siniestros.id AND victimas.lesion='GRAVE') AS c_graves,
					(SELECT COUNT(id) FROM victimas WHERE victimas.id_siniestro = siniestros.id AND victimas.lesion='LEVE') AS c_leves,
					(SELECT COUNT(id) FROM victimas WHERE victimas.id_siniestro = siniestros.id AND victimas.lesion='ILESO') AS c_ilesos,
					(SELECT COUNT(id) FROM imagenes WHERE tablename='siniestros' AND imagenes.iditem = siniestros.id ) AS c_imagenes
				FROM siniestros
					LEFT JOIN vehiculos ON siniestros.id=vehiculos.id_siniestro 
					LEFT JOIN victimas ON siniestros.id=victimas.id_siniestro 
				WHERE $filtro 
				ORDER BY date_format(fecha, '%Y-%m-%d'), LEFT(TIME(fecha),5)";
		
		$data['siniestrosEncontrados']=$this->siniestros_model->SqlFree($sql);
		
		$this->load->view('siniestros/siniestros_table_view', $data);
	}
	
	public function map(){
		parent::check_is_logged();
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$data['id_ciudad'] = $userLogged['id_ciudad'];
		$data['ciudades'] = $this->config_model->find("config_ciudades");
		$data['localidades'] = $this->config_model->findLocalidades($userLogged['id_ciudad']);
		
		$data['tipoaccidentes'] = $this->config_model->find("config_tipoaccidentes");
		$data['lesiones'] = $this->config_model->find("config_lesiones");
		$data['tipovehiculos'] = $this->config_model->find("config_tipovehiculos");
		
		$data['permisos'] = $userLogged['permisos'];
		
		$latlng = $userLogged['latlng'];
		if (!empty($latlng)){
			$data['latlng'] = $latlng;
			$data['zoom'] = $userLogged['zoom'];
		}else{
			$data['latlng'] = $this->config->item('lat').','.$this->config->item('lng');
			$data['zoom'] =  $this->config->item('zoom');
		}
		
		$data['id_ciudad'] = $userLogged['id_ciudad'];
		$data['ciudades'] = $this->config_model->find("config_ciudades");

		$data['section'] = "SINIESTROS";
		$this->load->template('/siniestros/siniestros_map_view.php', $data);
	}
	
	public function mapadibujar(){
		$userLogged = $this->session->userdata('logged_user');
		$data['permisos'] = $userLogged['permisos'];
		$data['id_ciudad'] = $userLogged['id_ciudad'];
		
		$filtro=$this->input->get('filtro');
		
		$sql="SELECT DISTINCT
					latlng AS latlng,
					descripcion AS descripcion,
					siniestros.id AS id,
					(SELECT ciudad FROM config_ciudades WHERE config_ciudades.id=siniestros.id_ciudad) AS ciudad,
					(SELECT localidad FROM config_localidades WHERE config_localidades.id=siniestros.id_localidad) AS localidad,
					date_format(fecha, '%d-%m-%Y') AS fecha,
					LEFT(TIME(fecha),5) as tiempo,
					(SELECT tipoaccidente FROM config_tipoaccidentes WHERE id=siniestros.tipoaccidente) AS tipoaccidente,
					(SELECT COUNT(id) FROM vehiculos WHERE vehiculos.id_siniestro = siniestros.id) AS c_vehiculos,
					(SELECT COUNT(id) FROM victimas WHERE victimas.id_siniestro = siniestros.id AND victimas.lesion='FALLECIDO') AS c_fatales,
					(SELECT COUNT(id) FROM victimas WHERE victimas.id_siniestro = siniestros.id AND victimas.lesion='GRAVE') AS c_graves,
					(SELECT COUNT(id) FROM victimas WHERE victimas.id_siniestro = siniestros.id AND victimas.lesion='LEVE') AS c_leves,
					(SELECT COUNT(id) FROM victimas WHERE victimas.id_siniestro = siniestros.id AND victimas.lesion='ILESO') AS c_ilesos
				FROM siniestros
					LEFT JOIN vehiculos ON siniestros.id=vehiculos.id_siniestro 
					LEFT JOIN victimas ON siniestros.id=victimas.id_siniestro 
				WHERE $filtro 
				ORDER BY fecha DESC";
		
		$data['siniestrosEncontrados']=$this->siniestros_model->SqlFree($sql);
		
		$this->load->view('siniestros/siniestros_drawnmap_view', $data);
	}
	
	public function add(){
		parent::check_is_logged();
		$userLogged = $this->session->userdata('logged_user');
		
		if ($this->input->post('sendform') == 1)
			$this->save();
		else
		{
			$criteria['id_ciudad'] = $userLogged['id_ciudad'];
			$data['id_ciudad'] = $userLogged['id_ciudad'];
			$data['ciudades'] = $this->config_model->find("config_ciudades");
			$data['localidades'] = $this->config_model->findLocalidades($data['id_ciudad']);
			$data['tipoaccidentes'] = $this->config_model->find("config_tipoaccidentes");
			//$data['calles'] = $this->config_model->find("config_calles", $criteria);
			$data['rutas'] = $this->config_model->find("config_rutas");
			$data['tipocalzadas'] = $this->config_model->find("config_tipocalzadas");
			$data['climas'] = $this->config_model->find("config_climas");
			$data['horarios'] = $this->config_model->find("config_horarios");
			$data['causas'] = $this->config_model->find("config_causas");
			$data['tipovehiculos'] = $this->config_model->find("config_tipovehiculos");
			$data['edades'] = $this->config_model->find("config_edades");
			$data['fuerzas'] = $this->config_model->find("config_fuerzas");
			$data['funcionarios'] = $this->config_model->find("config_funcionarios", $criteria);
			$data['lesiones'] = $this->config_model->find("config_lesiones");
			
			$latlng = $userLogged['latlng'];
			if (!empty($latlng))
				$data['latlng'] = $latlng;
			else
				$data['latlng'] = $this->config->item('lat').','.$this->config->item('lng');
			
			$data['title'] = 'Alta del Siniestro';
			$data['section'] = "SINIESTROS";
			$this->load->template('siniestros/siniestros_form_view.php', $data);
		}
	}

	public function update($id)
	{
		parent::check_is_logged();
		$userLogged = $this->session->userdata('logged_user');
		
		$data['action'] = "UPDATE";
		
		$data['siniestro'] = $this->siniestros_model->get($id);
		$data['victimas'] = $this->siniestros_model->findVictimas(array("id_siniestro"=>$id));
		
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$data['id_ciudad'] = $userLogged['id_ciudad'];
		$data['ciudades'] = $this->config_model->find("config_ciudades");
		$data['localidades'] = $this->config_model->findLocalidades($data['id_ciudad']);
		$data['tipoaccidentes'] = $this->config_model->find("config_tipoaccidentes");
		$data['calles'] = $this->config_model->find("config_calles", $criteria);
		$data['rutas'] = $this->config_model->find("config_rutas");
		$data['tipocalzadas'] = $this->config_model->find("config_tipocalzadas");
		$data['climas'] = $this->config_model->find("config_climas");
		$data['horarios'] = $this->config_model->find("config_horarios");
		$data['causas'] = $this->config_model->find("config_causas");
		$data['tipovehiculos'] = $this->config_model->find("config_tipovehiculos");
		$data['edades'] = $this->config_model->find("config_edades");
		$data['lesiones'] = $this->config_model->find("config_lesiones");
		$data['fuerzas'] = $this->config_model->find("config_fuerzas");
		
		$latlng = $userLogged['latlng'];
		if (!empty($latlng))
			$data['latlng'] = $latlng;
		else
			$data['latlng'] = $this->config->item('lat').','.$this->config->item('lng');
		
		$data['title'] = 'Edici&oacute;n del siniestro';
		$data['section'] = "SINIESTROS";
		$this->load->template('/siniestros/siniestros_form_view.php', $data);
	}

	private function save()
	{
		$id = $this->input->post('id');
		if (empty($id))
			$id = null;
		
		$this->_validations_save();
		$this->_validations_messages();

		$userLogged = $this->session->userdata('logged_user');
		
		$action = $this->input->post('action');
		
		$existe = $this->yaExiste($userLogged['id_ciudad'], $this->input->post('fecha'), $this->input->post('patentes'));
		if ($existe){
			$this->session->set_flashdata('error', 'El siniestro ya existe en el sistema para esas patentes en esa fecha.');
			redirect('siniestros');
			exit;
		}
		
		$id_ciudad = $userLogged['id_ciudad'];
		if (empty($id_ciudad))
			$id_ciudad = $this->input->post('id_ciudad');
		
		$calle1 = parent::getValue($this->input->post('calle1'));
		$nro = parent::getValue($this->input->post('nro'));
		if ($this->input->post('tipocalle') == "RUTA"){
			$calle1 = parent::getValue($this->input->post('ruta'));
			$nro = parent::getValue($this->input->post('km'));
		}
			
		$siniestro= array(
				'id' => $id,
				'fecha' => $this->input->post('fecha').' '.$this->input->post('hora').':'.$this->input->post('min'),
				'id_localidad' => parent::getValue($this->input->post('id_localidad')),
				'tipoaccidente' => $this->input->post('tipoaccidente'),
				'tipocalzada' => $this->input->post('tipocalzada'),
				'tipocalle' => $this->input->post('tipocalle'),
				'calle1' => $calle1,
				'calle2' => parent::getValue($this->input->post('calle2')),
				'calle3' => parent::getValue($this->input->post('calle3')),
				'nro' => $nro,
				'ubicacion' => parent::getValue($this->input->post('ubicacion')),
				'clima' => $this->input->post('clima'),
				'hora' => $this->input->post('horario'),
				'causa' => parent::getValue($this->input->post('causa')),
				'causa2' => parent::getValue($this->input->post('causa2')),
				'causa3' => parent::getValue($this->input->post('causa3')),
				'latlng' => $this->input->post('latlng'),
				'relevamiento' => $this->input->post('relevamiento'),
				'rastros' => $this->input->post('rastros'),
				'descripcion' => parent::getValue($this->input->post('descripcion')),
				'fuerza' => $this->input->post('fuerza'),
				'borrado' => 0,
				'id_ciudad' => $id_ciudad
				
		);
		
		$data['siniestro'] = $siniestro;

		if ($this->form_validation->run() == FALSE)
		{                    
                    $data['title'] = 'Alta de siniestros';
                    if (!empty($id))
                        $data['title'] = 'Edici&oacute;n de siniestros';
                    $data_post = $this->input->post();
                    $data = array_merge($data, $data_post);
                    
                    $criteria['id_ciudad'] = $userLogged['id_ciudad'];
                    $data['id_ciudad'] = $userLogged['id_ciudad'];
                    $data['ciudades'] = $this->config_model->find("config_ciudades");
                    $data['localidades'] = $this->config_model->findLocalidades($data['id_ciudad']);
                    $data['tipoaccidentes'] = $this->config_model->find("config_tipoaccidentes");
                    $data['calles'] = $this->config_model->find("config_calles", $criteria);
                    $data['rutas'] = $this->config_model->find("config_rutas");
                    $data['tipocalzadas'] = $this->config_model->find("config_tipocalzadas");
                    $data['climas'] = $this->config_model->find("config_climas");
                    $data['horarios'] = $this->config_model->find("config_horarios");
                    $data['causas'] = $this->config_model->find("config_causas");
                    $data['tipovehiculos'] = $this->config_model->find("config_tipovehiculos");
                    $data['edades'] = $this->config_model->find("config_edades");
                    $data['fuerzas'] = $this->config_model->find("config_fuerzas");
                    $data['lesiones'] = $this->config_model->find("config_lesiones");

                    $latlng = $userLogged['latlng'];
                    if (!empty($latlng))
                        $data['latlng'] = $latlng;
                    else
                        $data['latlng'] = $this->config->item('lat').','.$this->config->item('lng');
                    
                    $this->load->template('siniestros/siniestros_form_view.php', $data);
		}else{
			if ($action == "ADD")
				$lastIdInserted = $this->siniestros_model->insert($siniestro);
			else
				$lastIdInserted = $this->siniestros_model->save($siniestro);
			
			if ($lastIdInserted >= 0){
				if (empty($id)){
					$this->session->set_flashdata('msg', 'El siniestro fue agregado correctamente');
					parent::logActivity("ADD", "siniestros", $lastIdInserted, "Alta de siniestro");
				}else{
					$this->session->set_flashdata('msg', 'El siniestro fue editado correctamente');
					parent::logActivity("UPDATE", "siniestros", $id, "Edici&oacute;n de siniestro: ".$id);
				}
					
				redirect('siniestros');
			}else{
				$data['error'] = "Error al grabar la informaci&oacute;n";
				$this->load->template('/siniestros/siniestros_form_view.php', $data);
			}
		}
	}
	 
	private function yaExiste($ciudad, $fecha, $patentes){
		$patentes_param_array = array_map('trim', explode(",", $patentes));
		$criteria['fecha'] = $fecha;
		$criteria['id_ciudad'] = $ciudad;
		$siniestros =  $this->siniestros_model->find($criteria);
		foreach ($siniestros as $siniestro) {
			$patentes2 = $siniestro->patentes;
			if ($patentes != '' && $patentes2 != ''){
				$patentes_array = array_map('trim', explode(",", $patentes2));
				$result = array_diff($patentes_param_array, $patentes_array);
				$result2 = array_diff($patentes_array, $patentes_param_array);
				if (empty($result) && empty($result2))
					return true; 
			}
		}
		return false;
	}
	
	public function mock(){
		ini_set('max_execution_time', 10000);
		for($i=1501; $i<2000; $i++){
			$siniestro = array(
					'id' => null,
					'fecha' => rand(2015,2016).'-'.rand(1,12).'-'.rand(1,12),
					'calle1' => 'Calle '.rand(1,100),
					'calle2' => 'Calle '.rand(1,100),
					'nro' => rand(1,1000),
					'tipoaccidente' => rand(1,2),
					'descripcion' => "",
					'tipocalzada' => rand(1,3),
					'clima' => rand(1,5),
					'tipocalzada' => rand(1,2),
					'hora' => rand(1,2),
					'causa' => rand(1,2),
					'latlng' => '-35.'.rand(1,100000).',-59.'.rand(1,100000),
					'patentes' => 'B'.rand(1,1000000),
					'fuerza' => 'Funcionario'.rand(1,5),
					'victimas' => rand(1,2),
					'borrado' => 0
						
			);
			$this->siniestros_model->save($siniestro);
			$victima = array(
					'id' => null,
					'nombre' =>'Victima'.rand(1,5),
					'dni' => rand(1000000,2000000),
					'edad' => rand(1,5),
					'sexo' => "F",
					'cinturon' => rand(0,1),
					'casco' => rand(0,1),
					'conductor' => rand(0,1),
					'tipovehiculo' => "Automovil",
					'id_siniestro' => rand(1,1000)
			);
			$this->siniestros_model->saveVictima($victima);
		}
	}

	public function delete($id){
		parent::check_is_logged();
		$siniestro = $this->siniestros_model->get($id);
		$this->siniestros_model->delete(array("id"=>$id));
		$this->session->set_flashdata('msg', 'El siniestro '.$siniestro['nombre'].'ha sido borrado.');
		parent::logActivity("DELETE", "siniestros", $id, "Borrado de siniestro: ".$siniestro['nombre']);
		redirect('siniestros');
	}
	
	public function details($id=null)
	{
		parent::check_is_logged();
		$userLogged = $this->session->userdata('logged_user');
		
		if (empty($id))
			redirect('siniestros');
		
		$siniestro = $this->siniestros_model->get2($id);
		$data['siniestro'] = $siniestro;
		
		if (empty($siniestro['fecha']))
			redirect('siniestros');
		
		$data['victimas'] = $this->siniestros_model->findVictimas(array("id_siniestro"=>$id));
		$data['vehiculos'] = $this->siniestros_model->findVehiculos(array("id_siniestro"=>$id));
	
		$latlng = $userLogged['latlng'];
		if (!empty($latlng))
			$data['latlng'] = $latlng;
		else
			$data['latlng'] = $this->config->item('lat').','.$this->config->item('lng');
		
		$data['title'] = 'Detalle del Siniestro';
		$data['section'] = "SINIESTROS";
		$this->load->template('/siniestros/siniestros_details_view.php', $data);
	}
	
	public function fotos($id)
	{
		parent::check_is_logged();
		$userLogged = $this->session->userdata('logged_user');
	
		$siniestro = $this->siniestros_model->get2($id);
		$data['siniestro'] = $siniestro;
		$data['siniestroId'] = $siniestro['id'];
		$data['title'] = 'Fotos del Siniestro';
		$data['section'] = "SINIESTROS";
		$this->load->template('/siniestros/siniestros_fotos_view.php', $data);
	}
	
	
	
	public function heatmap(){
		$userLogged = $this->session->userdata('logged_user');
		
		$tipoaccidente = $this->input->post('tipoaccidente');
		if (!empty($tipoaccidente))
			$criteria['tipoaccidente'] =  $tipoaccidente;
	
		$fecha_desde =  $this->input->post('fecha_desde');
		if (empty($fecha_desde))
			$fecha_desde = "2017-01-01";
		$fecha_hasta =  $this->input->post('fecha_hasta');
		if (empty($fecha_hasta))
			$fecha_hasta = "2017-12-31";
		$criteria['fd'] = $fecha_desde;
		$criteria['fh'] = $fecha_hasta;
		$id_ciudad = $userLogged['id_ciudad'];
		if (!empty($id_ciudad))
			$criteria['id_ciudad'] = $id_ciudad;
		else
			$criteria['id_ciudad'] = parent::getValue($this->input->post('id_ciudad'));
		
		$siniestros = $this->siniestros_model->find($criteria);
	
		$data['siniestros'] = $siniestros;
		$data['title'] = 'Mapa de los Siniestros';
		$data['ciudades'] = $this->config_model->find("config_ciudades");
		$data['id_ciudad'] = $userLogged['id_ciudad'];
		$data['tipoaccidentes'] = $this->config_model->find("config_tipoaccidentes");
		$data['criteria'] = $criteria;
	
		$latlng = $userLogged['latlng'];
		if (empty($latlng)){
			$data['lat'] = $this->config->item('lat');
			$data['lng'] = $this->config->item('lng');
			$data['zoom'] = $this->config->item('zoom');
		}
		else{
			$latlng_array = explode(',', $latlng);
			$data['lat'] = $latlng_array[0];
			$data['lng'] = $latlng_array[1];
			$data['zoom'] = $userLogged['zoom'];
		}
		
		$data['section'] = "SINIESTROS";
		$this->load->template('/siniestros/siniestros_heatmap_view.php', $data);
	}
	
	public function export()
	{
		$userLogged = $this->session->userdata('logged_user');
		$id_ciudad = $userLogged['id_ciudad'];
		$tipoaccidente = parent::getValue($this->input->post('tipoaccidente'));
		$fd = parent::getValue($this->input->post('fd'));
		$fh = parent::getValue($this->input->post('fh'));
		$id_localidad= parent::getValue($this->input->post('id_localidad'));
		$criteria = array();
		$criteria['tipoaccidente'] = $tipoaccidente;
		$criteria['fd'] = $fd;
		$criteria['fh'] = $fh;
		$criteria['id_ciudad'] = $id_ciudad;
		$criteria['idl'] = $id_localidad;
		$data['id_ciudad'] = $id_ciudad;
		$criteria['idc'] = parent::getValue($this->input->post('id_ciudad'));
		$data['siniestros'] = $this->siniestros_model->find($criteria);
		$this->load->view('/siniestros/siniestros_export_view.php', $data);
	}
	
	public function victimas($id_siniestro){
		$userLogged = $this->session->userdata('logged_user');
		$data['user'] = $userLogged;
		$data['permisos'] = $userLogged['permisos'];
		$data['victimas'] = $this->siniestros_model->findVictimas(array("id_siniestro"=>$id_siniestro));
		$data['section'] = "SINIESTROS";
		$data['id_siniestro'] = $id_siniestro;
		$this->load->template('siniestros/siniestros_victimas_view.php', $data);
		
	}
	
	public function addvictimas($id_siniestro = null)
	{
		parent::check_is_logged();
	
		if ($this->input->post('sendform') == 1)
			$this->saveVictima();
		else
		{
			$siniestro = $this->siniestros_model->get($id_siniestro);
			$criteria['id_siniestro'] = $id_siniestro;
			$data['edades'] = $this->config_model->find("config_edades");
			$data['lesiones'] = $this->config_model->find("config_lesiones");
			$data['vehiculos'] = $this->siniestros_model->findVehiculos($criteria);
			$data['id_siniestro'] = $id_siniestro;
			$data['title'] = 'Alta del Siniestro';
			$data['section'] = "SINIESTROS";
			$this->load->template('siniestros/siniestros_victimas_form_view.php', $data);
		}
	}
	
	public function updatevictimas($id_victima)
	{
		parent::check_is_logged();
		$data['action'] = "UPDATE";
	
		$victima = $this->siniestros_model->getVictima($id_victima);
		$data['id_siniestro'] = $victima['id_siniestro'];
		$data['victima'] = $victima;
		
		$criteria['id_siniestro'] = $victima['id_siniestro'];
		$data['vehiculos'] = $this->siniestros_model->findVehiculos($criteria);
		
		$siniestro = $this->siniestros_model->get($victima['id_siniestro']);
		$data['siniestro'] = $siniestro;
		
		$data['edades'] = $this->config_model->find("config_edades");
		$data['lesiones'] = $this->config_model->find("config_lesiones");
	
		$data['title'] = 'Edici&oacute;n de la v&iacute;ctima';
		$data['section'] = "SINIESTROS";
		$this->load->template('/siniestros/siniestros_victimas_form_view.php', $data);
	}
	
	private function saveVictima(){
		$idVictima = parent::getValue($this->input->post('idVictima'));
		$idSiniestro = $this->input->post('idSiniestro');
		$condicion = $this->input->post('condicion');
		if ($this->input->post('condicion')== 'ACOMPANANTE')
			$condicion = "ACOMPA�ANTE";
		
		$victima = array(
				'id' => $idVictima,
				'id_siniestro' => $idSiniestro,
				'edad' => $this->input->post('edad'),
				'sexo' => $this->input->post('sexo'),
				'cinturon' => $this->input->post('cinturon'),
				'casco' => $this->input->post('casco'),
				'condicion' => utf8_encode($condicion),
				'dni' => $this->input->post('dni'),
				'nombre' => $this->input->post('nombre'),
				'id_vehiculo' =>  parent::getValue($this->input->post('id_vehiculo')),
				'lesion' => $this->input->post('lesion')
		);
		
		$this->siniestros_model->saveVictima($victima);
		
		redirect('siniestros/victimas/'.$victima['id_siniestro']);
	}
	
	public function deleteVictimas($id_victima){
		parent::check_is_logged();
		$victima = $this->siniestros_model->getVictima($id_victima);
		
		$idSiniestro = $victima['id_siniestro'];
		if ($victima['lesion'] == "FALLECIDO")
			$result = $this->siniestros_model->updateCantidadVictimas($idSiniestro, -1, 'victimas_fatales');

		$this->siniestros_model->deleteVictima(array("id"=>$id_victima));
		
		$this->session->set_flashdata('msg', 'La victima '.$victima['nombre'].'ha sido borrada.');
		
		parent::logActivity("DELETE", "victimas", $id_victima, "Borrado de victima: ".$victima['nombre']);
		
		redirect('siniestros/victimas/'.$victima['id_siniestro']);
	}
	
	public function vehiculos($id_siniestro){
		$userLogged = $this->session->userdata('logged_user');
		$data['user'] = $userLogged;
		$data['permisos'] = $userLogged['permisos'];
		$data['vehiculos'] = $this->siniestros_model->findVehiculos(array("id_siniestro"=>$id_siniestro));
		$data['section'] = "SINIESTROS";
		$data['id_siniestro'] = $id_siniestro;
		$this->load->template('siniestros/siniestros_vehiculos_view.php', $data);
	
	}
	
	public function addvehiculo($id_siniestro = null)
	{
		parent::check_is_logged();
	
		if ($this->input->post('sendform') == 1)
			$this->saveVehiculo();
		else
		{
			$siniestro = $this->siniestros_model->get($id_siniestro);
			$criteria['id_siniestro'] = $id_siniestro;
			$data['tipovehiculos'] = $this->config_model->find("config_tipovehiculos");
			$data['id_siniestro'] = $id_siniestro;
			$data['title'] = 'Alta de vehiculos';
			$data['section'] = "SINIESTROS";
			$this->load->template('siniestros/siniestros_vehiculos_form_view.php', $data);
		}
	}
	
	public function updatevehiculo($id_vehiculo)
	{
		parent::check_is_logged();
		$data['action'] = "UPDATE";
	
		$data['tipovehiculos'] = $this->config_model->find("config_tipovehiculos");
		
		$vehiculo = $this->siniestros_model->getVehiculo($id_vehiculo);
		$data['id_siniestro'] = $vehiculo['id_siniestro'];
		$data['vehiculo'] = $vehiculo;
	
		$siniestro = $this->siniestros_model->get($vehiculo['id_siniestro']);
		$data['siniestro'] = $siniestro;
	
		$data['title'] = 'Edici&oacute;n de la veh&iacute;culo';
		$data['section'] = "SINIESTROS";
		$this->load->template('/siniestros/siniestros_vehiculos_form_view.php', $data);
	}
	
	private function saveVehiculo(){
		$idVehiculo = parent::getValue($this->input->post('idVehiculo'));
		$idSiniestro = $this->input->post('idSiniestro');
	
		$vehiculo = array(
				'id' => $idVehiculo,
				'id_siniestro' => $idSiniestro,
				'tipo' => $this->input->post('tipo'),
				'marca' => parent::getValue($this->input->post('marca')),
				'modelo' => parent::getValue($this->input->post('modelo')),
				'anio' => parent::getValue($this->input->post('anio')),
				'patente' => parent::getValue($this->input->post('patente')),
				'color' => parent::getValue($this->input->post('color')),
				'seguro' => parent::getValue($this->input->post('seguro')),
				'vtv' => parent::getValue($this->input->post('vtv'))
		);


		$this->siniestros_model->saveVehiculo($vehiculo);
	
		redirect('siniestros/vehiculos/'.$vehiculo['id_siniestro']);
	}
	
	public function deletevehiculo($id_vehiculo){
		parent::check_is_logged();
		$vehiculo = $this->siniestros_model->getVehiculo($id_vehiculo);
	
		$this->siniestros_model->deleteVehiculo(array("id"=>$id_vehiculo));
	
		$this->session->set_flashdata('msg', 'El veh&iacute;culo '.$vehiculo['marca'].'ha sido borrado.');
	
		parent::logActivity("DELETE", "vehiculos", $id_vehiculo, "Borrado de veh&iacute;culo: ".$vehiculo['marca']);
	
		redirect('siniestros/vehiculos/'.$vehiculo['id_siniestro']);
	}
	
	// ESTADISTICAS ----------------------------------------------------------------------------
	
	public function stats(){
		parent::check_is_logged();
	
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		
		$fecha_desde = $this->input->post('fd');
		$fecha_hasta = $this->input->post('fh');
		
		$data['fd'] = $fecha_desde;
		$data['fh'] = $fecha_hasta;
		$criteria['fd'] = $fecha_desde;
		$criteria['fh'] = $fecha_hasta;
	

		$this->load->template('siniestros/siniestros_stats_view.php', $data);
	}
	
	public function ajaxGetCalles(){
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$id_localidad = $this->input->post('id_localidad'); 
		if (!empty($id_localidad))
			$criteria['id_localidad'] = $id_localidad;
		$calles = $this->config_model->findCalles($criteria);
		foreach ($calles as $calle){
			echo "<option value='".$calle->calle."'>".$calle->calle."</option>";
		}
	}
	
	public function getStats()
	{
		error_reporting(0);
		$criteria = array();
		$fecha_desde = parent::getValue($this->input->post('fd'));
		$fecha_hasta =  parent::getValue($this->input->post('fh'));
		
		
		$data['fd'] = $fecha_desde;
		$data['fh'] = $fecha_hasta;
		$criteria['fd'] = $fecha_desde;
		$criteria['fh'] = $fecha_hasta;
	
		$userLogged = $this->session->userdata('logged_user');
		
		
		$id_ciudad = $userLogged['id_ciudad'];
		if (!empty($id_ciudad))
			$criteria['id_ciudad'] = $id_ciudad;
	
		$siniestros = $this->siniestros_model->find($criteria);
		$victimas = $this->siniestros_model->findVictimas($criteria);

		echo json_encode($this->buildStats($siniestros, $victimas));
	}
	
	public function buildStats($siniestros, $victimas)
	{
		$totalSiniestros = count($siniestros);
		$totalVictimas = count($victimas);
		
		$array_result = array();
		
		//SINIESTROS
		$array_mesesSiniestros = array();
		$array_mesesVictimas = array();
		$array_tipoAccidentes = array();
		$array_calles = array();
		$array_horarios = array();
		$array_causas = array();
		$array_tipoCalzadas = array();
		$array_climas = array();
			
		$edades = $this->config_model->findEdades();
		$tipoAccidentes = $this->config_model->findTipoAccidentes();
	
		foreach ($siniestros as $siniestro){
				
			$fecha = $this->getMes($siniestro->fecha);
			if (!isset($array_mesesSiniestros["'".$fecha."'"]))
				$array_mesesSiniestros["'".$fecha."'"] = 0;
			$array_mesesSiniestros["'".$fecha."'"] ++;
			
	
			$fecha = $this->getMes($siniestro->fecha);
			if (!isset($array_mesesVictimas["'".$fecha."'"]))
				$array_mesesVictimas["'".$fecha."'"] = 0;
			$array_mesesVictimas["'".$fecha."'"] = $array_mesesVictimas["'".$fecha."'"] + $siniestro->victimas;
			
			
			$tipoaccidente = $siniestro->tipoaccidente;
			$tipoAccidenteText = $tipoAccidentes[$tipoaccidente];
			if (empty($tipoAccidenteText))
				$tipoaccidente = "Sin Registrar";
			if (!isset($array_tipoAccidentes["'".$tipoAccidenteText."'"]))
				$array_tipoAccidentes["'".$tipoAccidenteText."'"] = 0;
			$array_tipoAccidentes["'".$tipoAccidenteText."'"] ++;
			
			//ordeno las esquinas para que siempre sean iguales.
			$array_calles_temp = array();
			$array_calles_temp[] = utf8_decode($siniestro->calle1);
			$array_calles_temp[] = utf8_decode($siniestro->calle2);
			sort($array_calles_temp);
			if (empty($siniestro->calle1) && empty($siniestro->calle2))
				$lugar = "Sin Registrar";
			if (!empty($siniestro->calle1) && !empty($siniestro->calle2)){
				$lugar = $array_calles_temp[0]." y ".$array_calles_temp[1]; 
				if (!isset($array_calles["'".$lugar."'"]))
					$array_calles["'".$lugar."'"] = 0;
				$array_calles["'".$lugar."'"] ++;
			}
			$horario = $siniestro->horario;
			if (empty($horario))
				$horario = "Sin Registrar";
			if (!isset($array_horarios["'".$horario."'"]))
				$array_horarios["'".$horario."'"] = 0;
			$array_horarios["'".$horario."'"] ++;
			
			$causa = $siniestro->causaTxt;
			if (empty($causa))
				$causa = "Sin Registrar";
			if (!isset($array_causas["'".$causa."'"]))
				$array_causas["'".$causa."'"] = 0;
			$array_causas["'".$causa."'"] ++;
			
			$tipocalzada = $siniestro->tipocalzada;
			if (empty($tipocalzada))
				$tipocalzada = "Sin Registrar";
			if (!isset($array_tipoCalzadas["'".$tipocalzada."'"]))
				$array_tipoCalzadas["'".$tipocalzada."'"] = 0;
			$array_tipoCalzadas["'".$tipocalzada."'"] ++;
				
			$clima = $siniestro->clima;
			if (empty($clima))
				$clima = "Sin Registrar";
			if (!isset($array_climas["'".$clima."'"]))
				$array_climas["'".$clima."'"] = 0;
			$array_climas["'".$clima."'"] ++;
				
		}	
		ksort($array_mesesSiniestros);
		ksort($array_mesesVictimas);
		
		$array_tipoAccidentes2 = array();
		foreach ($array_tipoAccidentes as $i => $value){
			$r = $value*100/$totalSiniestros;
			$array_tipoAccidentes2[$i] = floatval(number_format($r, 2, '.', ''));
		}
		$array_horarios2 = array();
		foreach ($array_horarios as $i => $value){
			$r = $value*100/$totalSiniestros;
			$array_horarios2[$i] = floatval(number_format($r, 2, '.', ''));
		}
		$array_causas2 = array();
		foreach ($array_causas as $i => $value){
			$r = $value*100/$totalSiniestros;
			$array_causas2[$i] = floatval(number_format($r, 2, '.', ''));
		}
		$array_tipoCalzadas2 = array();
		foreach ($array_tipoCalzadas as $i => $value){
			$r = $value*100/$totalSiniestros;
			$array_tipoCalzadas2[$i] = floatval(number_format($r, 2, '.', ''));
		}
		$array_climas2 = array();
		foreach ($array_climas as $i => $value){
			$r = $value*100/$totalSiniestros;
			$array_climas2[$i] = floatval(number_format($r, 2, '.', ''));
		}
		arsort($array_calles);
		$array_calles2 = array_slice($array_calles, 0, 11);
		
		//VICTIMAS
		$array_edades = array();
		$array_tipoVehiculos = array();
		$array_lesiones = array();
		$array_sexos = array();
		$array_casco = array();
		$array_cinturon = array();
		$array_conductor = array();
		
		$totalVictimasAplicanCasco = 0;
		$totalVictimasAplicanCinturon = 0;
		$totalVictimasAplicanConductor = 0;
		
		foreach ($victimas as $victima){
			
			$edad = $victima->edad;
			$edadText = $edad;
			if (!isset($array_edades["'".$edadText."'"]))
				$array_edades["'".$edadText."'"] = 0;
			$array_edades["'".$edadText."'"] ++;
			
			$tipovehiculo = $victima->tipovehiculo;
			if (empty($tipovehiculo))
				$tipovehiculo = "Sin Registrar";
			if (!isset($array_tipoVehiculos["'".$tipovehiculo."'"]))
				$array_tipoVehiculos["'".$tipovehiculo."'"] = 0;
			$array_tipoVehiculos["'".$tipovehiculo."'"] ++;
			
			$lesion = $victima->lesion;
			if (empty($lesion))
				$lesion = "Sin Registrar";
			if (!isset($array_lesiones["'".$lesion."'"]))
				$array_lesiones["'".$lesion."'"] = 0;
			$array_lesiones["'".$lesion."'"] ++;
			
			$sexo = $victima->sexo;
			if (empty($sexo))
				$sexo = "Sin Registrar";
			if (!isset($array_sexos["'".$sexo."'"]))
				$array_sexos["'".$sexo."'"] = 0;
			$array_sexos["'".$sexo."'"] ++;
			
			$casco = $victima->casco;
			if ($casco != 2){
				$totalVictimasAplicanCasco++;
				if ($casco == 0)
					$casco = "No";
				else if ($casco == 1)
					$casco = "Si";
				if (!isset($array_cascos["'".$casco."'"]))
					$array_cascos["'".$casco."'"] = 0;
				$array_cascos["'".$casco."'"] ++;
			}
			
			
			$cinturon = $victima->cinturon;
			if ($cinturon != 2){
				$totalVictimasAplicanCinturon++;
				if ($cinturon == 0)
					$cinturon = "No";
				else if ($cinturon == 1)
					$cinturon = "Si";
				if (!isset($array_cinturon["'".$cinturon."'"]) )
					$array_cinturon["'".$cinturon."'"] = 0;
				$array_cinturon["'".$cinturon."'"] ++;
			}
			
			$conductor = $victima->conductor;
			if ($conductor != 2){
				$totalVictimasAplicanConductor++;
				if ($conductor == 0)
					$conductor = "No";
				else if ($conductor == 1)
					$conductor = "Si";
				if (!isset($array_conductor["'".$conductor."'"]) )
					$array_conductor["'".$conductor."'"] = 0;
				$array_conductor["'".$conductor."'"] ++;
			}
			
		}
		$array_edades2 = array();
		foreach ($array_edades as $i => $value){
			$r = $value*100/$totalVictimas;
			$array_edades2[$i] = floatval(number_format($r, 2, '.', ''));
		}
		$array_tipoVehiculos2 = array();
		foreach ($array_tipoVehiculos as $i => $value){
			$r = $value*100/$totalVictimas;
			$array_tipoVehiculos2[$i] = floatval(number_format($r, 2, '.', ''));
		}
		$array_lesiones2 = array();
		foreach ($array_lesiones as $i => $value){
			$r = $value*100/$totalVictimas;
			$array_lesiones2[$i] = floatval(number_format($r, 2, '.', ''));
		}
		$array_sexos2 = array();
		foreach ($array_sexos as $i => $value){
			$r = $value*100/$totalVictimas;
			$array_sexos2[$i] = floatval(number_format($r, 2, '.', ''));
		}
		$array_cascos2 = array();
		foreach ($array_cascos as $i => $value){
			$r = $value*100/$totalVictimasAplicanCasco;
			$array_casco2[$i] = floatval(number_format($r, 2, '.', ''));
		}
		$array_cinturon2 = array();
		foreach ($array_cinturon as $i => $value){
			$r = $value*100/$totalVictimasAplicanCinturon;
			$array_cinturon2[$i] = floatval(number_format($r, 2, '.', ''));
		}
		$array_conductor2 = array();
		foreach ($array_conductor as $i => $value){
			$r = $value*100/$totalVictimasAplicanConductor;
			$array_conductor2[$i] = floatval(number_format($r, 2, '.', ''));
		}
		
		$array_result[0] = $array_mesesSiniestros;
		$array_result[1] = $array_mesesVictimas;
		$array_result[2] = $array_tipoAccidentes2;
		$array_result[3] = $array_edades2;
		$array_result[4] = $array_calles2;
		$array_result[5] = $array_tipoVehiculos2;
		$array_result[6] = $array_lesiones2;
		$array_result[7] = $array_horarios2;
		$array_result[8] = $array_causas2;
		$array_result[9] = $array_sexos2;
		$array_result[10] = $array_tipoCalzadas2;
		$array_result[11] = $array_climas2;
		$array_result[12] = $array_conductor2;
		$array_result[13] = $array_casco2;
		$array_result[14] = $array_cinturon2;
		
		return $array_result;
	}
	
	function getMes($fecha){
		$date = new DateTime($fecha);
		return $date->format('m/Y');
	}
	
	function _validations_save()
	{
		$this->form_validation->set_rules('descripcion', 'Descripci&oacute;n',  'trim|xss_clean');
		$this->form_validation->set_rules('nro', 'Altura',  'trim|xss_clean');
        $this->form_validation->set_rules('latlng', 'Mapa',  'callback_validate_latlng[latlng]|xss_clean');
	}

	function _validations_messages()
	{
		$this->form_validation->set_message('required', 'El campo "%s" es obligatorio');
		$this->form_validation->set_message('min_length', 'El Campo "%s" debe tener un M&iacute;nimo de %d Caracteres');
		$this->form_validation->set_message('max_length', 'El Campo "%s" debe tener un M&aacute;ximo de %d Caracteres');
		$this->form_validation->set_message('matches', 'El confirmaci&oacute;n de la Contrase&ntilde;a no es correcta');
		$this->form_validation->set_message('valid_email', 'El E-Mail no tiene un formato v&aacute;lido');
        $this->form_validation->set_message('validate_latlng', 'Es obligatorio seleccionar en el mapa la ubucaci&oacute;n.');
	}

	function validate_latlng($latlng) {
            if (empty($latlng)) {
                return false;
            }
            return true;
        }

}