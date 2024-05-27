<?php

Class Imagenes extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('imagenes_model');
		$this->load->helper('security');
		$this->load->helper('form');
	}
	
	public function index($offset = 0){
		parent::check_has_permission();		
		
		// Inicio Paginado 
		// - Inicializacion de parametros
			$my_paginator = new Pagination_helper();
			$criteria= $this->uri->uri_to_assoc(3); // pasa del segmento 3 en adelante a un array.
			array_pop($criteria); // Saca el ultimo segmento que es el paginado.
			$last = $this->uri->total_segments(); // Obtengo la pocision del ultimo segmento.
			$ultimo_elemento = $this->uri->segment($last);
			$items_por_pagina = 12;
			$assoc = $this->uri->assoc_to_uri($criteria);
			$total_rows = $this->imagenes_model->count($criteria);
		
			$my_paginator->inicializar("imagenes", $assoc, $total_rows, $items_por_pagina, $ultimo_elemento);
			$paginator_config = $my_paginator->getConfig();
			$this->pagination->initialize($paginator_config);
		// Fin Paginado
		
		
		// Obtengo los registros para la pagina actual segun el criterio
		$data['imagenes'] = $this->imagenes_model->find($criteria, $items_por_pagina, $ultimo_elemento);
	
		//recupero datos de MSG y ERROR que pueden venir de otro lado para mostrar en la pantalla
		$data['msg'] = $this->session->flashdata('msg');
		$data['error'] = $this->session->flashdata('error');
	
		// Paso a la vista los parametros para ver el criterio y para mantenerlo
		$data = $this->_cargar_parametros($criteria, $data);
		
		$data['section'] = "IMAGENES";
		$data['subsection'] = "IMAG-VIEW";
		$data['title'] = 'Ver Im&aacute;genes';
		$this->load->template('imagenes/imagenes_view.php', $data);
	}
	
	public function add(){
		parent::check_has_permission();
		$data['section'] = "IMAGENES";
		$data['subsection'] = "IMAG-ADD";
		$data['title'] = 'Ver Im&aacute;genes';
		$this->load->template('imagenes/imagenes_form_view.php', $data);
	}
	
	/**
	 * Esta funcion es llamada de varios lugares, lo que hace es devolver una lista de imágenes con algunas funciones comunes
	 * que dependen de la seccion desde donde se la llama
	 */
	public function getImagenes(){
		$data["puede_relacionar_imagen"] = false;
		if ($this->input->post("section")=='noticias' || $this->input->post("section")=='galerias')
		{
			$data["puede_relacionar_imagen"] = true;
		}
		
		$from = $this->input->post("from");
		$imagenes = $this->imagenes_model->find(array(), 12, $from);
		$data['imagenes'] = $imagenes;
		
		$data["hay_mas_imagenes"] = false;
		if (sizeof($imagenes) == 12){
			$data["hay_mas_imagenes"] = true;
			$data["from"] = intval($from)+12;
		}
		$data["ref"] = $this->input->post("ref");
		$this->load->view('imagenes/imagenes_ajax_view.php', $data);
	}
	
	public function upload($tableName){
	    $status = "";
	    $msg = "";
	    $imagePath = "";
	    $file_element_name = $this->config->item('imagenes_file_element_name'); 
	       
        $config['upload_path'] = $this->config->item('imagenes_upload_path').$tableName.'/';
	    $config['allowed_types'] = $this->config->item('imagenes_allowed_types');
	    $config['max_size'] = $this->config->item('imagenes_max_size');
	    $config['encrypt_name'] = $this->config->item('imagenes_encrypt_name');
	 
        $this->load->library('upload', $config);
        $this->load->library('image_lib');
 
        if (!$this->upload->do_upload($file_element_name))
        {
            $status = 'error';
            $msg = $this->upload->display_errors('', '');
        }
        else
        {
        	$data = $this->upload->data();
        	//Original Image Resizing
        	$config2['source_image'] =  $data["full_path"];
        	$config2['maintain_ratio'] = TRUE;
        	$config2['overwrite'] = TRUE;
        	$config2['width'] = 960;
        	$config2['height'] = 720;
        	        	
        	$this->image_lib->initialize($config2);
	        if ( ! $this->image_lib->resize())
			{
			    echo $this->image_lib->display_errors();
			} 
			
			//Thumbnail
			$config2['new_image'] = './files/imagenes/'.$tableName.'/thumb/'.$this->upload->file_name;
			$config2['width'] = 220;
			$config2['height'] = 165;
			$this->image_lib->initialize($config2);
			if ( ! $this->image_lib->resize())
			{
				echo $this->image_lib->display_errors();
			}
			
			$this->image_lib->clear();
        	
			// Grabo la imagen en la base de datos
			
        	$imagen = array(
            	"filename" => $data['file_name'],
         	    "iditem" => $_POST['iditem'],
        		"tablename" => $_POST['tablename'],
            	"filesize" => $data['file_size'],
            	"width" => $data['image_width'],
            	"height" => $data['image_height']
            );
            $imagen_id = $this->imagenes_model->insert($imagen);
            if($imagen_id)
            {
                $status = "success";
                $msg = "La imagen se agreg&oacute; correctamente.";
                $imagePath = $data['file_name'];
            }
            else
            {
                unlink($data['full_path']);
                $status = "error";
                $msg = "Ocurri&oacute; un error al grabar la imagen, intente otra vez.";
            }
        }
        @unlink($_FILES[$file_element_name]);
	    echo json_encode(array(
	    					'status' => $status, 
	    					'msg' => $msg, 
	    					'imagePath' => $imagePath,
	    					'width' => $data['image_width'],
				    		'height' => $data['image_height'],
				    		'filesize' => $data['file_size'],
	    					'imagenId' => $imagen_id
	    				));
	    exit;
	}
	
	
	public function delete($tableName)
	{
		//parent::check_has_permission();
		// Borro la imagen Fisicamente
		$idImagen = $_POST['idImagen'];
		$imagen = $this->imagenes_model->get($idImagen);
		unlink('./files/imagenes/'.$tableName.'/'.$imagen['filename']);
		unlink('./files/imagenes/'.$tableName.'/thumb/'.$imagen['filename']);
		// Borro la imange de la BD
		$this->imagenes_model->delete($idImagen);
	}
	
	/**
	 * Esta Funcion se ejecuta por AJAX cuando se selecciona/deselecciona una imagen
	 * para agregar o sacarla de la galeria.
	 * param POST: isSelected: indica si hay que agregarla o sacarla
	 * param POST: idImagen: el id de la imagen.
	 */
	public function updateGaleria(){
		$isSelected = $this->input->post("isSelected");
		$idImagen = $this->input->post("idImagen");
		$this->imagenes_model->updateGaleria($isSelected, $idImagen);
	}
	
	function _cargar_parametros($criteria, $data)
	{
		if ( !empty($criteria["orderby"]))
		{
			$data['orderby'] = $criteria["orderby"];
			$data['order'] = $criteria["order"];
		}
		else
		{
			$data['orderby'] = 'fecha_hora'; //TODO: Constante en configuracion
			$data['order'] = 'DESC'; //TODO: Constante en configuracion
		}
		if ( !empty($criteria["searchtext"]))
			$data['searchtext'] = $criteria["searchtext"];
		return $data;
	}
}