<?php 

if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed'); 

class MY_Model extends CI_Model 
{ 
    public $table; 
    
    public function __construct() 
    { 
        parent::__construct(); 
        $this->table = get_Class($this); 
        $this->load->database(); 
    } 
    
    public function save($table, $data)
    {
    	if($table=="")
    	{
    		$table = $this->table;
    	}
    	$op = 'update';
    	$keyExists = FALSE;
    	$fields = $this->db->field_data($table);
       	foreach ($fields as $field)
    	{
    		if($field->primary_key==1)
    		{
    			$keyExists = TRUE;
    			if(!empty($data[$field->name]))
    			{
    				$this->db->where($field->name, $data[$field->name]);
    			}
    			else
    			{
    				$op = 'insert';
    			}
    		}
    	}
    	if($keyExists && $op=='update')
    	{
    		$this->db->set($data);
    		$result = $this->db->update($table);
    		if($result)
    			return 1 ; // update ok
   			return -1; // update error
    	}
    	else
    	{
    		$result = $this->db->insert($table,$data);
    		if ($result)
    			return $this->db->insert_id(); //el ultimo id insertado
    		return -1; // insert error
    	}
    }
    
    function search($conditions=NULL,$tablename="",$limit=500,$offset=0)
    {
    	if($tablename=="")
    	{
    		$tablename = $this->table;
    	}
    	if($conditions != NULL)
    		$this->db->where($conditions);
    
    	$query = $this->db->get($tablename,$limit,$offset=0);
    	return $query->result();
    }
    
    function insert($data,$tablename="")
    {
    	if($tablename=="")
    		$tablename = $this->table;
    	$this->db->insert($tablename,$data);
    	return $this->db->insert_id();
    }
    
    /**
     * Graba la relacion N.1 con una transaccion 
     * @param array $padre array con los datos de la tabla padre
     * @param string $tablenamePadre nombre de la tabla padre
     * @param array[array] $hijos
     * @param string $tablenameHijos nombre de la tabla de Hijos
     * @param string $rel Nombre del campo de la tabla Hijo que hace referencia a la tabla Padre
     */
    function insertAll($padre, $tablenamePadre, $hijos, $tablenameHijos, $rel)
    {
    	$this->db->trans_start();
		if (!empty($hijos)){
			$this->db->insert($tablenamePadre, $padre);
			$id_padre = $this->db->insert_id();
			foreach ($hijos as $hijo){
				$hijo[$rel] = $id_padre;
				$this->db->insert($tablenameHijos, $hijo);
			}
		}
		$this->db->trans_complete();
    }
    
    function update($data,$conditions,$tablename="")
    {
    	if($tablename=="")
    		$tablename = $this->table; 
    	$this->db->where($conditions);
    	$this->db->update($tablename,$data);
    	return $this->db->affected_rows();
    }
    
    /**
     * Borra los registros de la tabla segun el criterio
     * @param $table nombre de la tabla
     * @param $creteria array con las condiciones para el where
     * @return La cantidad de registros borrados.
     */
    function delete($table, $conditions)
    {
    	$this->db->where($conditions);
    	$this->db->delete($table);
    	return $this->db->affected_rows();
    }
    
    /**
     * Borra logicamente (borrado=1) los registros de la tabla segun el criterio
     * @param $table nombre de la tabla
     * @param $creteria array con las condiciones para el where
     * @return La cantidad de registros borrados.
     */
    function deleteLogico($table, $conditions)
    {
    	$this->db->set("borrado", 1);
		$this->db->where($conditions);
		$result = $this->db->update($table);
    	return $this->db->affected_rows();
    }
    
    /**
     * Deveulve todos los registros de la tabla segun el criterio
     * @param $table nombre de la tabla
     * @param $creteria array con las condiciones para el where
     * @param $defaultOrder nombre del campo para el ordenamiento por defecto.
     * @return Los registros que cumplen el criterio.
     */
    public function find($table, $where = null, $orderby = null, $order = null, $n = NULL, $offset = NULL)
    {
    	$this->db->select('*');
    	$this->db->from($table);
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
    
    /**
     * Deveulve la cantidad de elementos segun la tabla y el criterio
     * @param $table nombre de la tabla
     * @param $creteria array con las condiciones para el where
     * @return cantidad de registros que cumplen la condicion.
     */
    public function count($table, $where)
    {
    	$this->db->from($table);
	   	$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
    }
    
    /**
     * Vacia todos los datos de la tabla
     * @param $table nombre de la tabla
     * @return La cantidad de registros borrados
     */
    function truncate($tablename="")
    {
    	if($tablename=="")
    		$tablename = $this->table;
    	$this->db->truncate($tablename);
    	return $this->db->affected_rows();
    }
    
    /**
     * Obtine un registro por ID 
     * @param $table nombre de la tabla
     * @param $id de la tabla
     * @return Un array con el registro encontrado o null
     */
    public function get($table, $id){
    	$this->db->select('*');
    	$this->db->from($table);
    	$this->db->where('id', $id);
    	$this->db->limit(1);
    
    	$query = $this->db->get();
    
    	if($query->num_rows() == 1)
    	{
    		$result_array = $query->result_array();
    		return $result_array[0];
    	}
    	return null;
    }
    
    /**
     * Obtiene el orderby definido en el criteria y si no tiene retorna el orden por defecto.
     * @param $defaultOrderBy orden por defecto si no hay ninguno definido.
     * @param $creteria array con las condiciones para el where
     * @return el orderBy.
     */
    function _get_orderby($criteria, $defaultOrderBy)
    {
    	$orderby = '';
    	if ( ! empty($criteria['orderby']) )
    		$orderby = $criteria['orderby'];
    	else
    		$orderby = $defaultOrderBy;
    	return $orderby;
    }
    
    /**
     * Obtiene el orderby definido en el criteria y si no tiene retorna el orden por defecto.
     * @param $defaultOrder orden por defecto si no hay ninguno definido.
     * @param $creteria array con las condiciones para el where
     * @return el order.
     */
    function _get_order($criteria, $defaultOrder)
    {
    	$order = '';
    	if ( ! empty($criteria['order']) )
    		$order .= $criteria['order'];
    	else
    		$order .= $defaultOrder;
    	return $order;
    }
    
    /**
     * Obtiene el próximo ID de la tabla
     * @param $tabla
     * @return el próximo ID de la tabla.
     */
    function getNextId($tabla)
    {
    	$maxid = 0;
    	$row = $this->db->query('SELECT MAX(id) AS maxid FROM '.$tabla)->row();
    	if ($row) {
    		$maxid = $row->maxid;
    	}
    	return $maxid + 1;
    }
    
    /**
     * Obtiene las imagenes para una tabla y un Item (galeria, contenido, etc)
     * @param $tabla
     * @param $idItem
     * @return lista de imagenes.
     */
    public function getImagenes($tabla, $idItem)
    {
    	$this->db->select('*');
    	$this->db->from('imagenes as I');
    	$this->db->where("I.iditem", $idItem);
    	$this->db->where("I.tablename", $tabla);
    
    	$query = $this->db->get();
    
    	if($query -> num_rows() > 0)
    		return $query->result();
    	else
    		return false;
    }
    
}