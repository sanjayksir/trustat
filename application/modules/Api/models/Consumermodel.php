<?php

class ConsumerModel extends CI_Model {

    public $table = 'consumers';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function dob_check($dob){        
        $vdob = Utils::validDate($dob, 'Y-m-d');
        if(!$vdob){
            $this->form_validation->set_message('dob_check', '%s is not valid.');
            return FALSE;
        }else{ 
            $now = new DateTime('now');
            $dob = DateTime::createFromFormat('Y-m-d',$dob);            
            $age = $now->diff($dob)->format("%Y");
            if($age <= 13){ 
                $this->form_validation->set_message('dob_check', '%s must be 13 years old.');
                return FALSE;
            }else{
                return TRUE;
            }
            
        }
    }  
    
    
	
    public function sendFCM($mess,$id) {
$url = 'https://fcm.googleapis.com/fcm/send';

$fields = array (
        'to' => $id,
         
         'notification' => array('title' => 'TRUSTAT notification', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
				  'data' => array('title' => 'TRUSTAT notification', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
       
);
$fields = json_encode ( $fields );

$headers = array (
        'Authorization: key=' . "AAAA4LpXTK8:APA91bHs48XoX1_-4CdsBVyAAVceqQFavfo6Hz3K1U5Phmz2OgYsX7Pr_bNuE8x_PGJBcWs08WHx0JTGh-6goN7ozfl3yB8z9bYe_2ayk0Nmlp9uYOknIKDwq9czlj10rRGQ1bDZ9Nlp",
        'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

$result = curl_exec ( $ch );
//curl_close ( $ch );
return $result;
}


    public function signupValidate($data){
        $validate = [
            ['field' =>'user_name','label'=>'User Name','rules' => 'required|min_length[2]' ],
            ['field' =>'email','label'=>'Email','rules' => 'trim|required|valid_email|is_unique[consumers.email]' ],
            ['field' =>'mobile_no','label'=>'Mobile No','rules' => 'trim|required|integer|exact_length[10]|is_unique[consumers.mobile_no]' ],
            ['field' =>'dob','label'=>'Date of birth','rules' => [['dob_check',[$this,'dob_check']]] ],
            ['field' =>'gender','label'=>'Gender','rules' => 'trim|required|in_list[male,female]' ],
            ['field' =>'terms_conditions','label'=>'Terms and Conditions','rules' => 'trim|required' ],
        ];        
        $this->load->library('form_validation');        
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($validate);
        if ($this->form_validation->run() == FALSE) { 
            return Utils::errors($this->form_validation->error_string());
        }
        return true;
    }
    
    
	
	public function signupValidateNew($data){
        $validate = [
            ['field' =>'user_name','label'=>'User Name','rules' => 'min_length[8]' ],
           // ['field' =>'email','label'=>'Email','rules' => 'trim|valid_email' ],
            ['field' =>'mobile_no','label'=>'Mobile No','rules' => 'trim|required|integer|exact_length[10]' ],
            //['field' =>'dob','label'=>'Date of birth','rules' => [['dob_check',[$this,'dob_check']]] ],
            //['field' =>'gender','label'=>'Gender','rules' => 'trim|in_list[male,female,other,noinfo]' ],
            ['field' =>'terms_conditions','label'=>'Terms and Conditions','rules' => 'trim' ],
        ];        
        $this->load->library('form_validation');        
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($validate);
        if ($this->form_validation->run() == FALSE) { 
            return Utils::errors($this->form_validation->error_string());
        }
        return true;
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
        $this->load->model('UserLogModel');
         $conditions = ['is_verified !='=>0];
        if (filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
            $type = 'email';
            $conditions['email'] = $data['username'];
        }else{
            $type = 'mobile';
            $conditions['mobile_no'] = $data['username'];
        }
        $user = $this->findBy($conditions);
        //echo $this->db->last_query();die;
        if (empty($user)) {
            return false;
        }
        if(($type == 'mobile') && (!in_array($user->is_verified,[1,2]))){
            return 'mobile';
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
            'consumer_id' => $user->id,
            'token' => $user->token,
            'plain_token' => $user->token,
            'device_id' => $data['device_id'],
            'login_status' => 1,
            'last_login' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
        ];
        $this->db->delete($this->UserLogModel->table, array('consumer_id' => $user->id));
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
    public function verifyToken($token = null){
        if($token == null){
            return false;
        }
        $this->load->model('UserLogModel');
        $this->db->select($this->table.'.*');
        $this->db->from($this->table);
        $this->db->join($this->UserLogModel->table,$this->UserLogModel->table.'.consumer_id='.$this->table.'.id','left');
        $this->db->where($this->UserLogModel->table.'.token',$token);
        $users = $this->db->get()->row_array();
        return $users;
    }
    
    /**
     * loylty method to retrieve thelist of loylty for various transaction type
     */
    public function loylty(){
        $items = [];
        $query = $this->db->select('*')->from('loylties')->order_by('created_date', 'desc')->get();
        if($query->num_rows() <= 0){
            return false;
        }
        return $query->result_array();
    }
	
	
	public function ishowzztMember($phone_numberr) {
		
		 $query = $this->db->get_where('consumers', array('mobile_no' => $phone_numberr)); 

                if ($query->num_rows() == 0 )
                {
                     return FALSE;
                }
                else
                {
                      return TRUE;
                }          
    }
	
	/*
	public function isRefrenceReceived($mobile_no) {
		
		 $query = $this->db->get_where('consumer_referral_table', array('referred_mobile_no' => $mobile_no,'referral_consumed' => 0)); 

                if ($query->num_rows() == 0 )
                {
                     return FALSE;
                }
                else
                {
                      return TRUE;
                }          
    }
	*/
	public function findRefrenceReceived($mobile_no){
        if($mobile_no == null){
            return false;
        }
        
   $query = $this->db->select('referral_reference_id,media_type,product_id,referred_mobile_no,referral_consumed,referral_link_clicked_datetime,referral_media_apd')
                ->from('consumer_referral_table')               
                ->where(array('referred_mobile_no' => $mobile_no,'referral_consumed' => 0,'referral_media_apd' => 0))
				->limit(1)
				->order_by('referral_link_clicked_datetime', 'DESC')				
                ->get()
                ->result();
        if(empty($query)){
            return false;
        }
        //echo "<pre>";print_r($query);die;
        $items = [];
        foreach($query as $row){
            $item = [
				'referral_reference_id' => $row->referral_reference_id,
				'media_type' => $row->media_type,
				'product_id' => $row->product_id,	
				//'referral_link_clicked_datetime' => $row->referral_link_clicked_datetime,
        'media_url' => "http://".$_SERVER['SERVER_NAME']."/uploads/" . getMediaURLByProductIdAndMediaType($row->product_id, 'product_push_ad_video'),
				//'referral_consumed' => $row->referral_consumed,
            ];
                       
            $items[] = $item;
        }
        return $items;
    }	
	
		public function isFeedbackAnsDueLA($ConsumerID) {
		
		 $query = $this->db->get_where('push_advertisements', array('consumer_id' => $ConsumerID,'ad_feedback_response' => "No",'ad_active' => 1)); 

                if ($query->num_rows() == 0 )
                {
                     return FALSE;
                }
                else
                {
                      return TRUE;
                }          
    }
	
	public function findConsumerRelatives($userid){
        if($userid == null){
            return false;
        }
        
   $query = $this->db->select('relation_id,consumer_id,member_name,relation,phone_number,howzzt_member')
                ->from('consumer_family_details')               
                ->where_in('consumer_id', $userid)
                ->get()
                ->result();
        if(empty($query)){
            return false;
        }
        //echo "<pre>";print_r($query);die;
        $items = [];
        foreach($query as $row){
            $item = [
				'relative_member_id' => $row->relation_id,
				'consumer_id' => $row->consumer_id,
                'member_name' => $row->member_name,
                'relation' => $row->relation,
                'phone_number' => $row->phone_number,
                'howzzt_member' => $row->howzzt_member,
            ];
                       
            $items[] = $item;
        }
        return $items;
    }	

	
	
	public function findConsumerKids($userid){
        if($userid == null){
            return false;
        }
        
   $query = $this->db->select('*')
                ->from('consumer_kid_details')               
                ->where_in('consumer_id', $userid)
                ->get()
                ->result();
        if(empty($query)){
            return false;
        }
        //echo "<pre>";print_r($query);die;
        $items = [];
        foreach($query as $row){
            $item = [
				'kid_id' => $row->kid_id,
				'consumer_id' => $row->consumer_id,
				'kid_name' => $row->kid_name,
                'kid_gender' => $row->kid_gender,
                'kid_phone_number' => $row->kid_phone_number,
                'kid_dob' => $row->kid_dob,
                'kid_height' => $row->kid_height,
				'kid_weight' => $row->kid_weight,
				'kid_hobbies' => $row->kid_hobbies,
				'kid_sports_like' => $row->kid_sports_like,
				'kid_entertainment_like' => $row->kid_entertainment_like,
				'create_date' => $row->create_date,
				'modified_date' => $row->modified_date,
				'ip' => $row->ip,
				'status' => $row->status,
            ];
                       
            $items[] = $item;
        }
        return $items;
    }
	
		public function findConsumerProfileMasterData($userid){
        if($userid == null){
            return false;
        }        
		$query = $this->db->select('*')
                ->from('consumer_profile_master')               
               // ->where_in('consumer_id', $userid)
                ->get()
                ->result();
        if(empty($query)){
            return false;
        }
        //echo "<pre>";print_r($query);die;
        $items = [];
        foreach($query as $row){
            $item = [
				'cpm_type_name' => $row->cpm_type_name,
				'cpm_type_slug' => $row->cpm_type_slug,
				'cpm_name' => $row->cpm_name,
				'cpm_slug' => $row->cpm_slug,
				'profile_bucket' => $row->profile_bucket,
            ];
                       
            $items[] = $item;
        }
        return $items;
    }
	
}
