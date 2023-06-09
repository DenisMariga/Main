<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paperattendance_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_student_list($school_id = null, $exam_id = null, $class_id = null, $section_id = null, $subject_id = null, $paper_id = null, $academic_year_id = null){
        
        $this->db->select('S.*, E.roll_no, E.class_id, E.section_id, C.name AS class_name, S.id AS student_id, S.name AS student_name, S.photo,  S.phone');  
        $this->db->from('enrollments AS E');

        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
            
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        
        $this->db->where('E.academic_year_id', $academic_year_id);       
        $this->db->where('E.class_id', $class_id);
        
        if($section_id){
            $this->db->where('E.section_id', $section_id);
        }
        
        $this->db->where('S.school_id', $school_id);
        // $this->db->where('S.exam_id', $exam_id);
        // $this->db->where('S.subject_id', $subject_id);
        
        if($this->session->userdata('role_id') == GUARDIAN){
            $this->db->where('S.guardian_id', $this->session->userdata('profile_id'));  
        }  
       $this->db->where('S.status_type', 'regular');
        return $this->db->get()->result();        
    }

}
