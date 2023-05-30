<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Paper extends MY_Controller {

    public $data = array();

    function __construct() {
        
        parent::__construct();
        $this->load->model('Paper_Model', 'paper', true);
               
       if($this->session->userdata('role_id') == STUDENT){
            $this->data['subjects']  = $this->paper->get_list('subjects',array('status'=>1, 'class_id'=>$this->session->userdata('class_id')), '','', '', 'id', 'ASC'); 
        }        
        
        // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_lesson_plan')){                        
              redirect('dashboard/index');
            }
        }
    }

    
        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "paper List" user interface                 
    *                       
    * @param           : $class_id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($class_id = null ) {

        check_permission(VIEW);
        if(isset($class_id) && !is_numeric($class_id)){
            error($this->lang->line('unexpected_error'));
            redirect('exam/paper/index');
        }
                
        //for super admin        
        $school_id = '';
        $subject_id = '';        
        if($_POST){   
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');           
            $subject_id  = $this->input->post('subject_id');           
        }
        
        if ($this->session->userdata('role_id') != SUPER_ADMIN) {
            $school_id = $this->session->userdata('school_id');    
        }               
        if ($this->session->userdata('role_id') == STUDENT) {
            $class_id = $this->session->userdata('class_id');    
        }               
        
        $school = $this->paper->get_school_by_id($school_id);
        $this->data['papers'] = $this->paper->get_paper_list($school_id, $class_id, $subject_id, @$school->academic_year_id); 
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->paper->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
       
        $this->data['schools'] = $this->schools;
        $this->data['class_id'] = $class_id;
        $this->data['school_id'] = $school_id;       
        $this->data['subject_id'] = $subject_id;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_paper'). ' | ' . SMS);
        $this->layout->view('paper/index', $this->data);
     
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new paper" user interface                 
    *                    and process to store "paper" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        //$school_id = '';
         
        if ($_POST) {
            $this->_prepare_paper_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_paper_data();

                // check is subject is exist in paper table
                $school = $this->paper->get_school_by_id($data['school_id']);
                $exist = $this->paper->get_single('lp_papers', array('class_id' => $data['class_id'], 'subject_id'=>$data['subject_id'], 'academic_year_id'=> $school->academic_year_id));
                if($exist){
                    $this->paper->update('lp_papers', $data, array('id' => $exist->id));
                    $insert_id = $exist->id;
                }else{
                    $insert_id = $this->paper->insert('lp_papers', $data);
                }                
                
                if ($insert_id) {                    
                    // insert paper list in database
                    $this->_save_paper($insert_id);                    
                    create_log('Has been added paper');                     
                    success($this->lang->line('insert_success'));
                    redirect('exam/paper/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('exam/paper/add');
                }
            } else {
                $this->data['post'] = $_POST;                
            }
        }
        
        
        //$school = $this->paper->get_school_by_id($school_id);
        $this->data['papers'] = $this->paper->get_paper_list($school_id, $class_id, $subject_id, @$school->academic_year_id); 
        
        // $this->data['papers'] = $this->paper->get_paper_list();   
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->paper->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['schools'] = $this->schools;
        $this->data['class_id'] = '';
        $this->data['school_id'] = '';       
        $this->data['subject_id'] = '';
        
        $this->data['add'] = TRUE;
        
        $this->layout->title($this->lang->line('add') .' | '. SMS);
        $this->layout->view('paper/index', $this->data);
        
    }

    
    /*****************Function edit* * *********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "paper" user interface                 
    *                    with populate "Exam Liveclass" value 
    *                    and process to update "Exa paper" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

       if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('exam/paper/index');
        }
       
        if ($_POST) {
            $this->_prepare_paper_validation();
            if ($this->form_validation->run() === TRUE) {
                
                $data = $this->_get_posted_paper_data();
                $updated = $this->paper->update('lp_papers', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $this->_save_paper($this->input->post('id'));
                    create_log('Has been updated paper');                    
                    success($this->lang->line('update_success'));
                    redirect('exam/paper/index');
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('exam/paper/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['paper'] = $this->paper->get_single_paper($this->input->post('id'));
            }
        }

        if ($id) {
            $this->data['paper'] = $this->paper->get_single_paper($id);
            if (!$this->data['paper']) {
            redirect('exam/paper/index');
            }
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->paper->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        
        $school_id = $this->data['paper']->school_id;
        $class_id = $this->data['paper']->class_id;
        $subject_id = $this->data['paper']->subject_id;
        $school = $this->paper->get_school_by_id($school_id);
        
        $this->data['papers'] = $this->paper->get_paper_list($school_id, $class_id, $subject_id, $school->academic_year_id);               
        $this->data['paper_detail'] = get_paper_detail_by_paper_id($this->data['paper']->id);
              
        $this->data['schools'] = $this->schools;
        $this->data['class_id'] = $class_id;
        $this->data['school_id'] = $school_id;       
        $this->data['subject_id'] = $subject_id;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('paper/index', $this->data);
    }

   
    /*****************Function get_single_paper**********************************
     * @type            : Function
     * @function name   : get_single_paper
     * @description     : "Load single paper information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_paper(){
        
       $paper_id = $this->input->post('paper_id');
       $this->data['paper'] = $this->paper->get_single_paper($paper_id);   
       $this->data['paper_details'] = get_paper_detail_by_paper_id($paper_id);  
       echo $this->load->view('paper/get-single-paper', $this->data);
    }
    
    
    /*****************Function _prepare_paper_validation**********************************
    * @type            : Function
    * @function name   : _prepare_paper_validation
    * @description     : Process "paper plan" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_paper_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required');       
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    

    
    /*****************Function _get_posted_paper_data**********************************
    * @type            : Function
    * @function name   : _get_posted_paper_data
    * @description     : Prepare "paper Plan" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_paper_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'class_id';
        $items[] = 'subject_id';
        $items[] = 'note';
        
        $data = elements($items, $_POST);

        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
        
        if ($this->input->post('id')) {
            $data['status'] = 1; //  will be from post
        } else {
                        
            $school = $this->paper->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/paper/index');  
            }
            
            $data['academic_year_id'] = $school->academic_year_id;                    
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();           
        }
        
        return $data;
    }
    

    /*****************Function _save_paper**********************************
    * @type            : Function
    * @function name   : _save_paper
    * @description     : delete "Save paper" into database                  
    *                       
    * @param           : $paper_id integer value
    * @return          : null 
    * ********************************************************** */
    private function _save_paper($paper_id){
        
        $school_id = $this->input->post('school_id');
        $school = $this->paper->get_school_by_id($school_id);
        foreach($this->input->post('Ptitle') as $key=>$value){
            
            if($value){
                
                $data = array();
                $data['school_id'] = $school_id;
                $exist = '';               
                $paper_detail_id = @$_POST['paper_detail_id'][$key];

                if($paper_detail_id){
                   $exist = $this->paper->get_single('lp_paper_details', array('paper_id'=>$paper_id, 'id'=>$paper_detail_id));
                }         


                $data['Ptitle'] = $value;               
               
                if ($this->input->post('id') && $exist) {                

                    $data['modified_at'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = logged_in_user_id();                
                    $this->paper->update('lp_paper_details', $data, array('id'=>$exist->id));

                } else {

                    $data['paper_id'] = $paper_id;                                   
                    $data['status'] = 1;
                    $data['academic_year_id'] = $school->academic_year_id;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = logged_in_user_id(); 
                    $data['modified_at'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = logged_in_user_id();
                    $this->paper->insert('lp_paper_details', $data);
                }
            }
        }
    }
    





    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "paper" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
   public function delete($id = null) {

        check_permission(DELETE);

        if (!is_numeric($id)) {
            error($this->lang->line('unexpected_error'));
            redirect('exam/paper/index');
        }

        if ($this->paper->delete('lp_papers', array('id' => $id))) {
            // delete paper list
            $this->paper->delete('lp_paper_details', array('paper_id' => $id));
            success($this->lang->line('delete_success'));
        } else {

            error($this->lang->line('delete_failed'));
        }

        redirect('exam/paper/index');
    }
    
    
    public function remove(){
        
        $paper_detail_id = $this->input->post('paper_detail_id');
        echo $this->paper->delete('lp_paper_details', array('id' => $paper_detail_id));
    }   

    
}