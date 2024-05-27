<?php

if ( ! defined('BASEPATH'))
	exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	
	public function check_is_logged()
	{
		if(! $this->session->userdata('logged_user')){
			redirect('login');
		}
		// Get the user's ID and add it to the config array
		$user = $this->session->userdata('logged_user');
		$config = array('userID'=>$user['id']);
	
		// Load the ACL library and pas it the config array
		$this->load->library('acl',$config);
	
		// Get the perm key
		// I'm using the URI to keep this pretty simple ( https://www.example.com/test/this ) would be 'test_this'
		$acl_test = $this->uri->segment(1).'_';
		$acl_test .= ($this->uri->segment(2)!="")?$this->uri->segment(2):'index';
	
		// If the user does not have permission either in 'user_perms' or 'role_perms' redirect to login, or restricted, etc
		if ( !$this->acl->hasPermission($acl_test, $user['perms']) ) {
			redirect('home/error');
		}

	}
	
	function getValue($val){
		if (empty($val))
			return null;
		return $val;
	}
	
	function logActivity($action, $tabla, $id_item, $desc){
		$this->load->model('activity_model');
		$logged_user = $this->session->userdata('logged_user');
		$activity = array();
		$activity['fecha'] = date('Y-m-d H:i:s');
		$activity['id_user'] = $logged_user['id'];
		$activity['action'] = $action;
		$activity['tabla'] = $tabla;
		$activity['id_item'] = $id_item;
		$activity['descripcion'] = $desc;
		$this->activity_model->save($activity);
	}
	
}