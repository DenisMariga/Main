<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Formativecard_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    // public function get_subject_list($school_id, $class_id, $section_id, $student_id, $academic_year_id) {
    //     $this->db->select('S.name AS subject, AVG(M.activity_out_of_ten) AS activity_out_of_ten_avg, P.project_score');
    //     $this->db->from('subjects AS S');
    //     $this->db->join('(SELECT subject_id, AVG(activity_out_of_ten) AS activity_out_of_ten FROM aoi_marks WHERE school_id = '.$school_id.' AND class_id = '.$class_id.' AND section_id = '.$section_id.' AND student_id = '.$student_id.' AND academic_year_id = '.$academic_year_id.' GROUP BY subject_id) AS M', 'S.id = M.subject_id', 'left');
    //     $this->db->join('(SELECT subject_id, AVG(project_score) AS project_score FROM projects WHERE school_id = '.$school_id.' AND class_id = '.$class_id.' AND section_id = '.$section_id.' AND student_id = '.$student_id.' AND academic_year_id = '.$academic_year_id.' GROUP BY subject_id) AS P', 'S.id = P.subject_id', 'left');
    //     $this->db->group_by('S.id');
    //     return $this->db->get()->result();
    // }
    public function get_subject_list($school_id, $class_id, $section_id, $student_id, $academic_year_id) {
        $this->db->select('S.name AS subject, AVG(CASE WHEN M.activity_out_of_ten > 0 THEN M.activity_out_of_ten ELSE NULL END) AS activity_out_of_ten_avg, P.project_score, REPLACE(CONCAT(SUBSTR(T.name,1,1), SUBSTR(SUBSTR(T.name,LOCATE(\' \',T.name)+1),1,1)), \' \', \'\') AS teacher_initials');
        $this->db->from('subjects AS S');
        $this->db->join('(SELECT subject_id, activity_out_of_ten FROM aoi_marks WHERE school_id = '.$school_id.' AND class_id = '.$class_id.' AND section_id = '.$section_id.' AND student_id = '.$student_id.' AND academic_year_id = '.$academic_year_id.') AS M', 'S.id = M.subject_id', 'left');
        $this->db->join('(SELECT subject_id, AVG(project_score) AS project_score FROM project_marks WHERE school_id = '.$school_id.' AND class_id = '.$class_id.' AND section_id = '.$section_id.' AND student_id = '.$student_id.' AND academic_year_id = '.$academic_year_id.' GROUP BY subject_id) AS P', 'S.id = P.subject_id', 'left');
        $this->db->join('teachers AS T', 'S.teacher_id = T.id', 'left');
        $this->db->where('S.school_id', $school_id);
        $this->db->where('S.class_id', $class_id);
        // $this->db->where('S.section_id', $section_id);
        // $this->db->where('S.academic_year_id', $academic_year_id);
        // $this->db->where('S.status', 1);
        $this->db->group_by('S.id');
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

}
