<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************ProjectGrouping.php**********************************
 * @product name    : Uganda School ERP
 * @type            : Class
 * @class name      : Attendance
 * @description     : Manage ProjectGrouping for student who do a project.  
 * @author          :  Denis Mariga Kamara	
 * @url             :        
 * @support         : denismariga50@gmail.com	
 * @copyright       : Denis Mariga Kamara 	
 * ********************************************************** */

class Grouping extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('ProjectGrouping_Model', 'grouping', true);        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Project Grouping" user interface                 
    *                    and Process to manage Student exam Project Grouping   
    * @param           : null
    * @return          : null 
    * ********************************************************** */ 
    public function index() {

        //check_permission(VIEW);

        $school_id = '';
        
        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $subject_id = $this->input->post('subject_id');
            $project_id = $this->input->post('project_id');

            $school = $this->grouping->get_school_by_id($school_id);            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/grouping/index');
            }
            
            
            $this->data['students'] = $this->grouping->get_student_list($school_id, $exam_id, $class_id, $section_id, $subject_id, $project_id,$school->academic_year_id);

                      
            $condition = array(
                'school_id' => $school_id,
                'exam_id' => $exam_id,
                'class_id' => $class_id,
                'academic_year_id' => $school->academic_year_id,
                'subject_id' => $subject_id,
                'project_id' => $project_id
            );
            
            if($section_id){
                $condition['section_id'] = $section_id;
            }

            $data = $condition;
            if (!empty($this->data['students'])) {

                foreach ($this->data['students'] as $obj) {

                    $condition['student_id'] = $obj->student_id;
                    $grouping = $this->grouping->get_single('project_groups', $condition);
                    
                    if (empty($grouping)) {
                        $data['section_id'] = $obj->section_id;
                        $data['student_id'] = $obj->student_id;
                        $data['status'] = 1;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['created_by'] = logged_in_user_id();
                        $this->grouping->insert('project_groups', $data);
                    }
                }
            }

            $this->data['school_id'] = $school_id;
            $this->data['exam_id'] = $exam_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['subject_id'] = $subject_id;
            $this->data['project_id'] = $project_id;
            $this->data['academic_year_id'] = $school->academic_year_id;
            
           $exam = $this->grouping->get_single('exams', array('id'=>$exam_id));
           $class = $this->grouping->get_single('classes', array('id'=>$class_id));
           $subject = $this->grouping->get_single('subjects', array('id'=>$subject_id));            
           $project = $this->grouping->get_single('projects', array('id'=>$project_id));            
           create_log('Has been process project grouping for : '.$subject->name. ', '. $class->name.', '. $project->name);
        }
        
        
        
        $condition = array();
        $condition['status'] = 1; 
        if($school_id){
            $condition['school_id'] = $school_id;
        }else{
            $condition['school_id'] = $this->session->userdata('school_id');
        }
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $school = $this->grouping->get_school_by_id($this->session->userdata('school_id'));
            
            $this->data['classes'] = $this->grouping->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $condition['academic_year_id'] = $school->academic_year_id;
            $this->data['exams'] = $this->grouping->get_list('exams', $condition, '', '', '', 'id', 'ASC');
        }           
       
        $this->layout->title($this->lang->line('project_grouping') . ' | ' . SMS);
        $this->layout->view('grouping/index', $this->data);        
    }



    /*****************Function update_single**********************************
    * @type            : Function
    * @function name   : update_single
    * @description     : Process to update single student exam attendance status               
    *                        
    * @param           : null
    * @return          : null 
    * ********************************************************** */ 
    public function update_single() {

        $status = $this->input->post('status');
        $condition['school_id'] = $this->input->post('school_id');
        $condition['student_id'] = $this->input->post('student_id');
        $condition['exam_id'] = $this->input->post('exam_id');
        $condition['class_id'] = $this->input->post('class_id');
        if($this->input->post('section_id')){
            $condition['section_id'] = $this->input->post('section_id');
        }
        $condition['subject_id'] = $this->input->post('subject_id');
        $condition['project_id'] = $this->input->post('project_id');
        
        $school = $this->grouping->get_school_by_id($condition['school_id']);  
        if(!$school->academic_year_id){
           echo 'ay';
           die();
        }
        
        $condition['academic_year_id'] = $school->academic_year_id;

        $data['is_attend'] = $status ? 1 : 0;
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();

        if ($this->grouping->update('project_groups', $data, $condition)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
    }

    
    /*****************Function update_all**********************************
    * @type            : Function
    * @function name   : update_all
    * @description     : Process to update all student exam attendance status                 
    *                        
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function update_all() {

        $status = $this->input->post('status');

        $condition['school_id'] = $this->input->post('school_id');
        $condition['exam_id'] = $this->input->post('exam_id');
        $condition['class_id'] = $this->input->post('class_id');
        if($this->input->post('section_id')){
            $condition['section_id'] = $this->input->post('section_id');
        }
        $condition['subject_id'] = $this->input->post('subject_id');
        $condition['project_id'] = $this->input->post('project_id');
        
        $school = $this->grouping->get_school_by_id($condition['school_id']); 
        if(!$school->academic_year_id){
           echo 'ay';
           die();
        }
        
        $condition['academic_year_id'] = $school->academic_year_id;

        $data['is_attend'] = $status ? 1 : 0;
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();

        if ($this->grouping->update('project_groups', $data, $condition)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
    }

}
