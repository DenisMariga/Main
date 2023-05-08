<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Mark.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Mark
 * @description     : Manage exam mark for student whose are attend in the exam.  
 * @author          :  Denis Mariga Kamara	
 * @url             :        
 * @support         : denismariga50@gmail.com	
 * @copyright       : Denis Mariga Kamara 	
 * ********************************************************** */

class MarkAoi extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('markaoi_Model', 'aoi_mark', true);   
        
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
    * @description     : Load "Exam Mark List" user interface                 
    *                    with filter option  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $subject_id = $this->input->post('subject_id');
            $lesson_detail_id = $this->input->post('lesson_detail_id');
            $topic_details_id = $this->input->post('topic_details_id');
            $activity_id = $this->input->post('activity_id');

            $school = $this->aoi_mark->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/markaoi/index');
            }
            
            $this->data['students'] = $this->aoi_mark->get_student_list($school_id, $exam_id, $class_id, $section_id, $subject_id,$school->academic_year_id);//$lesson_detail_id,$topic_details_id, $aoi_id,

            $condition = array(
                'school_id' => $school_id,
                'exam_id' => $exam_id,
                'class_id' => $class_id,
                'academic_year_id' => $school->academic_year_id,
                'subject_id' => $subject_id,
                'lesson_detail_id'=> $lesson_detail_id,
                'topic_details_id'=> $topic_details_id,
                'activity_id'=> $activity_id
            );
            
            if($section_id){
                $condition['section_id'] = $section_id;
            }

            $data = $condition;
            
            if (!empty($this->data['students'])) {

                foreach ($this->data['students'] as $obj) {

                    $condition['student_id'] = $obj->student_id;
                    $aoi_mark = $this->aoi_mark->get_single('aoi_marks', $condition);

                    if (empty($aoi_mark)) {
                        
                        $data['section_id'] = $obj->section_id;
                        $data['student_id'] = $obj->student_id;
                        $data['status'] = 1;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['created_by'] = logged_in_user_id();
                        $this->aoi_mark->insert('aoi_marks', $data);
                    }
                }
            }

            // $this->data['grades'] = $this->mark_aoi->get_list('grades', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
            
            $this->data['school_id'] = $school_id;
            $this->data['exam_id'] = $exam_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['subject_id'] = $subject_id;
            $this->data['lesson_detail_id'] = $lesson_detail_id;
            $this->data['topic_details_id'] = $topic_details_id;
            $this->data['activity_id'] = $activity_id;
            $this->data['academic_year_id'] = $school->academic_year_id;
                        
            $class = $this->aoi_mark->get_single('classes', array('id'=>$class_id));
            create_log('Has been process aoi exam mark for class: '. $class->name);
            
        }
        
        
        $condition = array();
        $condition['status'] = 1;  
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school = $this->aoi_mark->get_school_by_id($this->session->userdata('school_id'));
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->aoi_mark->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $condition['academic_year_id'] = $school->academic_year_id;
            $this->data['exams'] = $this->aoi_mark->get_list('exams', $condition, '', '', '', 'id', 'ASC');
        }  

        $this->layout->title($this->lang->line('manage_aoi') . ' | ' . SMS);
        $this->layout->view('markaoi/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Process to store "Exam Mark" into database                
    *                     
    * @param           : null
    * @return          : null 
     * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $subject_id = $this->input->post('subject_id');
            $lesson_detail_id = $this->input->post('lesson_detail_id');
            $topic_details_id = $this->input->post('topic_details_id');
            $activity_id = $this->input->post('activity_id');

            $school = $this->aoi_mark->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/markaoi/index');
            }
            
            $condition = array(
                'school_id' => $school_id,
                'exam_id' => $exam_id,
                'class_id' => $class_id,
                'academic_year_id' => $school->academic_year_id,
                'subject_id' => $subject_id,
                'lesson_detail_id' => $lesson_detail_id,
                'topic_details_id' => $topic_details_id,
                'activity_id' => $activity_id
            );
            
            if($section_id){
                $condition['section_id'] = $section_id;
            }            

            $data = $condition;

            if (!empty($_POST['students'])) {

                foreach ($_POST['students'] as $key => $value) {

                    $condition['student_id'] = $value;
                    $data['activity_mark'] = $_POST['activity_mark'][$value];
                    $data['activity_obtain'] = $_POST['activity_obtain'][$value];
                    
                    $data['activity_score'] = $_POST['activity_score'][$value];
                    $data['activity_descriptor'] = $_POST['activity_descriptor'][$value];
                    
                    $data['activity_skill'] = $_POST['activity_skill'][$value];
                    $data['activity_strengths'] = $_POST['activity_strengths'][$value];
                    
                    $data['activity_out_of_ten'] = $_POST['activity_out_of_ten'][$value];
                    
            
                    $data['status'] = 1;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = logged_in_user_id();
                    $this->aoi_mark->update('aoi_marks', $data, $condition);
                }
            }
            
            $class = $this->aoi_mark->get_single('classes', array('id'=>$class_id));
            create_log('Has been process exam mark and save for class: '. $class->name);
            
            success($this->lang->line('insert_success'));
            redirect('exam/markaoi/index');
        }

        $this->layout->title($this->lang->line('add')  . ' | ' . SMS);
        $this->layout->view('markaoi/index', $this->data);
    }

}
