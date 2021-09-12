<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

	}

	public function account_users()
	{
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email!=', 'admin@afluencesoftech.com');
        $query = $this->db->get();
        $users = $query->result_array();
        
        echo json_encode($users);
	}

}
