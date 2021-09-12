<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class App extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $_POST = json_decode($this->input->raw_input_stream, true);
        $_GET = json_decode($this->input->raw_input_stream, true);
    }
    
    public function login_post()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        $checkuser = $this->db->get_where('users', array('email' => $username))->row_array();
        
        if(!empty($checkuser)) {
            if($password == $checkuser['password']) {
                $status = array('status' => 1, 'message' => 'success');
                $resultdata = $checkuser;
            } else {
                $status = array('status' => 0, 'message' => 'Incorrect Password');
                $resultdata = $this->input->post();
            }
        } else {
            $status = array('status' => 0, 'message' => 'Invalid Username');
            $resultdata = $this->input->post();
        }
        
        $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
    }
    
    public function dashboard_post()
    {
        
            $curr_date_start = date('Y-m-d 00:00:00');
            $curr_date_end = date('Y-m-d 23:59:59');
            
            $all_tokens = $this->db->get_where('token_table')->result_array();
            $all_invoice_tokens = $this->db->get_where('token_table', array('invoice_gen_status' => 1))->result_array();
            // $today_tokens = $this->db->get_where('token_table', array('Date(created_at)' => date('d'), 'Month(created_at)' => date('m'), 'Year(created_at)' => date('Y')))->result_array();
            $today_tokens = $this->db->order_by('token_id', 'DESC')->get_where('token_table', array('created_at >=' => $curr_date_start, 'created_at <=' => $curr_date_end))->result_array();
            
            if(!empty($all_tokens)) { $resultdata['all_tokens_count'] = count($all_tokens); } else { $resultdata['all_tokens_count'] = 0; }
            if(!empty($all_invoice_tokens)) { $resultdata['all_invoice_tokens_count'] = count($all_invoice_tokens); } else { $resultdata['all_invoice_tokens_count'] = 0; }
            if(!empty($today_tokens)) { $resultdata['today_tokens_count'] = count($today_tokens); $resultdata['today_tokens'] = $today_tokens; } else { $resultdata['today_tokens_count'] = 0; $resultdata['today_tokens'] = array(); } 
            
            
            $status = array('status' => 1, 'message' => 'success');
            $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
            
    }
    
    
    public function add_token_post()
    {
        
        $postdata = array(
            'token_id' => $this->input->post('token_id'),
            'parent_name' => $this->input->post('parent_name'),
            'parent_phone' => $this->input->post('parent_phone'),
            'child_name' => $this->input->post('child_name'),
            'child_age' => $this->input->post('child_age'),
            'child_gender' => $this->input->post('child_gender'),
            'created_at' => date('Y-m-d H:i:s')
            // 'token_gen_status' => 1,
            // 'token_created_at' => date('Y-m-d H:i:s')
        );
        
        
        // $ch = curl_init();
        
        // curl_setopt($ch, CURLOPT_URL,"https://business360.co.in/tokens/token/token_list");
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // $server_output = curl_exec($ch);
        
        // curl_close ($ch);
        
        // if ($server_output == "OK") { print_r($server_output);  } else { print_r($server_output); }
        
        // print_r('Done');
        // die;
        
            $this->db->insert('token_table', $postdata);
            $insert_id = $this->db->insert_id();
            
            if($insert_id > 0) {
                $status = array('status' => 1, 'message' => 'success');
                $resultdata = $this->input->post();
            } else {
                $db_err = $this->db->error();
                $status = array('status' => 0, 'message' => $db_err['message']);
                $resultdata = $this->input->post();
            }
            
            $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
            
    }
    
    public function token_list_post()
    {
        
        $fromdateformat = date('Y-m-d 00:00:00');
        $todateformat = date('Y-m-d 23:59:59');
        
            $tokens = $this->db->order_by('token_id', 'DESC')->get_where('token_table', array('created_at >=' => $fromdateformat, 'created_at <=' => $todateformat))->result_array();
            
            if(!empty($tokens)) {
                $status = array('status' => 1, 'message' => 'success');
            } else {
                $status = array('status' => 0, 'message' => 'No data found');
            }
            
            $resultdata['total_rows'] = count($tokens);
            $resultdata['tokens'] = $tokens;
            
            $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
            
    }
    
    public function scan_qr_post()
    {
        $token = $this->input->post('token');
        
        $token_row = $this->db->get_where('token_table', array('token_id' => $token))->row_array();
        
    }
    
    public function view_token_post()
    {
    
        $rowid = $this->input->post('row_id');
        
        $resultdata = $this->db->get_where('token_table', array('id' => $rowid))->row_array();
        
        if(!empty($resultdata)) {
            $status = array('status' => 1, 'message' => 'success');
        } else {
            $status = array('status' => 0, 'message' => 'No data found');
        }
        
        $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
    }
    
    public function generate_token_post()
    {
        $tokenid = $this->input->post('token_id');
        
        $tokenrow = $this->db->get_where('token_table', array('token_id' => $tokenid))->row_array();
        
        $token_data['token_gen_status'] = 0;
        // $token_data['token_created_at'] = date('Y-m-d H:i:s');
        
        if(!empty($tokenrow)) {
            $this->db->where('id', $tokenrow['id']);
            $this->db->update('token_table', $token_data);
            
            $status = array('status' => 1, 'message' => 'success');
        } else {
            $status = array('status' => 0, 'message' => 'No data found');
        }
        
        $resultdata = $this->db->get_where('token_table', array('token_id' => $tokenid))->row_array();
        
        $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
    }
    
    public function undo_generate_token_post()
    {
        $tokenid = $this->input->post('token_id');
        
        $tokenrow = $this->db->get_where('token_table', array('token_id' => $tokenid))->row_array();
        
        $token_data['token_gen_status'] = 0;
        $token_data['token_created_at'] = date('Y-m-d H:i:s');
        
        if(!empty($tokenrow)) {
            $this->db->where('id', $tokenrow['id']);
            $this->db->update('token_table', $token_data);
            
            $status = array('status' => 1, 'message' => 'success');
        } else {
            $status = array('status' => 0, 'message' => 'No data found');
        }
        
        $resultdata = $this->db->get_where('token_table', array('id' => $tokenid))->row_array();
        
        $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
    }
    
    public function generate_invoice_post()
    {
        $token_id = $this->input->post('token_id');
        $cost = $this->input->post('cost');
        $payment_mode = $this->input->post('payment_mode');
        $received_amount = $this->input->post('received_amount');
        $balance_amount = $this->input->post('balance_amount');
        
        $tokenrow = $this->db->get_where('token_table', array('token_id' => $token_id))->row_array();
        
        $token_data['invoice_gen_status'] = 1;
        $token_data['print_gen_status'] = 0;
        $token_data['invoice_created_at'] = date('Y-m-d H:i:s');
        $token_data['total_cost'] = $cost;
        $token_data['payment_mode'] = $payment_mode;
        
        if($payment_mode == 'cash') {
            $token_data['received'] = $received_amount;
            $token_data['balance'] = $balance_amount;
        }
        
        
        if(!empty($tokenrow)) {
            $this->db->where('id', $tokenrow['id']);
            $this->db->update('token_table', $token_data);
            
            $status = array('status' => 1, 'message' => 'success');
        } else {
            $status = array('status' => 0, 'message' => 'No data found');
        }
        
        $resultdata = $this->db->get_where('token_table', array('token_id' => $token_id))->row_array();
        
        $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
    }
    
    public function undo_generate_invoice_post()
    {
        $tokenid = $this->input->post('token_id');
        
        $tokenrow = $this->db->get_where('token_table', array('token_id' => $tokenid))->row_array();
        
        $token_data['invoice_gen_status'] = 0;
        $token_data['invoice_created_at'] = date('Y-m-d H:i:s');
        
        if(!empty($tokenrow)) {
            $this->db->where('id', $tokenrow['id']);
            $this->db->update('token_table', $token_data);
            
            $status = array('status' => 1, 'message' => 'success');
        } else {
            $status = array('status' => 0, 'message' => 'No data found');
        }
        
        $resultdata = $this->db->get_where('token_table', array('token_id' => $rowid))->row_array();
        
        $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
    }
    
    public function price_master_list_post()
    {
        $resultdata['active_price_method'] = $this->db->get_where('price_master', array('active_status' => 1))->row_array();
        $resultdata['all_price_methods'] = $this->db->get_where('price_master')->result_array();
            
            $status = array('status' => 1, 'message' => 'success');
            $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
    }
    
    public function price_master_update_post()
    {
        
        $price_method_list = $this->input->post('price_method_list');
        
            foreach($price_method_list as $key => $pmlist) {
                $this_price_method = $pmlist['price_method'];
                $pmdata['primary_cost'] = $pmlist['primary_cost'];
                $pmdata['secondary_cost'] = $pmlist['secondary_cost'];
                
                $this->db->where('id', $this_price_method);
                $this->db->update('price_master', $pmdata);
            }
            
            $resultdata = $price_method_list;
            
            $status = array('status' => 1, 'message' => 'success');
            $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
    }
    
    public function price_method_update_post()
    {
        
            $current_price_method = $this->input->post('price_method');
            
            $pmdata_all['active_status'] = 0;
            $this->db->where('id >', 0);
            $this->db->update('price_master', $pmdata_all);
            
            $pmdata_this['active_status'] = 1;
            $this->db->where('id', $current_price_method);
            $this->db->update('price_master', $pmdata_this);
            
            $resultdata['active_price_method'] = $this->db->get_where('price_master', array('id' => $current_price_method))->result_array();
            
            $status = array('status' => 1, 'message' => 'success');
            $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
    }
    
    public function invoice_list_by_dates_post()
    {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        
        $fromdateformat = date('Y-m-d 00:00:00', strtotime($from_date));
        $todateformat = date('Y-m-d 23:59:59', strtotime($to_date));
        
        $invoice_tokens = $this->db->order_by('token_id', 'DESC')->get_where('token_table', array('invoice_gen_status' => 1, 'created_at>=' => $fromdateformat, 'created_at<=' => $todateformat))->result_array();
            
            foreach($invoice_tokens as $key => $thistoken) {
                
                        $out_time = strtotime($thistoken['invoice_created_at']);
                        $in_time = strtotime($thistoken['token_created_at']);
                        
                        $diff = $out_time-$in_time;
                        $total_mins = floor($diff/60); 
                        
                        $total_mins_val = $total_mins % 60;
                        
                        $total_hours_val = ($total_mins - $total_mins_val) / 60;
                        
                        $resdata['total_hours_val'] = $total_hours_val;
                        $resdata['total_mins_val'] = $total_mins_val;
                        
                        $price_category = $this->db->get_where('price_master', array('active_status' => 1))->row_array();
                        
                        $hrcost = $price_category['primary_cost'];
                        $mincost = $price_category['secondary_cost'];
                     
                            if($price_category['id'] == 1) {
                      
                              if($total_mins < 60 ) {
                                 $price = $price_category['primary_cost'] / 60;
                                  $res_price = $price * $total_mins; 
                              } else if($total_mins >= 60 && $total_mins <= 65) {
                                    $res_price = $price_category['primary_cost'];
                              } else if($total_mins > 65) {    
                                 $remain_mins = $total_mins - 60;
                                 $remain_cost = $remain_mins * $mincost;
                                 $res_price =  $remain_cost + $hrcost;
                              } else {
                                   $total_price = 'N/A';
                              }
                              
                            } else if($price_category['id'] == 2) {
                              
                              if($total_mins < 45 ) {
                                 $price = $price_category['primary_cost'] / 45;
                                  $res_price = $price * $total_mins; 
                              } else if($total_mins >= 45 && $total_mins <= 50) {
                                    $res_price = $price_category['primary_cost'];
                              } else if($total_mins > 50) {    
                                 $remain_mins = $total_mins - 45;
                                 $remain_cost = $remain_mins * $mincost;
                                 $res_price =  $remain_cost + $hrcost;
                              } else {
                                   $total_price = 'N/A';
                              }
                                
                            } else if($price_category['id'] == 3) {
                               
                               if($total_mins < 30 ) {
                                 $price = $price_category['primary_cost'] / 30;
                                  $res_price = $price * $total_mins; 
                              } else if($total_mins >= 30 && $total_mins <= 35) {
                                    $res_price = $price_category['primary_cost'];
                              } else if($total_mins > 35) {    
                                 $remain_mins = $total_mins - 30;
                                 $remain_cost = $remain_mins * $mincost;
                                 $res_price =  $remain_cost + $hrcost;
                              } else {
                                   $total_price = 'N/A';
                              }
                                
                            } else if($price_category['id'] == 4) {
                               
                               if($total_mins < 15 ) {
                                 $price = $price_category['primary_cost'] / 15;
                                  $res_price = $price * $total_mins; 
                              } else if($total_mins >= 15 && $total_mins <= 20) {
                                    $res_price = $price_category['primary_cost'];
                              } else if($total_mins > 20) {    
                                 $remain_mins = $total_mins - 15;
                                 $remain_cost = $remain_mins * $mincost;
                                 $res_price =  $remain_cost + $hrcost;
                              } else {
                                   $total_price = 'N/A';
                              }
                                
                            } else {
                               
                               if($total_mins < 60 ) {
                                 $price = $price_category['primary_cost'] / 60;
                                  $res_price = $price * $total_mins; 
                              } else if($total_mins >= 60 && $total_mins <= 65) {
                                    $res_price = $price_category['primary_cost'];
                              } else if($total_mins > 65) {    
                                 $remain_mins = $total_mins - 60;
                                 $remain_cost = $remain_mins * $mincost;
                                 $res_price =  $remain_cost + $hrcost;
                              } else {
                                   $total_price = 'N/A';
                              }
                                
                            }
                $invoice_tokens[$key]['total_price'] = $res_price;
            }
            
            if(!empty($invoice_tokens)) {
                $status = array('status' => 1, 'message' => 'success');
            } else {
                $status = array('status' => 0, 'message' => 'No data found');
            }
            
            $resultdata['total_rows'] = count($invoice_tokens);
            $resultdata['invoice_tokens'] = $invoice_tokens;
            
            $this->response(['status' => $status, 'details' => $resultdata], REST_Controller::HTTP_OK);
            
        
    }
    
    public function calculate_token_post()
    {
        $token_id = $this->input->post('token_id');
        
        $token_data = $this->db->get_where('token_table', array('token_id' => $token_id))->row_array();
        
        $resdata['token_id'] = $token_data['token_id'];
        
        $resdata['payment_mode'] = $token_data['payment_mode'];
        $resdata['received'] = $token_data['received'];
        $resdata['balance'] = $token_data['balance'];
        
        if($token_data['invoice_gen_status'] == 1) {
            $out_time = strtotime($token_data['invoice_created_at']);
            $in_time = strtotime($token_data['token_created_at']);
          } else {
            $out_time = strtotime(date("Y-m-d H:i:s"));
            $in_time = strtotime($token_data['token_created_at']);
          }
        
                    $resdata['token_generated_status'] = $token_data['token_gen_status'];
            
                    if($token_data['token_gen_status'] == 1) {
            
                            // $out_time = strtotime(date("Y-m-d H:i:s"));
                            // $in_time = strtotime($token_data['token_created_at']);
                            
                            $diff = $out_time-$in_time;
                            $total_mins = floor($diff/60); 
                            
                            $total_mins_val = $total_mins % 60;
                            
                            $total_hours_val = ($total_mins - $total_mins_val) / 60;
                            
                            $resdata['total_hours_val'] = (string) $total_hours_val;
                            $resdata['total_mins_val'] = (string) $total_mins_val;
                            
                            $this_price_master = $token_data['price_master'];
                            if($this_price_master > 0) {
                                $price_category = $this->db->get_where('price_master', array('id' => $this_price_master))->row_array();
                            } else {
                                $price_category = $this->db->get_where('price_master', array('active_status' => 1))->row_array();
                            }
                            
                            $hrcost = $price_category['primary_cost'];
                            $mincost =$price_category['secondary_cost'];
                         
                              if($price_category['id'] == 1) {
                                          
                                  if($total_mins < 60 ) {
                                    //  $price = $price_category['primary_cost'] / 60;
                                    //   $res_price = $price * $total_mins; 
                                      
                                    //   $resdata['total_price'] = (string) round($res_price, 2);
                                    
                                        $res_price = $price_category['primary_cost'];
                                            
                                        $resdata['total_price'] = (string) round($res_price, 2);
                                        
                                  } else if($total_mins >= 60 && $total_mins <= 65) {
                                        $res_price = $price_category['primary_cost'];
                                        $resdata['total_price'] = (string) round($res_price, 2);
                                  } else if($total_mins > 65) {    
                                     $remain_mins = $total_mins - 60;
                                     $remain_cost = $remain_mins * $mincost;
                                     $res_price =  $remain_cost + $hrcost;
                                     
                                     $resdata['total_price'] = (string) round($res_price, 2);
                                  } else {
                                       $resdata['total_price'] = 'N/A';
                                  }
                                  
                                } else if($price_category['id'] == 2) {
                                  
                                  if($total_mins < 45 ) {
                                        $res_price = $price_category['primary_cost'];
                                        $resdata['total_price'] = (string) round($res_price, 2);
                                  } else if($total_mins >= 45 && $total_mins <= 50) {
                                        $res_price = $price_category['primary_cost'];
                                        
                                        $resdata['total_price'] = (string) round($res_price, 2);
                                  } else if($total_mins > 50) {    
                                     $remain_mins = $total_mins - 45;
                                     $remain_cost = $remain_mins * $mincost;
                                     $res_price =  $remain_cost + $hrcost;
                                     
                                     $resdata['total_price'] = (string) round($res_price, 2);
                                  } else {
                                       $resdata['total_price'] = 'N/A';
                                  }
                                    
                                } else if($price_category['id'] == 3) {
                                   
                                   if($total_mins < 30 ) {
                                        $res_price = $price_category['primary_cost'];
                                        $resdata['total_price'] = (string) round($res_price, 2);
                                  } else if($total_mins >= 30 && $total_mins <= 35) {
                                        $res_price = $price_category['primary_cost'];
                                        
                                        $resdata['total_price'] = (string) round($res_price, 2);
                                  } else if($total_mins > 35) {    
                                     $remain_mins = $total_mins - 30;
                                     $remain_cost = $remain_mins * $mincost;
                                     $res_price =  $remain_cost + $hrcost;
                                     
                                     $resdata['total_price'] = (string) round($res_price, 2);
                                  } else {
                                       $resdata['total_price'] = 'N/A';
                                  }
                                    
                                } else if($price_category['id'] == 4) {
                                   
                                   if($total_mins < 15 ) {
                                        $res_price = $price_category['primary_cost'];
                                        $resdata['total_price'] = (string) round($res_price, 2);
                                  } else if($total_mins >= 15 && $total_mins <= 20) {
                                        $res_price = $price_category['primary_cost'];
                                        
                                        $resdata['total_price'] = (string) round($res_price, 2);
                                  } else if($total_mins > 20) {    
                                     $remain_mins = $total_mins - 15;
                                     $remain_cost = $remain_mins * $mincost;
                                     $res_price =  $remain_cost + $hrcost;
                                     
                                     $resdata['total_price'] = (string) round($res_price, 2);
                                  } else {
                                       $resdata['total_price'] = 'N/A';
                                  }
                                    
                                } else {
                                   
                                   if($total_mins < 60 ) {
                                        $res_price = $price_category['primary_cost'];
                                        $resdata['total_price'] = (string) round($res_price, 2);
                                  } else if($total_mins >= 60 && $total_mins <= 65) {
                                        $res_price = $price_category['primary_cost'];
                                        
                                        $resdata['total_price'] = (string) round($res_price, 2);
                                  } else if($total_mins > 65) {    
                                     $remain_mins = $total_mins - 60;
                                     $remain_cost = $remain_mins * $mincost;
                                     $res_price =  $remain_cost + $hrcost;
                                     
                                     $resdata['total_price'] = (string) round($res_price, 2);
                                  } else {
                                       $resdata['total_price'] = 'N/A';
                                  }
                                    
                                }
                                
                        } else {
                            
                            $resdata['total_hours_val'] = 'N/A';
                            $resdata['total_mins_val'] = 'N/A';
                            $resdata['total_price'] = 'N/A';
                            
                        }
                    
            $status = array('status' => 1, 'message' => 'success');
            $this->response(['status' => $status, 'details' => $resdata], REST_Controller::HTTP_OK);
            
        
    }

      
    
    
    

}

?>