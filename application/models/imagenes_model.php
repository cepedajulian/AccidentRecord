<?php

class Imagenes_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
		//$this->output->enable_profiler(TRUE);
	}

	public function get($id)
	{
		$this->db->select('*');
		$this->db->from('imagenes');
		$this->db->where('imagenes.id', $id);
		$this->db->limit(1);

		$query = $this->db->get();

		if($query->num_rows() == 1)
		{
			$result_array = $query->result_array();
			return $result_array[0];
		}
		else
			return false;
	}

	public function find($criteria = array(), $n = NULL, $offset = NULL)
	{
		$where = $this->_get_where($criteria);
		$orderby = parent::_get_orderby($criteria, 'id');
		$order = parent::_get_order($criteria, 'DESC');
		return parent::find('imagenes', $where, $orderby, $order, $n, $offset);
	}
	
	
	
	public function count($criteria = array())
	{
		//$this->output->enable_profiler(TRUE);
		$where = $this->_get_where($criteria);
		$orderby = $this->_get_orderby($criteria);
		$order = $this->_get_order($criteria);
	
		$this->db->select('*');
		$this->db->from('imagenes');
		if ( ! empty($where))
			$this->db->where($where, NULL, FALSE);
			
		$query = $this->db->get();
	
		if($query -> num_rows() > 0)
			return $query->num_rows(); 
		else
			return 0;
	}

	public function insert($imagen)
	{
		//$this->output->enable_profiler(TRUE);
		if (! empty($imagen['id']))
		{
			$this->db->set("filename", $imagen['filename']);
			$this->db->set("tablename", $imagen['tablename']);
			$this->db->set("iditem_relation", $imagen['iditem_relation']);
			$this->db->set("fecha_hora", date("Y-m-d H:i:s"));
			$this->db->set("width", $imagen['width']);
			$this->db->set("height", $imagen['height']);
			$this->db->set("filesize", $imagen['filesize']);
			$this->db->set("description", $imagen['description']);

			$this->db->where("id", $imagen['id']);
			$result = $this->db->update("imagenes");
			return $result;
		}
		else
		{
			$result = $this->db->insert('imagenes', $imagen);
			return $this->db->insert_id();
		}
	}

	public function delete($id)
	{
		
		$this->db->where('id', $id);
		$this->db->delete('imagenes');
	}

	public function updateGaleria($isSelected, $idImagen){
		$this->db->set("galeria", $isSelected);
		$this->db->where("id", $idImagen);
		$result = $this->db->update("imagenes");
		return $result;
	}
	
	public function numrows()
	{
		return $this->db->get('imagenes')->num_rows();
	}

	function _get_where($criteria)
	{
		$where = '1 = 1';
		if ( isset($criteria['tableName']) )
		{
			$where .= " AND tablename = '".$criteria['tableName']."' ";
		}
		if ( isset($criteria['iditem_relation']) )
		{
			$where .= " AND iditem_relation = '".$criteria['idItem']."' ";
		}
		return $where;
	}
	
	function _get_orderby($criteria)
	{
		$orderby = '';
		if ( ! empty($criteria['orderby']) )
			$orderby = $criteria['orderby'];
		else
			$orderby = "fecha_hora"; //TODO: constante de configuracion.
		return $orderby;
	}

	function _get_order($criteria)
	{
		$order = '';
		if ( ! empty($criteria['order']) )
			$order .= $criteria['order'];
		else
			$order .= "DESC"; //TODO: constante de configuracion.
		return $order;
	}
}