<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Formativecard_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_out_of_ten($school_id, $academic_year_id, $class_id, $section_id, $student_id) {
        $this->db->select('FR.*');
        $this->db->from('aoi_marks AS FR');
        // $this->db->join('subjects AS S', 'S.id = FR.subject_id');
        $this->db->where('FR.school_id', $school_id);
        $this->db->where('FR.academic_year_id', $academic_year_id);
        $this->db->where('FR.class_id', $class_id);
        $this->db->where('FR.section_id', $section_id);
        $this->db->where('FR.student_id', $student_id);
        // $this->db->group_by('S.id');
        return $this->db->get()->result();
    }
     public function get_project_score($school_id, $academic_year_id, $class_id, $section_id, $student_id) {
        $this->db->select('FR.*');
        $this->db->from('project_marks AS FR');
        // $this->db->join('subjects AS S', 'S.id = FR.subject_id');
        $this->db->where('FR.school_id', $school_id);
        $this->db->where('FR.academic_year_id', $academic_year_id);
        $this->db->where('FR.class_id', $class_id);
        $this->db->where('FR.section_id', $section_id);
        $this->db->where('FR.student_id', $student_id);
        // $this->db->group_by('S.id');
        return $this->db->get()->result();
    }
    
     public function get_student_list($school_id = null, $class_id = null, $section_id = null, $academic_year_id = null){
        
            $this->db->select('S.*, D.amount, D.title AS discount, G.name AS guardian, E.roll_no, E.section_id, E.class_id, U.username, U.role_id,  C.name AS class_name, SE.name AS section');
            $this->db->from('enrollments AS E');
            $this->db->join('students AS S', 'S.id = E.student_id', 'left');
            $this->db->join('guardians AS G', 'G.id = S.guardian_id', 'left');
            $this->db->join('users AS U', 'U.id = S.user_id', 'left');
            $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
            $this->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
            $this->db->join('discounts AS D', 'D.id = S.discount_id', 'left');
            $this->db->where('S.school_id', $school_id);            
            $this->db->where('E.class_id', $class_id);            
            $this->db->where('E.academic_year_id', $academic_year_id);      
            
            if($section_id){
                $this->db->where('E.section_id', $section_id);
            }     
            
            if($this->session->userdata('role_id') == GUARDIAN){
                $this->db->where('S.guardian_id', $this->session->userdata('profile_id'));  
            }
            
            if($this->session->userdata('role_id') == STUDENT ){
                $this->db->where('S.id', $this->session->userdata('profile_id'));
            }
            
            $this->db->where('S.status_type', 'regular');
            $this->db->order_by('E.roll_no', 'ASC');
            
            return $this->db->get()->result();
    }
    public function get_student_subject_scores($school_id, $class_id, $section_id, $student_id, $academic_year_id) {
        // Fetch all subjects a student has done and their scores for the entire academic year
        $this->db->select('S.name AS subject, M.activity_score, P.project_score');
        $this->db->from('aoi_marks AS M');
        $this->db->join('subjects AS S', 'S.id = M.subject_id', 'left');
        $this->db->join('project_marks AS P', 'P.student_id = M.student_id AND P.subject_id = M.subject_id AND P.academic_year_id = M.academic_year_id', 'left');
        $this->db->where('M.school_id', $school_id);
        $this->db->where('M.class_id', $class_id);
        $this->db->where('M.section_id', $section_id);
        $this->db->where('M.student_id', $student_id);
        $this->db->where('M.academic_year_id', $academic_year_id);
        return $this->db->get()->result();
    }
}
