<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class markaoi_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_student_list($school_id = null, $exam_id = null, $class_id = null, $section_id = null, $subject_id = null,$academic_year_id = null){
        
        $this->db->select('S.*, E.roll_no, E.class_id, E.section_id, C.name AS class_name, S.id AS student_id, S.name AS student_name, S.photo,  S.phone');
        // $this->db->from('exam_schedules AS ES');        
        $this->db->from('enrollments AS E');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        
        $this->db->where('S.school_id', $school_id);
        $this->db->where('E.academic_year_id', $academic_year_id);       
        // $this->db->where('ES.exam_id', $exam_id);
        $this->db->where('E.class_id', $class_id);
        
        if($section_id){
           $this->db->where('E.section_id', $section_id);
        }
        // $this->db->where('ES.subject_id', $subject_id);
        $this->db->where('S.status_type', 'regular');
        $this->db->order_by('E.roll_no', 'ASC');
       
        return $this->db->get()->result();        
    }

    public function get_student_list_by_class($school_id = null, $exam_id = null, $class_id = null, $receiver_id = null, $academic_year_id = null){
        
        $this->db->select('DISTINCT(S.id),C.name AS class_name, S.id AS student_id, EX.title AS exam_name, S.name AS student_name, S.phone, S.guardian_id');
        $this->db->from('students AS S');        
        $this->db->join('exam_attendances AS EA', 'EA.student_id = S.id', 'left');
        $this->db->join('classes AS C', 'C.id = EA.class_id', 'left');
        $this->db->join('exams AS EX', 'EX.id = EA.exam_id', 'left');
        
        $this->db->where('EA.academic_year_id', $academic_year_id);       
        $this->db->where('EA.school_id', $school_id);
        $this->db->where('EA.class_id', $class_id);
        $this->db->where('EA.exam_id', $exam_id);
        $this->db->where('EA.is_attend', 1);
        $this->db->where('S.status_type', 'regular');
        if($receiver_id > 0){  
            $this->db->where('S.user_id', $receiver_id);                      
        }
       
        return $this->db->get()->result();        
    }
    
    public function get_receiver($school_id, $role_id, $student_id, $guardian_id){
        
        if($role_id == STUDENT){
            $this->db->select('U.id, S.email, U.role_id,  S.name, S.phone');
            $this->db->from('users AS U'); 
            $this->db->join('students AS S', 'S.user_id = U.id', 'left');
            $this->db->where('S.id', $student_id);
        }else{
            $this->db->select('U.id, G.email, U.role_id, G.name, G.phone');
            $this->db->from('users AS U'); 
            $this->db->join('guardians AS G', 'G.user_id = U.id', 'left');
            $this->db->where('G.id', $guardian_id);
        }
        
        return $this->db->get()->row();
    }
    
    
    public function get_mark_emails($school_id = null){
        
        $this->db->select('ME.*, S.school_name, R.name AS receiver_type, AY.session_year, C.name AS class_name, EX.title AS exam');
        $this->db->from('mark_emails AS ME');        
        $this->db->join('classes AS C', 'C.id = ME.class_id', 'left');
        $this->db->join('exams AS EX', 'EX.id = ME.exam_id', 'left');
        $this->db->join('roles AS R', 'R.id = ME.role_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = ME.academic_year_id', 'left');
        $this->db->join('schools AS S', 'S.id = ME.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('ME.school_id', $this->session->userdata('school_id'));
        }
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('ME.school_id', $school_id);
        }
        $this->db->where('S.status', 1);
        $this->db->order_by('ME.id', 'DESC');
        
        return $this->db->get()->result(); 
    }
    
    public function get_single_email($id){
        
        $this->db->select('ME.*, S.school_name, R.name AS receiver_type, AY.session_year, C.name AS class_name, EX.title AS exam');
        $this->db->from('mark_emails AS ME');        
        $this->db->join('classes AS C', 'C.id = ME.class_id', 'left');
        $this->db->join('exams AS EX', 'EX.id = ME.exam_id', 'left');
        $this->db->join('roles AS R', 'R.id = ME.role_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = ME.academic_year_id', 'left');
        $this->db->join('schools AS S', 'S.id = ME.school_id', 'left');
        $this->db->where('ME.id', $id);
        return $this->db->get()->row(); 
    }
    
    public function get_mark_sms_list($school_id = null){
        
        $this->db->select('MS.*, S.school_name, R.name AS receiver_type, AY.session_year, C.name AS class_name, EX.title AS exam_name');
        $this->db->from('mark_smses AS MS');        
        $this->db->join('classes AS C', 'C.id = MS.class_id', 'left');
        $this->db->join('exams AS EX', 'EX.id = MS.exam_id', 'left');
        $this->db->join('roles AS R', 'R.id = MS.role_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = MS.academic_year_id', 'left');
        $this->db->join('schools AS S', 'S.id = MS.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('MS.school_id', $this->session->userdata('school_id'));
        }
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('MS.school_id', $school_id);
        }
        $this->db->where('S.status', 1);
        $this->db->order_by('MS.id', 'DESC');
        
        return $this->db->get()->result(); 
    }
    
    public function get_single_sms($id){
        
        $this->db->select('MS.*, S.school_name, R.name AS receiver_type, AY.session_year, C.name AS class_name, EX.title AS exam_name');
        $this->db->from('mark_smses AS MS');        
        $this->db->join('classes AS C', 'C.id = MS.class_id', 'left');
        $this->db->join('exams AS EX', 'EX.id = MS.exam_id', 'left');
        $this->db->join('roles AS R', 'R.id = MS.role_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = MS.academic_year_id', 'left');
        $this->db->join('schools AS S', 'S.id = MS.school_id', 'left');
        $this->db->where('MS.id', $id);
        return $this->db->get()->row(); 
    }
    
    public function get_aoi_marks_list_by_student($school_id, $exam_id, $class_id, $student_id, $lesson_detail_id,$topic_details_id,$activity_id, $academic_year_id){
        
        $this->db->select('M.activity_score, M.activity_out_of_ten,M.activity_descriptor, S.name AS subject');
        $this->db->from('aoi_marks AS M'); 
        $this->db->join('subjects AS S', 'S.id = M.subject_id', 'left');
        $this->db->join('lp_lesson_details AS l', 'l.id = M.lesson_detail_id', 'left');
        $this->db->join('lp_topic_details AS t', 't.id = M.topic_details_id', 'left');
        $this->db->join('aois AS a', 'a.id = M.activity_id', 'left');
        $this->db->where('M.school_id', $school_id);
        $this->db->where('M.exam_id', $exam_id);
        $this->db->where('M.class_id', $class_id);
        $this->db->where('M.student_id', $student_id);
        $this->db->where('M.academic_year_id', $academic_year_id); 
        return $this->db->get()->result();
         
    }
    public function get_average_activity_score_by_student($school_id, $exam_id, $class_id, $student_id, $topic_details_id,$activity_id, $academic_year_id,$aoi_marks_id ){
        
        $this->db->select('M.average_activity_score S.name AS subject');
        $this->db->from('activity_averages AS AV'); 
        $this->db->join('subjects AS S', 'S.id = AV.subject_id', 'left');
        // $this->db->join('lp_lesson_details AS l', 'l.id = M.lesson_detail_id', 'left');
        $this->db->join('lp_topic_details AS t', 't.id = AV.topic_details_id', 'left');
        $this->db->join('aois AS a', 'a.id = AV.activity_id', 'left');
        $this->db->join('aoi_marks AS am', 'am.id = AV.aoi_marks_id', 'left');
        $this->db->where('AV.school_id', $school_id);
        $this->db->where('AV.exam_id', $exam_id);
        $this->db->where('AV.class_id', $class_id);
        $this->db->where('M.student_id', $student_id);
        $this->db->where('AV.academic_year_id', $academic_year_id); 
        return $this->db->get()->result();
         
    }

}
