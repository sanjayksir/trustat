<?php

class CustomerModel extends CI_Model {

    public $table = 'backend_user';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function validate($data,$fields){        
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
    
    public function findBy($conditions=[]){
        $query = $this->db->get_where($this->table,$conditions)->row();
        if(empty($query )){
            return false;
        }
        return $query;
    }
    public function authIdentify($data = []) {
        if(empty($data)){
            return false;
        }
         $conditions = ['is_verified !='=>'0','status'=>'1'];
        if (filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
            $type = 'email';
            $conditions['email_Id'] = $data['username'];
        }else{
            $type = 'username';
            $conditions['user_name'] = $data['username'];
        }
        $user = $this->findBy($conditions);
        //echo $this->db->last_query();die;
        if (empty($user)) {
            return false;
        }
        if(($type == 'username') && (!in_array($user->is_verified,[1,2]))){
            return 'username';
        }
        if(($type == 'email') && (!in_array($user->is_verified,[1,3]))){
            return 'email';
        }
        if (md5($data['password']) != $user->password) {
            return false;
        }
        $user->token = Utils::randomString();
        unset($user->password);
        $log = [
            'customer_id' => $user->user_id,
            'token' => $user->token,
            'plain_token' => $user->token,
            'device_id' => $data['device_id'],
            'login_status' => 1,
            'last_login' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
        ];
        $this->load->model('UserLogModel');
        $this->db->delete($this->UserLogModel->table, array('customer_id' => $user->user_id));
        if ($this->db->insert($this->UserLogModel->table, $log)) {
            return $user;
        } else {
            return false;
        }
    }
    
    /**
     * verifyToken method to check authentication by token
     * @param string $token token of user log table
     * @return array user details
     */
    public function verifyToken($token = null,$plant=null){
        if($token == null){
            return false;
        }
        $this->load->model('UserLogModel');
        $this->db->select($this->table.'.*');
        $this->db->from($this->table);
        $this->db->join($this->UserLogModel->table,$this->UserLogModel->table.'.customer_id='.$this->table.'.user_id','left');
        $this->db->where($this->UserLogModel->table.'.token',$token);
        $users = $this->db->get()->row_array();
		
        if(!empty($users)){
			
            $userPlant = $this->db->get_where('assign_locations_to_users',['assigned_by'=>getParentIdFromUserIdTAPP($users['user_id']), /*'user_id'=>$users['user_id'], */ 'assigned_by'=>$plant])->row_array();
            if(empty($userPlant['location_id'])){
                return 'plant';
            }
            $users['location_id'] = $plant;
        }
        //echo $this->db->last_query();die;
        return $users;
    }

}
