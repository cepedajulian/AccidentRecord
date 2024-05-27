<?php

if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');


class Siniestros_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get($id)
	{
		return parent::get('siniestros', $id);
	}
	
	public function get2($id){
		$this->db->select('S.*, TA.tipoaccidente as tipo, TC.tipocalzada, C.clima, H.horario, CA.causa as causaTxt, CA2.causa as causa2Txt, CA3.causa as causa3Txt, CI.ciudad, L.localidad');
		$this->db->from("siniestros as S");
		$this->db->join("config_tipoaccidentes as TA","S.tipoaccidente=TA.id","left");
		$this->db->join("config_tipocalzadas as TC","S.tipocalzada=TC.id","left");
		$this->db->join("config_climas as C","S.clima=C.id","left");
		$this->db->join("config_horarios as H","S.hora=H.id","left");
		$this->db->join("config_causas as CA","S.causa=CA.id","left");
		$this->db->join("config_causas as CA2","S.causa2=CA2.id","left");
		$this->db->join("config_causas as CA3","S.causa3=CA3.id","left");
		$this->db->join("config_ciudades as CI","S.id_ciudad=CI.id","left");
		$this->db->join("config_localidades as L","S.id_localidad=L.id","left");
		$this->db->where('S.id', $id);
		$this->db->limit(1);
	
		$query = $this->db->get();
	
		if($query->num_rows() == 1)
		{
			$result_array = $query->result_array();
			$result_array[0]["imagenes"] = parent::getImagenes('siniestros', $id);
			return $result_array[0];
		}
		return null;
	}
	
	public function find($criteria = array(), $n = NULL, $offset = NULL){
            $where = $this->_get_where($criteria);
            $orderby = parent::_get_orderby($criteria, 'id');
            $order = parent::_get_order($criteria, 'DESC');
             $this->db->select(''
                    . 'A.*, '
                    . 'CC.ciudad, '
                    . 'TA.tipoaccidente as tipo, '
                    . 'H.horario as horario, '
                    . 'C.causa as causaTxt, '
                    . 'C2.causa as causa2Txt, '
                    . 'C3.causa as causa3Txt , '
                    . 'TC.tipocalzada as tipocalzada, '
                    . 'CL.clima as clima, '
                    . 'L.localidad, '
                    . 'COUNT(DISTINCT VE.id) AS vehiculos, '
                    . 'COUNT(DISTINCT V.id) AS victimas, '
                    . '(SELECT COUNT(sv.id) FROM victimas sv WHERE sv.id_siniestro = A.id AND sv.lesion = "FALLECIDO") AS victimas_fatales'
                    , FALSE);
            
            $this->db->from("siniestros as A");
            $this->db->join("config_tipoaccidentes as TA", "TA.id=A.tipoaccidente", "left");
            $this->db->join("config_horarios as H", "H.id=A.hora", "left");
            $this->db->join("config_causas as C", "C.id=A.causa", "left");
            $this->db->join("config_causas as C2","A.causa2=C2.id","left");
            $this->db->join("config_causas as C3","A.causa3=C3.id","left");
            $this->db->join("config_tipocalzadas as TC", "TC.id=A.tipocalzada", "left");
            $this->db->join("config_climas as CL", "CL.id=A.clima", "left");
            $this->db->join("config_ciudades as CC", "CC.id=A.id_ciudad", "left");
            $this->db->join("config_localidades as L", "L.id=A.id_localidad", "left");
            $this->db->join("victimas as V", "V.id_siniestro=A.id", "left");
            $this->db->join("vehiculos as VE", "VE.id_siniestro=A.id", "left");
            $this->db->group_by("A.id");
            if ( ! empty($where))
                    $this->db->where($where, NULL, FALSE);
            if ( ! empty($n)  )
                    $this->db->limit($n, $offset);
            if ( ! empty($orderby))
                    $this->db->order_by($orderby, $order);

            $query = $this->db->get();

            if($query -> num_rows() > 0)
                return $query->result();
            else
    		return array();
	}
	
	public function count($criteria = array())
	{
		$where = $this->_get_where($criteria);
		return parent::count('siniestros as A', $where);
	}
	
	function delete($conditions)
	{
		return parent::deleteLogico('siniestros', $conditions);
	}
	
	function save($datos)
	{
		return parent::save('siniestros', $datos );
	}
	
	function insert($datos)
	{
		return parent::insert($datos, 'siniestros');
	}
	
	function getNextId()
	{
		return parent::getNextId('siniestros');
	}
	
	public function getVictima($id_victima)
	{
		return parent::get('victimas', $id_victima);
	}
	
	public function findVictimas($criteria = array(), $n = NULL, $offset = NULL)
	{
            $where = $this->_get_where_victimas($criteria);
            $orderby = parent::_get_orderby($criteria, 'V.id');
            $order = parent::_get_order($criteria, 'DESC');
            $this->db->select('*, V.id as idVictima, A.id as idSiniestro, VH.tipo as tipovehiculo');
            $this->db->from("victimas as V");
            $this->db->join("siniestros as A", "A.id=V.id_siniestro", "left");
            $this->db->join("vehiculos as VH", "VH.id=V.id_vehiculo", "left");
            if ( ! empty($where))
                    $this->db->where($where, NULL, FALSE);
            if ( ! empty($n)  )
                    $this->db->limit($n, $offset);
            if ( ! empty($orderby))
                    $this->db->order_by($orderby, $order);

            $query = $this->db->get();

            if($query -> num_rows() > 0)
    		return $query->result();
            else
    		return array();
	}
	
	public function countVictimas($criteria = array())
	{
		$where = $this->_get_where_victimas($criteria);
		$this->db->select('*, V.id as idVictima, A.id as idSiniestro');
    	$this->db->from("victimas as V");
    	$this->db->join("siniestros as A", "A.id=V.id_siniestro", "left");
    	if ( ! empty($where))
    		$this->db->where($where, NULL, FALSE);
    
    	return $this->db->count_all_results();
   
	}
	
	function saveVictima($datos)
	{
		return parent::save('victimas', $datos);
	}
	
	function deleteVictima($criteria)
	{
		return parent::delete('victimas', $criteria);
	}
	
	/************************VEHICULOS*************************************/
	
	public function getVehiculo($id_vehiculo)
	{
		return parent::get('vehiculos', $id_vehiculo);
	}
	
	public function findVehiculos($criteria = array(), $n = NULL, $offset = NULL)
	{
		$where = $this->_get_where_victimas($criteria);
		$orderby = parent::_get_orderby($criteria, 'V.id');
		$order = parent::_get_order($criteria, 'DESC');
		$this->db->select('*, V.id as idVehiculo, A.id as idSiniestro');
		$this->db->from("vehiculos as V");
		$this->db->join("siniestros as A", "A.id=V.id_siniestro", "left");
		if ( ! empty($where))
			$this->db->where($where, NULL, FALSE);
		if ( ! empty($n)  )
			$this->db->limit($n, $offset);
		if ( ! empty($orderby))
			$this->db->order_by($orderby, $order);
	
		$query = $this->db->get();
	
		if($query -> num_rows() > 0)
			return $query->result();
		else
			return array();
	}
        public function countVehiculos($id_siniestro = 0)
	{
            $this->db->select('*');
            $this->db->from("vehiculos as V");
            $this->db->where(" V.id = {$id_siniestro} ", NULL, FALSE);
    
            return $this->db->count_all_results();
   
	}
        
	function saveVehiculo($datos)
	{
		return parent::save('vehiculos', $datos);
	}
	
	function deleteVehiculo($criteria)
	{
		return parent::delete('vehiculos', $criteria);
	}
	
	/**********************************************************************/
	
	function _get_where($criteria)
	{
		$where = '1 = 1';
		if ( !isset($criteria['borrado']) )
		{
			$where .= " AND borrado = '0' ";
		}
		if ( isset($criteria['id_ciudad']) )
		{
			$where .= " AND A.id_ciudad = '".$criteria['id_ciudad']."' ";
		}
		if ( isset($criteria['fecha']) )
		{
			$where .= " AND A.fecha = '".$criteria['fecha']."' ";
		}
		if ( isset($criteria['fd']) )
		{
			$where .= " AND fecha >= '".$criteria['fd']."' ";
		}
		if ( isset($criteria['fh']) )
		{
			$where .= " AND fecha <= '".$criteria['fh']." 12:59' ";
		}
		if ( isset($criteria['tipoaccidente']) )
		{
			$where .= " AND A.tipoaccidente = '".$criteria['tipoaccidente']."' ";
		}
		if ( isset($criteria['id_siniestro']) )
		{
			$where .= " AND V.id_siniestro = '".$criteria['id_siniestro']."' ";
		}
		if ( isset($criteria['idc']) )
		{
			$where .= " AND A.id_ciudad = '".$criteria['idc']."' ";
		}
		if ( isset($criteria['idl']) )
		{
			$where .= " AND A.id_localidad = '".$criteria['idl']."' ";
		}
		if ( isset($criteria['patente']) )
		{
			$where .= " AND patentes LIKE '%".$criteria['patente']."%' ";
		}
		if ( isset($criteria['searchtext']) )
		{
			$searchText = urldecode($criteria['searchtext']);
			$where .= " AND (ubicacion LIKE '%".$searchText."%' || calle1 LIKE '%".$searchText."%' || calle2 LIKE '%".$searchText."%' || calle3 LIKE '%".$searchText."%' )";
		}
		return $where;
	}
	
	function _get_where_victimas($criteria)
	{
		$where = '1 = 1';
		if ( !isset($criteria['borrado']) )
		{
			$where .= " AND A.borrado = '0' ";
		}
		if ( isset($criteria['id_siniestro']) )
		{
			$where .= " AND V.id_siniestro= '".$criteria['id_siniestro']."' ";
		}
		if ( isset($criteria['id_ciudad']) )
		{
			$where .= " AND A.id_ciudad = '".$criteria['id_ciudad']."' ";
		}
		if ( isset($criteria['tipo']) )
		{
			$where .= " AND A.tipo = '".$criteria['tipo']."' ";
		}
		if ( isset($criteria['dni']) )
		{
			$where .= " AND V.dni = '".$criteria['dni']."' ";
		}
		if ( isset($criteria['lesion']) )
		{
			$where .= " AND V.lesion = '".$criteria['lesion']."' ";
		}
		if ( isset($criteria['patente']) )
		{
			$where .= " AND A.patentes like '%".$criteria['patente']."%' ";
		}
		if ( isset($criteria['fd']) )
		{
			$where .= " AND fecha >= '".$criteria['fd']."' ";
		}
		if ( isset($criteria['fh']) )
		{
			$where .= " AND fecha <= '".$criteria['fh']." 12:59' ";
		}
		
		return $where;
	}

	public function SqlFree($sql){
		$resultados = $this->db->query($sql);
    	return $resultados->result();
	}
}