<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ActivityAverage_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    
    public function get_average_list($school_id, $academic_year_id, $class_id, $section_id, $subject_id){
        
        $this->db->select('FR.*, E.roll_no, ST.name AS student, ST.photo,ST.admission_no, C.name AS class_name, S.name AS section, AY.session_year');
        $this->db->from('aoi_marks AS FR');   
        $this->db->join('enrollments AS E', 'E.student_id = FR.student_id', 'left');
        $this->db->join('students AS ST', 'ST.id = E.student_id', 'left');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('sections AS S', 'S.id = E.section_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');
        $this->db->where('FR.subject_id', $subject_id);

               
      
        $this->db->where('FR.school_id', $school_id);
             
        if($academic_year_id){
            $this->db->where('E.academic_year_id', $academic_year_id);
        }       
        
        if($class_id != ''){
           $this->db->where('E.class_id', $class_id);
        } 
        if($section_id != ''){
           $this->db->where('E.section_id', $section_id);
        } 

        $this->db->where('ST.status_type', 'regular');
  
        return $this->db->get()->result();   
       
    }    
  

}
