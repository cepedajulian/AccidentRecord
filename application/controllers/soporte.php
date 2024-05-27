<?php

class Soporte extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		$data['title'] = 'Soporte';
	}
	
	public function index()
	{
	}
	
	public function contacto()
	{
		$data['title'] = 'Contacto';
		$this->load->template('/soporte/soporte_contacto_view.php', $data);
	}
	
	public function manual()
	{
		$data['title'] = 'Manual de Usuario';
		//$this->load->template('soporte/..._view.php', $data);
	}
	
	public function fq()
	{
		$data['title'] = 'Preguntas Frecuentes';
		$this->load->template('soporte/soporte_fq_view.php', $data);
	}
}