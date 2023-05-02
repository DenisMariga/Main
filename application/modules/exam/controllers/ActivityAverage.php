<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Meritlist.php**********************************
 * @product name    : Uganda School ERP
 * @type            : Class
 * @class name      : Meritlist
 * @description     : Manage exam merit list.  
 * @author          :  Denis Mariga Kamara	
 * @url             :        
 * @support         : denismariga50@gmail.com	
 * @copyright       : Denis Mariga Kamara 	
 * ********************************************************** */

class ActivityAverage extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('ActivityAverage_Model', 'A_Average', true); 
        
        // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_exam_mark')){                        
              redirect('dashboard/index');
            }
        }
    }

    
        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Exam final result sheet" user interface                 
    *                    with class/section wise filtering option    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        //check_permission(VIEW);

        if ($_POST) {
           
            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $subject_id = $this->input->post('subject_id');
           
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['class_id'] = $class_id;         
            $this->data['section_id'] = $section_id; 
            $this->data['subject_id'] = $subject_id; 
            
            $school = $this->A_Average->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/activityaverage/index');
            }
            

            $this->data['class'] = $this->db->get_where('classes', array('id'=>$class_id))->row()->name;
            if($section_id){
                $this->data['section'] = $this->db->get_where('sections', array('id'=>$section_id))->row()->name;
            }
            $this->data['subject'] = $this->db->get_where('subjects', array('id'=>$subject_id))->row()->name;
            
            $this->data['academic_year'] = $this->db->get_where('academic_years', array('id'=>$academic_year_id))->row()->session_year;
            $this->data['activityaverage'] = $this->A_Average->get_average_list($school_id, $academic_year_id, $class_id, $section_id,$subject_id);
            $this->data['school'] = $this->A_Average->get_school_by_id($school_id);
        }
        
        
        $condition = array();
        $condition['status'] = 1;  
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            
            $school = $this->A_Average->get_school_by_id($this->session->userdata('school_id'));
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['academic_years'] = $this->A_Average->get_list('academic_years',$condition, '', '', '', 'id', 'ASC');
            
            $this->data['classes'] = $this->A_Average->get_list('classes', $condition, '','', '', 'id', 'ASC');
            // $condition['academic_year_id'] = $A_Average->academic_year_id;
            $this->data['exams'] = $this->A_Average->get_list('exams', $condition, '', '', '', 'id', 'ASC');
        }

        $this->layout->title($this->lang->line('manage_averages_list') . ' | ' . SMS);
        $this->layout->view('activity_average/index', $this->data);
        
    }
}