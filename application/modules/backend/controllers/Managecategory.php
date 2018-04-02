<?php

class Managecategory extends MX_Controller {

    function __construct() {
        parent::__construct();
        // $this->load->library('Ajax_pagination');
		//$this->checklogin();	
        $this->load->model('Buzzadmn_category_model');
    }

    /*
     * Listing of unitofareas
     */

    function index() {
		//echo 'kam';exit;
        $this->load->library('pagination');
        $config = [
            'base_url' => base_url('Buzzadmn/Managecategory/index'),
            'per_page' => 2,
            'total_rows' => $this->Buzzadmn_category_model->categoryNumRows(),
            'full_tag_open' => '<ul class="pagination">',
            'full_tag_close' => '</ul>',
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'first_link' => 'First',
            'last_link' => 'Last',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'prev_tag_open' => '<li>',
            'prev_tag_close' => '</li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a>',
            'cur_tag_close' => '</a></li>',
        ];
		$this->pagination->initialize($config);
        $data['categorylist'] = $this->Buzzadmn_category_model->getCategoryList($config['per_page'], $this->uri->segment(4));
		$this->load->view('Buzzadmn/category_list', $data);
    }

    function addcategory() {
        $this->load->view('Buzzadmn/category_add');
    }

   function checklogin(){
		$user_id 	= $this->session->userdata('admin_user_id');
		$user_name 	= $this->session->userdata('user_name');
		if(empty($user_id)){
			redirect('Buzzadmn/login');	exit;
		}
	}
//

    /*
     * Adding a new unitofarea
     */
    function listing() {

    }

    function add() {


        $data['UOA_Name'] = $this->input->post('UOA_Name');
        $data['UOA_Abbrevation'] = $this->input->post('UOA_Abbrevation');



        $now = date('Y-m-d H:i:s');
        $params = array(
            'UOA_Name' => $this->input->post('UOA_Name'),
            'UOA_Abbrevation' => $this->input->post('UOA_Abbrevation'),
            'CreatedOn' => $now,
            'CreatedBy' => 1,
            'LastUpdatedOn' => $now,
            'LastUpdatedBy' => 1,
            'Status' => '1',
        );



        $unitofarea_id = $this->myspidey_unitofarea_model->add_unitofarea($params);
        $this->session->set_flashdata('msg', "Data has been added sucessfully");
        redirect($this->agent->referrer());
    }

    function editdata($id) {
        // check if the unitofarea exists before trying to edit it
        $data['unitofarea'] = $this->myspidey_unitofarea_model->get_unitofarea($id);


        $this->load->view('myspidey_unitofarea/edit', $data);
    }

    /*
     * Editing a unitofarea
     */

    function edit($id) {

        $data['unitofarea'] = $this->myspidey_unitofarea_model->get_unitofarea($id);

        $now = date('Y-m-d H:i:s');
        if (isset($id)) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('	UOA_Name', 'UOA Name', 'required|max_length[255]');

            $params = array(
                'UOA_Name' => $this->input->post('UOA_Name'),
                'UOA_Abbrevation' => $this->input->post('UOA_Abbrevation'),
                'CreatedBy' => 1,
                'LastUpdatedOn' => $now,
                'LastUpdatedBy' => 1,
            );

            $this->myspidey_unitofarea_model->update_unitofarea($id, $params);
            $this->session->set_flashdata('msg', "Data has been saved");
            redirect($this->agent->referrer());
        }
    }

    /*
     * Deleting unitofarea
     */

    function remove($id) {
        $unitofarea = $this->myspidey_unitofarea_model->get_unitofarea($id);

        // check if the unitofarea exists before trying to delete it
        if (isset($unitofarea['UOA_ID'])) {
            $this->myspidey_unitofarea_model->delete_unitofarea($id);
            $this->session->set_flashdata('msg', "Data has been deleted");
            echo "success";
            exit;
        } else
            show_error('The unitofarea you are trying to delete does not exist.');
    }

    function status($id) {

        $data['unitofarea'] = $this->myspidey_unitofarea_model->get_unitofarea($id);

        if ($data['unitofarea']['Status'] == '0') {
            $params = array('Status' => '1');
            $state = "Active";
        } else {

            $params = array('Status' => '0');
            $state = "Inactive";
        }
        $status_unitofarea = $this->myspidey_unitofarea_model->status_unitofarea($id, $params);

        // check if the unitofarea exists before trying to delete it
        if (isset($status_unitofarea)) {

            $this->session->set_flashdata('msg', "Status has been changed");
        } else
            show_error('The unitofarea you are trying to delete does not exist.');

        echo $state;
    }

}
