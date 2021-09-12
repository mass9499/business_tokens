<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();


		$this->data['page_title'] = 'Dashboard';
		
		$this->load->model('model_products');
		$this->load->model('model_orders');
		$this->load->model('model_users');
		$this->load->model('model_stores');
	//	$this->load->model('model_token');
	}

	public function index()
	{

        $fromtimetoday = date('Y-m-d 00:00:00');
        $totimetoday = date('Y-m-d 23:59:59');

        $this->data['max_occ'] = $this->db->get_where('company')->row_array();
		$this->data['occupancy_data'] = $this->db->get_where('token_table', array('created_at >=' => $fromtimetoday, 'created_at <=' => $totimetoday, 'token_gen_status' => 1, 'invoice_gen_status' => 0))->result_array();
		$this->data['current_price_master'] = $this->db->get_where('price_master', array('active_Status' => 1))->row_array();
		

	//	$this->data['total_tokens'] = $this->model_token->countTotalTokens();
		$this->data['total_paid_orders'] = $this->model_orders->countTotalPaidOrders();
		$this->data['total_users'] = $this->model_users->countTotalUsers();
		$this->data['total_stores'] = $this->model_stores->countTotalStores();

		$user_id = $this->session->userdata('id');
		$user_role = $this->session->userdata('role');
    // 	$is_admin = ($user_id == 1) ? true :false;
        $is_admin = ($user_role == 1) ? true :false;
	
	// token counts
        $counts_token = $this->db->get('token_table')->result_array();
        $this->data['total_products'] = count($counts_token);
        
     //paid token counts  
        $counts_paid_token = $this->db->get_where('token_table', array('invoice_gen_status'=>1))->result_array();
        $this->data['total_paid_orders'] = count($counts_paid_token);
     
     //today token count  
        $counts_token_today = $this->db->get_where('token_table', array('created_at >=' => $fromtimetoday, 'created_at <=' => $totimetoday))->result_array();
        $this->data['total_products_today'] = count($counts_token_today);
       
		$this->data['is_admin'] = $is_admin;
		$this->render_template('dashboard', $this->data);
	}
}