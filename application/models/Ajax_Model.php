<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_student_list($class_id, $school_id, $academic_year_id){
        $this->db->select('E.roll_no,  S.id, S.user_id, S.name');
        $this->db->from('enrollments AS E');        
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        
        if($academic_year_id){
            $this->db->where('E.academic_year_id', $academic_year_id);
        }
        $this->db->where('E.class_id', $class_id);       
        $this->db->where('E.school_id', $school_id);       
        $this->db->where('S.status_type', 'regular');       
        return $this->db->get()->result();       
    }
    
    public function get_student_list_by_section($school_id = null, $section_id = null, $status_type = null){
        
        $school = $this->get_school_by_id($school_id);
        
        $this->db->select('E.roll_no, S.name, S.id');
        $this->db->from('enrollments AS E');        
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        
        if(!empty($school)){
             $this->db->where('E.academic_year_id', $school->academic_year_id); 
             $this->db->where('E.school_id', $school_id); 
        } 
        
        $this->db->where('E.section_id', $section_id);
       
        if($this->session->userdata('role_id') == GUARDIAN){
            $this->db->where('S.guardian_id', $this->session->userdata('profile_id'));
        }
        if($status_type){
            $this->db->where('S.status_type', $status_type);
        }
        
        return $this->db->get()->result();        
    }
    
    public function get_user_list($school_id, $type) {
        
        if ($type == 'teacher') {
            
            $this->db->select('T.name, T.user_id, D.title AS department, SG.grade_name, U.username, U.role_id');
            $this->db->from('teachers AS T');
            $this->db->join('users AS U', 'U.id = T.user_id', 'left'); 
            $this->db->join('departments AS D', 'D.id = T.department_id', 'left');
            $this->db->join('salary_grades AS SG', 'SG.id = T.salary_grade_id', 'left');
            $this->db->where('T.salary_grade_id >', 0);
            $this->db->where('T.school_id', $school_id);
            $this->db->order_by('T.id', 'ASC');
            return $this->db->get()->result();
            
        } elseif ($type == 'employee') { 
            
            $this->db->select('E.name, E.user_id, SG.grade_name, U.username, U.role_id, D.name AS designation');
            $this->db->from('employees AS E');
            $this->db->join('users AS U', 'U.id = E.user_id', 'left');
            $this->db->join('designations AS D', 'D.id = E.designation_id', 'left'); 
            $this->db->join('salary_grades AS SG', 'SG.id = E.salary_grade_id', 'left'); 
            $this->db->where('E.salary_grade_id >', 0);
             $this->db->where('E.school_id', $school_id);
            $this->db->order_by('E.id', 'ASC');
            return $this->db->get()->result();
            
        } else {
            return array();
        }
    }
      
    
    public function get_lesson_by_subject($subject_id, $academic_year_id){
                
        $this->db->select('LD.*');
        $this->db->from('lp_lesson_details AS LD');
        $this->db->join('lp_lessons AS L', 'L.id = LD.lesson_id', 'left');  
        $this->db->where('L.subject_id', $subject_id);
        $this->db->where('L.academic_year_id', $academic_year_id);
        $this->db->order_by('LD.id', 'ASC');
        return $this->db->get()->result();
        
    }
    public function get_paper_by_subject($subject_id, $academic_year_id){
                
        $this->db->select('LD.*');
        $this->db->from('lp_paper_details AS LD');
        $this->db->join('lp_papers AS L', 'L.id = LD.paper_id', 'left');  
        $this->db->where('L.subject_id', $subject_id);
        $this->db->where('L.academic_year_id', $academic_year_id);
        $this->db->order_by('LD.id', 'ASC');
        return $this->db->get()->result();
        
    }
    public function get_paper_by_subject_mark($subject_id, $academic_year_id){
                
        $this->db->select('LD.*');
        $this->db->from('lp_paper_details AS LD');
        $this->db->join('lp_papers AS L', 'L.id = LD.paper_id', 'left');  
        $this->db->where('L.subject_id', $subject_id);
        $this->db->where('L.academic_year_id', $academic_year_id);
        $this->db->order_by('LD.id', 'ASC');
        return $this->db->get()->result();
        
    }
    public function get_activity_by_topic($topic_details_id, $academic_year_id){
                
        $this->db->select('A.*');
        $this->db->from('aois AS A');
        $this->db->where('A.topic_details_id', $topic_details_id);
        $this->db->where('A.academic_year_id', $academic_year_id);
        $this->db->order_by('A.id', 'ASC');
        return $this->db->get()->result();
    }
    public function get_project_by_subject($subject_id, $academic_year_id){
                
        $this->db->select('P.*');
        $this->db->from('projects AS P');
        $this->db->where('P.subject_id', $subject_id);
        $this->db->where('P.academic_year_id', $academic_year_id);
        $this->db->order_by('P.id', 'ASC');
        return $this->db->get()->result();
        
    }
   
    public function get_topic_by_lesson($lesson_detail_id, $academic_year_id)
    {
        # code...

        $this->db->select('TP.*');
        $this->db->from('lp_topic_details AS TP');
        $this->db->join('lp_topics AS T', 'T.id = TP.topic_id','left');
        $this->db->where('T.lesson_detail_id', $lesson_detail_id);
        $this->db->where('T.academic_year_id', $academic_year_id);
        $this->db->order_by('TP.id', 'ASC');
        return $this->db->get()->result();
    }
}
