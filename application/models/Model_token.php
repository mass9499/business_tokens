<?php 

class Model_products extends CI_Model
{
	public function countTotalToken()
	{
		$sql = "SELECT * FROM token_table";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	
	
	
	
	
	
	
}