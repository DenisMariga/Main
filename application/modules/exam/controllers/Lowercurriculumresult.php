<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lowercurriculumresult extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Lowercurriculumresult_Model', 'lowercurriculumresult', true); // Load ActivityOutofTen model
     // need to check school subscription status
     if($this->session->userdata('role_id') != SUPER_ADMIN){                 
        if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_exam_mark')){                        
          redirect('dashboard/index');
        }
    }
}

    public function index() {

       // Check permission
       // check_permission(VIEW);

       if ($_POST) {
        // Retrieve form data
        if ($this->session->userdata('role_id') == STUDENT) {
            $student = get_user_by_role($this->session->userdata('role_id'), $this->session->userdata('id'));
            $school_id = $student->school_id;
            $class_id = $student->class_id;
            $section_id = $student->section_id;
            $student_id = $student->id;
        } else {
            $school_id = $this->input->post('school_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $student_id = $this->input->post('student_id');
            $std = $this->lowercurriculumresult->get_single('students', array('id'=>$student_id));
            $student = get_user_by_role(STUDENT, $std->user_id);
        }
        
        $academic_year_id = $this->input->post('academic_year_id');
        $exam_id = $this->input->post('exam_id');
        $this->data['school'] = $this->lowercurriculumresult->get_school_by_id($school_id);
        $this->data['school_id'] = $school_id;
        $this->data['academic_year_id'] = $academic_year_id;
        $this->data['exam_id'] = $exam_id;
        $this->data['student'] = $student;
        $this->data['class_id'] = $class_id;
        $this->data['section_id'] = $section_id;
        $this->data['student_id'] = $student_id;
        
        $this->data['subjects'] = $this->lowercurriculumresult->get_subject_list($school_id, $class_id, $section_id, $student_id, $academic_year_id, $exam_id);          
    }
    
    // Retrieve academic years, classes, and activity_out_of_ten
    $condition = array();
    $condition['status'] = 1;  
    
    // Check user role
    if ($this->session->userdata('role_id') != SUPER_ADMIN) {
        $condition['school_id'] = $this->session->userdata('school_id');
        $this->data['classes'] = $this->lowercurriculumresulttivecard->get_list('classes',$condition, '', '', '', 'id', 'ASC');
        $this->data['academic_years'] = $this->F_Average->get_list('academic_years',$condition, '', '', '', 'id', 'ASC');
        $this->data['exams'] = $this->lowercurriculumresulttivecard->get_list('exams',$condition, '', '', '', 'id', 'ASC');
    }
    
    $this->layout->title($this->lang->line('manage_lower_curriculum_result') . ' | ' . SMS);
    $this->layout->view('lower_curriculum_result/index', $this->data);
    }    
        public function all() {

            //check_permission(VIEW);
    
            if ($_POST) {
    
                    
                $school_id = $this->input->post('school_id');
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                
                if($this->session->userdata('role_id') == STUDENT ){
                    $class_id = $this->session->userdata('class_id');
                    $section_id = $this->session->userdata('section_id');
                }
                
                $school = $this->lowercurriculumresulttivecard->get_school_by_id($school_id);
                $academic_year_id = $this->input->post('academic_year_id');
                
                $students = $this->lowercurriculumresulttivecard->get_student_list($school_id, $class_id, $section_id, $academic_year_id);
               
                $this->data['school'] = $school;
                $this->data['school_id'] = $school_id;
                $this->data['academic_year_id'] = $academic_year_id;
                $this->data['students'] = $students;
                $this->data['class_id'] = $class_id;
                $this->data['section_id'] = $section_id;
               
            }
            
            
            $condition = array();
            $condition['status'] = 1;        
            if($this->session->userdata('role_id') != SUPER_ADMIN){ 
                
                $condition['school_id'] = $this->session->userdata('school_id');            
                $this->data['classes'] = $this->lowercurriculumresulttivecard->get_list('classes', $condition, '','', '', 'id', 'ASC');
                $this->data['academic_years'] = $this->lowercurriculumresulttivecard->get_list('academic_years', $condition, '', '', '', 'id', 'ASC');
            }
    
            $this->layout->title($this->lang->line('manage_lower_curriculum_result') . ' | ' . SMS);
            $this->layout->view('lower_curriculum_result/all', $this->data);
            
        }
    
        
    }   
   
