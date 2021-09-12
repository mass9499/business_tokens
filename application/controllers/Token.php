<?php 

class Token extends CI_controller
{   
    
	public function add_token_view()
	{
		$data['page_title'] = 'Token';
		
		$data['price_master'] = $this->db->get('price_master')->result_array();
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/header_menu');
		$this->load->view('templates/side_menubar');
		$this->load->view('token/token_add_view', $data);
		$this->load->view('templates/footer');
		
	}

	public function token_save()
	{   
	    $data['created_at']      = date('Y-m-d H:i:s');
	    $data['token_id']        = $this->input->post('token_id');
	    $data['parent_name']     = $this->input->post('parent_name');
	    $data['parent_phone']    = $this->input->post('parent_phone');
	    $data['child_count']      = $this->input->post('child_count');
	    $data['child_name']      = implode(';', $this->input->post('child_name'));
	    $data['child_age']       = implode(';', $this->input->post('child_age'));
	    $data['child_gender']    = implode(';', $this->input->post('child_gender'));
	    
	    $data['price_master'] = $this->input->post('price_master');
	    
	    $data['token_status'] = 1;
	   
	  
	 $insert =  $this->db->insert('token_table', $data);
	   if( $insert == true )
	   {
	      $this->session->set_flashdata('success','Added Token successfully');   
	   }else {
	         $this->session->set_flashdata('errors','Added Token failed');
	   }
	   
	   redirect('token/token_list');
	   
	}
	
	public function test_api_print()
	{
	    echo "Testing";
	   // echo "<script type='text/javascript'> alert('Test Alert'); </script>";
	}
	
	public function token_list()
	{
	   // $data['all_token_list']  = $this->db->get_where('token_table')->result_array();
	    $data['all_token_list']  = $this->db->order_by('token_id', 'DESC')->get_where('token_table', array('created_at>='=>date('Y-m-d 00:00:00'), 'created_at<=' =>date('Y-m-d 23:59:59'), 'token_status' => 1))->result_array();
	    $data['price_category'] = $this->db->get_where('price_master')->row_array();
	    $data['comp_details'] = $this->db->get_where('company')->row_array();
	    $data['page_title'] = 'Token';
		$this->load->view('templates/header', $data);
		$this->load->view('templates/header_menu');
		$this->load->view('templates/side_menubar');
		$this->load->view('token/token_search_view', $data);
		$this->load->view('templates/footer');	 
	}

    public function refresh_rows()
    {
        $todays_tokens  = $this->db->order_by('token_id', 'DESC')->get_where('token_table', array('created_at>='=>date('Y-m-d 00:00:00'), 'created_at<=' =>date('Y-m-d 23:59:59'), 'token_status' => 1))->result_array();
        echo json_encode($todays_tokens);
    }

