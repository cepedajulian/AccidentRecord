<?php

class Activity extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('activity_model');
		$this->load->model('users_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->helper('security');
		$this->load->helper('form');
		$data['title'] = 'Activity';
	}

	public function index($offset = 0 )
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
		// Paginado - Configuracion		
		$config['first_url'] = base_url().'index.php/activity/index/'.$this->uri->assoc_to_uri($criteria).'/0';
		$config['base_url'] = base_url().'index.php/activity/index/'.$this->uri->assoc_to_uri($criteria);
		$config['total_rows'] = $this->activity_model->count($criteria);
		$config['cur_page'] = $this->uri->segment($last);//CURRENT PAGE NUMBER -> fundamental para q funque sino se manbeaba con el criteria
			
		$config['last_link'] = '&Uacute;ltima';
		$config['first_link'] = 'Primera';
		$config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
		$config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li><span><b>";
		$config['cur_tag_close'] = "</b></span></li>";
		
		$this->pagination->initialize($config);

		// Obtengo los registros para la pagina actual
		$data['activities'] = $this->activity_model->find($criteria, $itemsPerPage, $ultimo_elemento);
		$data['criteria'] = $criteria;
		$data['itemsPerPage'] = $itemsPerPage;
		$userLogged = $this->session->userdata('logged_user');
		$data['permisos'] = $userLogged['permisos'];

		$data['msg'] = $this->session->flashdata('msg');
		$data['error'] = $this->session->flashdata('error');

		$this->load->template('activity/activity_view.php', $data);
	}
	
	/*
	 * Segun los parametros de busqueda y ordenamiento arma la URL y redicciona al index.
	*/
	public function search()
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
	
		redirect('activity/index/'.$criteria);
	}

}