<?php

class Home extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('siniestros_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->helper('security');
		$this->load->helper('form');
		$data['title'] = 'Producci&oacute;n';
	}
	
	public function index(){
		parent::check_is_logged();
		$data['title'] = 'Administrador';
		$user = $this->session->userdata('logged_user');
		$data['username'] = $user['username'];
		$data['permisos'] = $user['permisos'];
		$criteria['id_ciudad'] = $user['id_ciudad'];
		
		//siniestros por año
		
		if ($user['id_ciudad']==''){
			$sql="SELECT year(fecha) AS anio, count(id) AS cantidad FROM siniestros WHERE borrado=0 GROUP BY year(fecha) ORDER BY year(fecha) DESC";
		}else{
			$sql="SELECT year(fecha) AS anio, count(id) AS cantidad FROM siniestros WHERE borrado=0 and id_ciudad=".$user['id_ciudad']." GROUP BY year(fecha) ORDER BY year(fecha) DESC";
		}

		$data['totalSiniestrosPorAnio']=$this->siniestros_model->SqlFree($sql);
		//FIN siniestros por año

		//implicados por año
		if ($user['id_ciudad']==''){
			$sql="SELECT year(siniestros.fecha) AS anio, count(victimas.id) AS cantidad FROM siniestros  JOIN victimas ON siniestros.id=victimas.id_siniestro WHERE victimas.lesion <> 'FALLECIDO' AND siniestros.borrado=0 GROUP BY YEAR(siniestros.fecha) ORDER BY YEAR(siniestros.fecha) DESC";
		}else{
			$sql="SELECT year(siniestros.fecha) AS anio, count(victimas.id) AS cantidad  FROM siniestros INNER JOIN victimas ON siniestros.id=victimas.id_siniestro WHERE victimas.lesion <>'FALLECIDO' AND siniestros.borrado=0 AND id_ciudad=".$user['id_ciudad']." GROUP BY YEAR(siniestros.fecha) ORDER BY YEAR(siniestros.fecha) DESC";
		}

		$data['totalImplicadosPorAnio']=$this->siniestros_model->SqlFree($sql);
		//FIN implicados por año

		//victimas por año
		if ($user['id_ciudad']==''){
			$sql="SELECT year(siniestros.fecha) AS anio, count(victimas.id) AS cantidad FROM siniestros INNER JOIN victimas ON siniestros.id=victimas.id_siniestro WHERE victimas.lesion='FALLECIDO' AND siniestros.borrado=0 GROUP BY YEAR(siniestros.fecha) ORDER BY YEAR(siniestros.fecha) DESC";
		}else{
			$sql="SELECT year(siniestros.fecha) AS anio, count(victimas.id) AS cantidad  FROM siniestros INNER JOIN victimas ON siniestros.id=victimas.id_siniestro WHERE victimas.lesion='FALLECIDO' AND siniestros.borrado=0 AND id_ciudad=".$user['id_ciudad']." GROUP BY YEAR(siniestros.fecha) ORDER BY YEAR(siniestros.fecha) DESC";
		}

		$data['totalVictimasPorAnio']=$this->siniestros_model->SqlFree($sql);
		//FIN victimas por año

		//FIN agregado 2018 JAC
		
		$this->load->template('home_view.php', $data);
	}
	
	public function search(){
		$dni = parent::getValue($this->input->post('dni'));
		$patente = parent::getValue($this->input->post('patente'));
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		
		if (!empty($dni)){
			$criteria['dni'] = $dni;
			$data['victimas'] = $this->siniestros_model->findVictimas($criteria);
		}
		else if (!empty($patente)){
			$criteria['patente'] = $patente;
			$data['siniestros'] = $this->siniestros_model->find($criteria);
			$data['victimas'] = $this->siniestros_model->findVictimas($criteria);
		}
		$userLogged = $this->session->userdata('logged_user');
		$data['dni'] = $dni;
		$data['patente'] = $patente;
		$data['permisos'] = $userLogged['permisos'];
		$this->load->template('home_result_view.php', $data);
	}
	
	public function error()
	{
		$data['title'] = 'Administrador';
		$data['error'] = 'No tiene permisos suficientes para ver esta p&aacute;gina.';
		$this->load->template('error_view.php', $data);
	}
}