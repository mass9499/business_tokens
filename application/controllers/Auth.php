<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_auth');
	}

	/* 
		Check if the login form is submitted, and validates the user credential
		If not submitted it redirects to the login page
	*/
	public function login()
	{

		$this->logged_in();

		$this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
           	$email_exists = $this->model_auth->check_email($this->input->post('email'));

           	if($email_exists == TRUE) {
           	    $login = $this->db->get_where('users', array('email' => $this->input->post('email')))->row_array();
           	// 	$login = $this->model_auth->login($this->input->post('email'), $this->input->post('password'));

           		if($this->input->post('password') == $login['password']) {

           			$logged_in_sess = array(
           				'id' => $login['id'],
           				'role' => $login['role'],
				        'username'  => $login['username'],
				        'email'     => $login['email'],
				        'login_account' => 'tokens',
				        'logged_in' => TRUE
					);

					$this->session->set_userdata($logged_in_sess);
           			redirect('dashboard', 'refresh');
           		}
           		else {
           			$this->data['errors'] = 'Incorrect username/password combination';
           			$this->load->view('login', $this->data);
           		}
           	}
           	else {
           		$this->data['errors'] = 'Email does not exists';

           		$this->load->view('login', $this->data);
           	}	
        }
        else {
            // false case
            $this->load->view('login');
        }	
	}

	/*
		clears the session and redirects to login page
	*/
	public function logout()
	{
		$this->session->sess_destroy();
        //redirect('auth/login', 'refresh');
        header("Location:https://signin.business360.co.in");
	}

}
