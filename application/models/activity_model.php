<?php

if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');


class Activity_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
	}

	public function get($id)
	{
		return parent::get('activity', $id);
	}
	
	public function find($criteria = array(), $n = NULL, $offset = NULL)
	{
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$where = $this->_get_where($criteria);
		$orderby = parent::_get_orderby($criteria, 'fecha');
		$order = parent::_get_order($criteria, 'desc');
		$this->db->select('*, A.id as idActivity, U.id as userId, U.username');
		$this->db->from('activity as A');
		$this->db->join('users as U', 'A.id_user = U.id');
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
	
	public function count($criteria = array())
	{
		$userLogged = $this->session->userdata('logged_user');
		$criteria['id_ciudad'] = $userLogged['id_ciudad'];
		$where = $this->_get_where($criteria);
		$this->db->select('*');
		$this->db->from('activity as A');
		$this->db->join('users as U', 'A.id_user = U.id');
		if ( ! empty($where))
			$this->db->where($where, NULL, FALSE);
		
		$query = $this->db->get();
	
		if($query -> num_rows() > 0)
			return $query -> num_rows();
		else
			return 0;
	}
	
	function save($datos)
	{
		return parent::save('activity', $datos);
	}
	
	function _get_where($criteria)
	{
		$where = '1 = 1';
		if ( isset($criteria['searchtext']) )
		{
			$where .= " AND (tabla LIKE '%".$criteria['searchtext']."%' OR descripcion LIKE '%".$criteria['searchtext']."%' OR nombre LIKE '%".$criteria['searchtext']."%')";
		}
		if ( isset($criteria['id_ciudad']) )
		{
			$where .= " AND U.id_ciudad = '".$criteria['id_ciudad']."' ";
		}
		return $where;
	}
	
	
}