<?php

class Buzzadmn_category_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getCategoryList($limit, $offset) {
        $this->db->select("*");
        $this->db->from("categories");
        $this->db->where("categorytype='spidypick'");
        $this->db->limit($limit, $offset);
        $this->db->order_by("category_Id", " desc");
        return $this->db->get()->result_array();
    }

    public function categoryNumRows() {
        $q = $this->db
                ->select('category_Id')
                ->from('categories')
				->where("categorytype='spidypick'")
                ->get();
        return $q->num_rows();
    }

    /*
     * Get unitofarea by ID
     */

    function get_unitofarea($id) {

        $this->db->select('*');
        $this->db->from('cs_unitofarea');
        $this->db->where('UOA_ID', $id);

        return $this->db->get()->row_array();
    }

    /*
     * Get all unitofarea
     */

    function get_all_unitofarea() {

        $this->db->select("*");
        $this->db->from("cs_unitofarea");
        $this->db->order_by("UOA_ID", " desc");
        return $this->db->get()->result_array();
    }

    /*
     * function to add new unitofarea
     */

    function add_unitofarea($params) {
        $this->db->insert('cs_unitofarea', $params);
        return $this->db->insert_id();
    }

    /*
     * function to update
     */

    function update_unitofarea($id, $params) {
        $this->db->where('UOA_ID', $id);
        $response = $this->db->update('cs_unitofarea', $params);

        if ($response) {
            return "utility updated successfully";
        } else {
            return "Error occuring while updating utility";
        }
    }

    /*
     * function to delete
     */

    function delete_unitofarea($id) {
        $response = $this->db->delete('cs_unitofarea', array('UOA_ID' => $id));
        if ($response) {
            return "utility deleted successfully";
        } else {
            return "Error occuring while deleting utility";
        }
    }

    /*
     * function to change status
     */

    function status_unitofarea($id, $params) {

        $this->db->where('UOA_ID', $id);
        $response = $this->db->update('cs_unitofarea', $params);

        if ($response) {
            return "utility deleted successfully";
        } else {
            return "Error occuring while deleting utility";
        }
    }

}
