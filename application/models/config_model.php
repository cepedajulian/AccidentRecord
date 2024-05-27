<?php

if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');


class Config_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
	}

	public function get($tabla, $id)
	{
		return parent::get($tabla, $id);
	}
	
	public function getCiudad($id)
	{
		return parent::get('config_ciudades', $id);
	}
	
	public function find($tabla, $criteria = array())
	{
		$where = $this->_get_where($criteria);
		$orderby = parent::_get_orderby($criteria, 'id');
		$order = parent::_get_order($criteria, 'ASC');
		return parent::find($tabla, $where, $orderby, $order, null, null);
	}
	
	public function findFuncionarios($criteria = array(), $n = NULL, $offset = NULL)
	{
		$where = $this->_get_where_funcionarios($criteria);
		$orderby = parent::_get_orderby($criteria, 'funcionario');
		$order = parent::_get_order($criteria, 'ASC');
		$this->db->select('CC.*, CI.ciudad');
		$this->db->from('config_funcionarios as CC');
		$this->db->join('config_ciudades as CI', 'CI.id = CC.id_ciudad', 'left');
		if ( ! empty($where))
			$this->db->where($where, NULL, FALSE);
		if ( ! empty($n)  )
			$this->db->limit($n, $offset);
		if (! empty($orderby))
			$this->db->order_by($orderby, $order);
	
		$query = $this->db->get();
	
		if($query -> num_rows() > 0)
			return $query->result();
		else
			return array();
	}
	
	public function findCalles($criteria = array(), $n = NULL, $offset = NULL)
	{
		$where = $this->_get_where_calles($criteria);
		$orderby = parent::_get_orderby($criteria, 'calle');
		$order = parent::_get_order($criteria, 'ASC');
		$this->db->select('CC.*, CI.ciudad, L.localidad');
		$this->db->from('config_calles as CC');
		$this->db->join('config_ciudades as CI', 'CI.id = CC.id_ciudad', 'left');
		$this->db->join('config_localidades as L', 'L.id = CC.id_localidad', 'left');
		if ( ! empty($where))
			$this->db->where($where, NULL, FALSE);
		if ( ! empty($n)  )
			$this->db->limit($n, $offset);
		if (! empty($orderby))
			$this->db->order_by($orderby, $order);
	
		$query = $this->db->get();
	
		if($query -> num_rows() > 0)
			return $query->result();
		else
			return array();
	}
	
	public function findLocalidades($id_ciudad)
	{
		$this->db->select('*');
		$this->db->from('config_localidades as CL');
		if (!empty($id_ciudad))
			$this->db->where('id_ciudad', $id_ciudad);
	
		$query = $this->db->get();
	
		if($query -> num_rows() > 0)
			return $query->result();
		else
			return array();
	}
	
	public function findCiudades()
	{
		$this->db->select('*');
		$this->db->from('config_ciudades as CC');
	
		$query = $this->db->get();
	
		if($query -> num_rows() > 0)
			return $query->result();
		else
			return array();
	}
	
	public function findRutas()
	{
		$this->db->select('*');
		$this->db->from('config_rutas as CR');
	
		$query = $this->db->get();
	
		if($query -> num_rows() > 0)
			return $query->result();
		else
			return array();
	}
	
	public function findEdades()
	{
		$this->db->select('*');
    	$this->db->from('config_edades');
    	
    	$query = $this->db->get();
    
 		$result_array = $query->result_array();
		$result = array();
		foreach ($result_array as $ra){
			$result[$ra['id']] = $ra['edad'];
		}
		return $result;
	}
	
	public function findTipoAccidentes()
	{
		$this->db->select('*');
		$this->db->from('config_tipoaccidentes');
		 
		$query = $this->db->get();
	
		$result_array = $query->result_array();
		$result = array();
		foreach ($result_array as $ra){
			$result[$ra['id']] = $ra['tipoaccidente'];
		}
		return $result;
	}
	
	public function count($table, $criteria = array())
	{
		$where = $this->_get_where($criteria);
		return parent::count($table, $where);
	}
	
	public function countFuncionarios($table, $criteria = array())
	{
		$where = $this->_get_where_funcionarios($criteria);
		return parent::count($table, $where);
	}
	
	function delete($table,$conditions)
	{
		return parent::delete($table, $conditions);
	}
	
	function save($tabla, $datos)
	{
		return parent::save($tabla, $datos);
	}
	
	function saveCiudad($ciudad)
	{
		return parent::save('config_ciudades', array("ciudad"=>$ciudad));
	}
	
	function getNextCiudadId()
	{
		return parent::getNextId('config_ciudades');
	}
	
	public function existeCalle($id_localidad, $calle){
		$this->db->select('*');
		$this->db->from('config_calles');
		$this->db->where('calle', $calle);
		$this->db->where('id_localidad', $id_localidad);
		$this->db->limit(1);
	
		$query = $this->db->get();
	
		if($query->num_rows() == 1){
			$result_array = $query->result_array();
    		return $result_array[0];
		}
		return null;
	}
	
	public function existeRuta($ruta){
		$this->db->select('*');
		$this->db->from('config_rutas');
		$this->db->where('ruta', $ruta);
		$this->db->limit(1);
	
		$query = $this->db->get();
	
		if($query->num_rows() == 1){
			$result_array = $query->result_array();
    		return $result_array[0];
		}
		return null;
	}
	
	public function existeLocalidad($localidad, $id_ciudad){
		$this->db->select('*');
		$this->db->from('config_localidades');
		$this->db->where('localidad', $localidad);
		$this->db->where('id_ciudad', $id_ciudad);
		$this->db->limit(1);
	
		$query = $this->db->get();
	
		if($query->num_rows() == 1){
			$result_array = $query->result_array();
    		return $result_array[0];
		}
		return null;
	}
	
	public function existeCiudad($ciudad){
		$this->db->select('*');
		$this->db->from('config_ciudades');
		$this->db->where('ciudad', $ciudad);
		$this->db->limit(1);
	
		$query = $this->db->get();
	
		if($query->num_rows() == 1){
			$result_array = $query->result_array();
    		return $result_array[0];
		}
		return null;
	}
	
	function _get_where($criteria)
	{
		$where = '1 = 1';
		if ( isset($criteria['searchtext']) )
		{
			$where .= " AND (calle like '%".urldecode($criteria['searchtext'])."%' )";
		}
		if ( isset($criteria['id_ciudad']) )
		{
			$where .= " AND id_ciudad = '".$criteria['id_ciudad']."' ";
		}

		return $where;
	}
	
	function _get_where_calles($criteria)
	{
		$where = '1 = 1';
		if ( isset($criteria['searchtext']) )
		{
			$where .= " AND (calle like '%".urldecode($criteria['searchtext'])."%' )";
		}
		if ( isset($criteria['id_ciudad']) )
		{
			$where .= " AND CC.id_ciudad = '".$criteria['id_ciudad']."' ";
		}
		if ( isset($criteria['id_localidad']) )
		{
			$where .= " AND id_localidad = '".$criteria['id_localidad']."' ";
		}
		return $where;
	}
	
	function _get_where_funcionarios($criteria)
	{
		$where = '1 = 1';
		if ( isset($criteria['searchtext']) )
		{
			$where .= " AND (funcionario like '%".urldecode($criteria['searchtext'])."%' )";
		}
		if ( isset($criteria['id_ciudad']) )
		{
			$where .= " AND id_ciudad = '".$criteria['id_ciudad']."' ";
		}
		if ( isset($criteria['id_localidad']) )
		{
			$where .= " AND id_localidad = '".$criteria['id_localidad']."' ";
		}
	
		return $where;
	}
	
}