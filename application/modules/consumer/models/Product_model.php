<?php
 class Product_model extends CI_Model {
     function __construct() {
         parent::__construct();
     }
	 
     

     public function getOptionList($id) {
         $q = $this->db
                 ->select('*')
                  ->from('attribute_options')
 				->where("product_id", $id)
                 ->get();
         return $q->result_array();
     }
	 
	  
     function get_property_values($id) {
		$this->db->select("*");
		$this->db->from("attribute_options");
		$this->db->where("product_id", $id);
        return $this->db->get()->result_array();
    }

    function update_attribute_val($params) {
	
		//echo '<pre>';print_r($params);exit;

        //$this->db->where('product_id', $params['id']);
		$delete = "delete from attribute_options where product_id='".$params['id']."'";
		$this->db->query($delete);
        $response = $this->db->insert('attribute_options',array('product_id'=> $params['id'],'params'=>json_encode($params['fields'])));
		//echo $this->db->last_query();exit;
         if ($response) {
            $this->session->set_flashdata('success', 'Attribute Updated Successfully!');
          } else {
            $this->session->set_flashdata('success', 'Attribute Not Updated!');
         }
		 redirect('product/set_attributes');

    }

 
    function delete_unitofarea($id) {

        $response = $this->db->delete('cs_unitofarea', array('UOA_ID' => $id));

        if ($response) {

            return "Property deleted successfully";

        } else {

            return "Error occuring while deleting Property";

        }

    }

    function status_unitofarea($id, $params) {
         $this->db->where('UOA_ID', $id);
         $response = $this->db->update('cs_unitofarea', $params);
         if ($response) {
             return "utility deleted successfully";
         } else {
             return "Error occuring while deleting utility";
         }
     }
	 
	 
	 function IsExistsProduct($name,$id='') {
		$rows = 0;
		$result = 'true';
		$this->db->select("id");
		$this->db->from("products");
		$this->db->where("product_name", $name);
		if(!empty($id)){
			$this->db->where("id", $id);
		}
		$q = $this->db->get();
        $rows = $q->num_rows();
		if($rows>0){
			$result = 'false';
		} return $result;
    }
	
	function getAttributeList() {
		$this->db->select("*");
		$this->db->from("attribute_name");
		$this->db->order_by("name", " desc");
        return $this->db->get()->result_array();
    }
	
 	function get_all_attrs() {
		$this->db->select('At.name, Ao.*');
		$this->db->from('attribute_name At');
		$this->db->join('attribute_options Ao',' Ao.product_id = At.product_id','Left');
		$query=$this->db->get();
        return $query->result_array();
    }
	
	function save_product(){
		$user_id 	= $this->session->userdata('admin_user_id');
		$industry 	= $this->input->post('industry');
		$industry2 	= $this->input->post('industry_2');
		$industry3 	= $this->input->post('industry_3');
		
		$product_name = $this->input->post('product_name');
		$product_sku  = $this->input->post('product_sku');
		$product_attr = json_encode($this->input->post('product_attr'));
		
		$id			  = $this->input->post('id');
		
		 if(!empty($id)){
		 	 $updateArr=array(
					 
					"attribute_list"=>$product_attr,
					"industry_data"=>$industry.','. $industry2.','.$industry3
 				);
				//echo '<pre>';print_r($insertData);exit;
				$this->db->where('id', $id);
				if($this->db->update("products", $updateArr)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Product Updated Successfully!');
					return true;
	
				}return false; 
		 }else{
 			 $insertData=array(
					"product_name"=>$product_name,
					"attribute_list"=>$product_attr,
					"industry_data"=>$industry.','. $industry2.','.$industry3,
					"product_sku"=>$product_sku,
					"created_by"=>$user_id,
					"status"=>1
				);//echo '<pre>';print_r($insertData);exit;
				if($this->db->insert("products", $insertData)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Product Added Successfully!');
					return true;
				}return false; 
		}
	}
	
	function product_listing() {
		$user_id 	= $this->session->userdata('admin_user_id');
		$this->db->select("*");
		$this->db->from("products");
		$this->db->where('created_by', $user_id);
		$this->db->order_by("created_date", " desc");
        return $this->db->get()->result_array();
    }
	
	  
     function fetch_product_detail($id) {
		$this->db->select("*");
		$this->db->from("products");
		$this->db->where("id", $id);
        return $this->db->get()->result_array();
    }

}

