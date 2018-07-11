<?php

class QuestionModel extends CI_Model {

    public function validate($data, $fields) {
        $this->load->library('form_validation');
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($fields);

        //echo "<pre>";print_r($fields);die;
        if ($this->form_validation->run() == FALSE) {
            return Utils::errors($this->form_validation->error_string());
        }
        return true;
    }
    
    public function validDate($value){
        $valid = Utils::validDate($value, 'Y-m-d');
        if(!$valid){
            $this->form_validation->set_message('date', '%s is not valid.');
            return FALSE;
        }else{ 
            return TRUE;            
        }
    }
    
    public function findBy($conditions = []){
        $query = $this->db->get_where($this->table, $conditions)->row();
        if (empty($query)) {
            return false;
        }
        return $query;
    }
    
    function getAllQuestions($limit,$offset,$keyword = null) {        
        $condition = [];
        if(!empty($keyword)){
            $condition[] = sprintf('question_type LIKE "%%%1$s%%" OR question_text LIKE "%%%1$s%%"',$keyword);            
        }
        $conditions = trim(implode(' AND ',$condition),' AND ');
        $total = Utils::countAll('questions', $conditions);
        $this->db->select('*');
        $this->db->from('questions');
        if(!empty($conditions)){
            $this->db->where($conditions);
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $items = $query->result_array();
        //echo $this->db->last_query();
        return [$total,$items];
    }

}