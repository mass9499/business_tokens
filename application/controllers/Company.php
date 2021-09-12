<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('upload');
        
        
		$this->not_logged_in();

		$this->data['page_title'] = 'Company';

		$this->load->model('model_company');
	}

    /* 
    * It redirects to the company page and displays all the company information
    * It also updates the company information into the database if the 
    * validation for each input field is successfully valid
    */
	public function index()
	{  
        if(!in_array('updateCompany', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
		$this->form_validation->set_rules('service_charge_value', 'Charge Amount', 'trim|integer');
		$this->form_validation->set_rules('vat_charge_value', 'Vat Charge', 'trim|integer');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('image', 'Image');
	
        if ($this->form_validation->run() == TRUE) {
            // true case
            
            //file upload
                $config['upload_path']          = './assets/company_logo/';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 2048;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);
                
                 if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                }
                
            
      /*      $uploaddir = 'assets/company_logo/';
            if(!file_exists($uploaddir)){
                mkdir('assets/company_logo', 0777, true);
            }
            
            $uploadfile = $uploaddir. $_FILES['image']['name'];
            
            if($_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/png' || $_FILES['image']['type'] == 'image/jpg')
            {
                if($_FILES['image']['size'] <= '300000' ){
                        if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)){
                            echo "upload success";
                           
                            $data['image'] = $uploadfile; 
                        }else{
                            echo "possible file upload attack";
                        }
                }else{
                    $this->session->set_flashdata('res', 'please use under 3mb file');
                }
                
                
            }else{
                $this->session->set_flashdata('res', 'please use jpg and png format file');
                
             }  
             
             */
            
            
        	$data = array(
        		'company_name' => $this->input->post('company_name'),
        		'service_charge_value' => $this->input->post('service_charge_value'),
        		'vat_charge_value' => $this->input->post('vat_charge_value'),
        		'address' => $this->input->post('address'),
        		'phone' => $this->input->post('phone'),
        		'country' => $this->input->post('country'),
        		'maxocc' => $this->input->post('maxocc'),
        		'message' => $this->input->post('message'),
                'currency' => $this->input->post('currency')
                
                
        	);
        //	print_r($_FILES['company_logo']);die;
        
        	       if(isset($_FILES['company_logo'])){
        	           if (!file_exists('assets/company_logo')) {
                            mkdir('assets/company_logo', 0777, true);
                        } 
                        $uploaddir = 'assets/company_logo/';
        	            $uploadfile = $uploaddir. uniqid(). $_FILES['company_logo']['name']; 
        	            
        	            if(move_uploaded_file($_FILES['company_logo']['tmp_name'], $uploadfile)){
                            //echo "upload success"; 
                            $data['logo_path'] = $uploadfile;
        	                
        	            }else{
        	                
        	               // echo "possible file upload attack";
        	            }
        	            
        	       }
                    	
                         
        
        	$update = $this->model_company->update($data, 1);
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('company/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('company/index', 'refresh');
        	}
        }
        else {

            // false case
            $this->data['currency_symbols'] = $this->currency();
        	$this->data['company_data'] = $this->model_company->getCompanyData(1);
			$this->render_template('company/index', $this->data);			
        }	

		
	}

}