    public function print_token_save($rowid)
    {
        $tdata['token_gen_status'] = 1;
        $tdata['token_created_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $rowid);
        $this->db->update('token_table', $tdata);
        
        echo 1;
    }

    public function print_invoice_save($rowid)
    {
        $cost = $this->input->post('cost');
        $payment_mode = $this->input->post('payment_mode');
        
        if($payment_mode == 'cash') {
            $received = $this->input->post('received');
            $balance = $this->input->post('balance');
        }
        
        
        $idata['invoice_gen_status'] = 1;
        $idata['print_gen_status'] = 1;
        $idata['invoice_created_at'] = date('Y-m-d H:i:s');
        if($cost != 'na'){
            $idata['total_cost'] = $cost;
            $idata['payment_mode'] = $payment_mode;
            if($payment_mode == 'cash') {
                $idata['received'] = $received;
                $idata['balance'] = $balance;
            }
        }
        
        $this->db->where('id', $rowid);
        $this->db->update('token_table', $idata);
        
        echo 1;
    }

    public function print_gen_save($rowid)
    {
        $tdata['print_gen_status'] = 1;
        $this->db->where('id', $rowid);
        $this->db->update('token_table', $tdata);
        
        echo 1;
    }

    public function undo_token_gen($rowid)
    {
        $tdata['token_gen_status'] = 0;
        $tdata['invoice_gen_status'] = 0;
        $this->db->where('id', $rowid);
        $this->db->update('token_table', $tdata);
        
        redirect('token/token_list');
    }

    public function undo_invoice_gen($rowid)
    {
        $idata['invoice_gen_status'] = 0;
        
        $this->db->where('id', $rowid);
        $this->db->update('token_table', $idata);
        
        redirect('token/token_list');
    }

	public function token_pricemaster_view()
	{
	  	$data['page_title'] = 'Price Master';
	  	$data['price_category'] = $this->db->get_where('price_master')->result_array();
	   // $data['max_occ'] = $this->db->get_where('occupancy_tbl')->row_array();
	    
	    $this->load->view('templates/header', $data);
		$this->load->view('templates/header_menu');
		$this->load->view('templates/side_menubar');
		$this->load->view('token/token_pricemaster_view', $data);
		$this->load->view('templates/footer');  
	}
	
	public function delete_token($tokenid)
	{
	    $data['token_status'] = 0;
	    
	    $this->db->where('id', $tokenid);
	    $this->db->update('token_table', $data);
	    
	    redirect('token/token_list');
	}
	
	public function pricemaster_modal_save()
	{
	    
	 $data['primary_cost'] = $this->input->post('cost1'); 
	 $data['secondary_cost'] = $this->input->post('extracost1'); 
	 $this->db->where('id', '1');
	 $this->db->update('price_master', $data);
	 
	 $data['primary_cost'] = $this->input->post('cost2'); 
	 $data['secondary_cost'] = $this->input->post('extracost2'); 
	 $this->db->where('id', '2');
	 $this->db->update('price_master', $data);
	 
	 $data['primary_cost'] = $this->input->post('cost3'); 
	 $data['secondary_cost'] = $this->input->post('extracost3'); 
	  $this->db->where('id', '3');
	 $this->db->update('price_master', $data);
	 
	 $data['primary_cost'] = $this->input->post('cost4'); 
	 $data['secondary_cost'] = $this->input->post('extracost4'); 
	 $this->db->where('id', '4');
	 $this->db->update('price_master', $data);
	
	 
	 redirect('token/token_pricemaster_view');
	    
	 }
	public function pricemaster_category_save()
	{
	        $current_price_method  = $this->input->post('price_radio1');
	   
            $pmdata_all['active_status'] = 0;
            $this->db->where('id >', 0);
            $this->db->update('price_master', $pmdata_all);
            
            $pmdata_this['active_status'] = 1;
            $this->db->where('id', $current_price_method);
            $this->db->update('price_master', $pmdata_this);
	   
	    redirect('token/token_pricemaster_view');
	}

    public function calculate_cost($rowid)
    {
        $token_data = $this->db->get_where('token_table', array('id' => $rowid))->row_array();
        
        $resdata['token_id'] = $token_data['token_id'];
        $resdata['child_count'] = $token_data['child_count'];
        $resdata['payment_mode'] = $token_data['payment_mode'];
        $resdata['received'] = $token_data['received'];
        $resdata['balance'] = $token_data['balance'];
        
        if($token_data['invoice_gen_status'] == 1) {
            $resdata['out_time'] = date('h:i a', strtotime($token_data['invoice_created_at']));
            
            $out_time = strtotime($token_data['invoice_created_at']);
            $in_time = strtotime($token_data['token_created_at']);
          } else {
            $resdata['out_time'] = date('h:i a');
           
            $out_time = strtotime(date("Y-m-d H:i:s"));
            $in_time = strtotime($token_data['token_created_at']);
          }
            
            $diff = $out_time-$in_time;
            $total_mins = floor($diff/60); 
            
            $total_mins_val = $total_mins % 60;
            
            $total_hours_val = ($total_mins - $total_mins_val) / 60;
            
            $resdata['total_hours_val'] = $total_hours_val;
            $resdata['total_mins_val'] = $total_mins_val;
            
            $this_price_master = $token_data['price_master'];
            if($this_price_master > 0) {
                $price_category = $this->db->get_where('price_master', array('id' => $this_price_master))->row_array();
            } else {
                $price_category = $this->db->get_where('price_master', array('active_status' => 1))->row_array();
            }
        
            $hrcost = $price_category['primary_cost'];
            $mincost =$price_category['secondary_cost'];
         
          
          /*if($total_mins < 60 )
          {
             $price = $price_category['primary_cost'] / 60;
              
              $resdata['total_price'] = $price * $total_mins; 
          }
          else if($total_mins >= 60 && $total_mins <= 65)
          {
                $resdata['total_price'] = $price_category['primary_cost'];
                
          } 
          else if($total_mins > 65)
          {    
               
             $remain_mins = $total_mins - 60;
                
             $remain_cost = $remain_mins * $mincost;
            
             $resdata['total_price'] =  $remain_cost + $hrcost;
                  
          }
          else
          {
               $resdata['total_price'] = 'N/A';
          }
          */
          
              if($price_category['id'] == 1) {
                          
                  if($total_mins < 60 ) {
                        $res_price = $price_category['primary_cost'];
                        $resdata['total_price'] = round($res_price, 2);
                  } else if($total_mins >= 60 && $total_mins <= 65) {
                        $res_price = $price_category['primary_cost'];
                        $resdata['total_price'] = round($res_price, 2);
                  } else if($total_mins > 65) {    
                     $remain_mins = $total_mins - 60;
                     $remain_cost = $remain_mins * $mincost;
                     $res_price =  $remain_cost + $hrcost;
                     $resdata['total_price'] = round($res_price, 2);
                  } else {
                       $resdata['total_price'] = 'N/A';
                  }
                  
                } else if($price_category['id'] == 2) {
                  
                  if($total_mins < 45 ) {
                        $res_price = $price_category['primary_cost'];
                        $resdata['total_price'] = round($res_price, 2);
                  } else if($total_mins >= 45 && $total_mins <= 50) {
                        $res_price = $price_category['primary_cost'];
                        $resdata['total_price'] = round($res_price, 2);
                  } else if($total_mins > 50) {    
                     $remain_mins = $total_mins - 45;
                     $remain_cost = $remain_mins * $mincost;
                     $res_price =  $remain_cost + $hrcost;
                     $resdata['total_price'] = round($res_price, 2);
                  } else {
                       $resdata['total_price'] = 'N/A';
                  }
                    
                } else if($price_category['id'] == 3) {
                   
                   if($total_mins < 30 ) {
                        $res_price = $price_category['primary_cost'];
                        $resdata['total_price'] = round($res_price, 2);
                  } else if($total_mins >= 30 && $total_mins <= 35) {
                        $res_price = $price_category['primary_cost'];
                        $resdata['total_price'] = round($res_price, 2);
                  } else if($total_mins > 35) {    
                     $remain_mins = $total_mins - 30;
                     $remain_cost = $remain_mins * $mincost;
                     $res_price =  $remain_cost + $hrcost;
                     $resdata['total_price'] = round($res_price, 2);
                  } else {
                       $resdata['total_price'] = 'N/A';
                  }
                    
                } else if($price_category['id'] == 4) {
                   
                   if($total_mins < 15 ) {
                        $res_price = $price_category['primary_cost'];
                        $resdata['total_price'] = round($res_price, 2);
                  } else if($total_mins >= 15 && $total_mins <= 20) {
                        $res_price = $price_category['primary_cost'];
                        $resdata['total_price'] = round($res_price, 2);
                  } else if($total_mins > 20) {    
                     $remain_mins = $total_mins - 15;
                     $remain_cost = $remain_mins * $mincost;
                     $res_price =  $remain_cost + $hrcost;
                     $resdata['total_price'] = round($res_price, 2);
                  } else {
                       $resdata['total_price'] = 'N/A';
                  }
                    
                } else {
                   
                   if($total_mins < 60 ) {
                        $res_price = $price_category['primary_cost'];
                        $resdata['total_price'] = round($res_price, 2);
                  } else if($total_mins >= 60 && $total_mins <= 65) {
                        $res_price = $price_category['primary_cost'];
                        $resdata['total_price'] = round($res_price, 2);
                  } else if($total_mins > 65) {    
                     $remain_mins = $total_mins - 60;
                     $remain_cost = $remain_mins * $mincost;
                     $res_price =  $remain_cost + $hrcost;
                     $resdata['total_price'] = round($res_price, 2);
                  } else {
                       $resdata['total_price'] = 'N/A';
                  }
                    
            }
            
            echo json_encode($resdata);
    }

    public function invoice()
    {
        $data['page_title'] = 'Invoice';
        
        $form_submission = $this->input->post('form_submit');
        
        if(!empty($form_submission)) {
            
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            
            $fromdateformat = date('Y-m-d 00:00:00', strtotime($from_date));
            $todateformat = date('Y-m-d 23:59:59', strtotime($to_date));
            
            $data['all_token_list']  = $this->db->order_by('token_id', 'DESC')->get_where('token_table', array('invoice_gen_status' => 1, 'created_at>=' => $fromdateformat, 'created_at<=' => $todateformat, 'token_status' => 1))->result_array();
            
            
            if(!empty($data['all_token_list'])) {
            
                $data['total_tokens'] = count($data['all_token_list']);
                
                $total_cost = 0;
                foreach($data['all_token_list'] as $key =>  $itokens) {
                    $total_cost += $itokens['total_cost'];
                }
                $data['total_cost'] = $total_cost;
            } else {
                $data['total_tokens'] = 0;
                $data['total_cost'] = 0;
            }   
            
        } else {
            
            $fromdateformat = date('Y-m-d 00:00:00');
            $todateformat = date('Y-m-d 23:59:59');
            
            $data['from_date'] = date('Y-m-d');
            $data['to_date'] = date('Y-m-d');;
            
            $data['all_token_list']  = $this->db->order_by('token_id', 'DESC')->get_where('token_table', array('invoice_gen_status' => 1, 'created_at>=' => $fromdateformat, 'created_at<=' => $todateformat, 'token_status' => 1))->result_array();
      
            if(!empty($data['all_token_list'])) {
            
                $data['total_tokens'] = count($data['all_token_list']);
                
                $total_cost = 0;
                foreach($data['all_token_list'] as $key =>  $itokens) {
                    $total_cost += $itokens['total_cost'];
                }
                $data['total_cost'] = $total_cost;
            } else {
                $data['total_tokens'] = 0;
                $data['total_cost'] = 0;
            }   
            
        }
        
        $this->load->view('templates/header', $data);
		$this->load->view('templates/header_menu');
		$this->load->view('templates/side_menubar');
		$this->load->view('reports/invoice', $data);
		$this->load->view('templates/footer');  
       
    }



}

?>