<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Alevelresult_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_subject_list($school_id, $exam_id, $class_id, $section_id, $student_id, $academic_year_id) {
        $this->db->select('S.id, S.name AS subject,G.point, G.name,REPLACE(CONCAT(SUBSTR(T.name,1,1), SUBSTR(SUBSTR(T.name,LOCATE(\' \',T.name)+1),1,1)), \' \', \'\') AS teacher_initials, 
                           P.Ptitle AS paper_title, 
                           M.a_exam_mark AS paper_score');
        $this->db->from('a_level_marks AS M');
        $this->db->join('subjects AS S', 'S.id = M.subject_id');
        $this->db->join('grades AS G', 'G.id = M.grade_id', 'left');
        $this->db->where('M.school_id', $school_id);
        $this->db->where('M.exam_id', $exam_id);
        $this->db->where('M.class_id', $class_id);
        $this->db->where('M.section_id', $section_id);
        $this->db->where('M.student_id', $student_id);
        $this->db->where('M.academic_year_id', $academic_year_id);
        $this->db->join('teachers AS T', 'S.teacher_id = T.id', 'left');
        $this->db->join('lp_paper_details AS P', 'P.id = M.paper_detail_id', 'left');
        $this->db->group_by('S.id, S.name, P.Ptitle, M.a_exam_mark');
        $this->db->order_by('S.name ASC, P.Ptitle ASC');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_paper_list($school_id, $class_id = null, $subject_id = null, $academic_year_id = null) {

        $this->db->select('L.*,  SC.school_name, C.name AS class_name, S.name AS subject, S.teacher_id, AY.session_year');
        $this->db->from('lp_papers AS L');
        $this->db->join('classes AS C', 'C.id = L.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = L.subject_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = L.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = L.school_id', 'left');
        
        if($school_id){
            $this->db->where('L.school_id', $school_id); 
        }        
        if($class_id > 0){
             $this->db->where('L.class_id', $class_id);
        }        
        if($academic_year_id){
            $this->db->where('L.academic_year_id', $academic_year_id);
        }
        if($subject_id){
            $this->db->where('L.subject_id', $subject_id);
        } 
        
        $this->db->order_by('L.id', 'ASC');
        return $this->db->get()->result();
    }
    
}