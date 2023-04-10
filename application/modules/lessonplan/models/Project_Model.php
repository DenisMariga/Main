<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Project_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function get_project_list($school_id, $class_id = null, $subject_id = null, $academic_year_id = null){
        
        $this->db->select('P.*,  SC.school_name, LD.Ltitle, Tp.title, C.name AS class_name, S.name AS subject,S.teacher_id, AY.session_year');
        $this->db->from('projects AS P');   
        $this->db->join('lp_lesson_details AS LD', 'LD.id = P.lesson_detail_id', 'left');
        $this->db->join('classes AS C', 'C.id = P.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = P.subject_id', 'left');
        $this->db->join('lp_topic_details AS Tp', 'Tp.id = P.topic_details_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = P.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = P.school_id', 'left');
        
   
        if($school_id){
           $this->db->where('P.school_id', $school_id); 
        }        
        if($class_id > 0){
             $this->db->where('P.class_id', $class_id);
        }        
        if($academic_year_id){
            $this->db->where('P.academic_year_id', $academic_year_id);
        }
        
        if($subject_id){
            $this->db->where('P.subject_id', $subject_id);
        }
        $this->db->order_by('LD.id', 'ASC');
        $this->db->order_by('Tp.id', 'ASC');

        return $this->db->get()->result();
    }

    #gets single record and sends it to the aoi controller
      
    public function get_single_project($id){
         
        $this->db->select('P.*,  SC.school_name, LD.Ltitle, Tp.title,C.name AS class_name, S.name AS subject,  S.teacher_id, AY.session_year');
       $this->db->from('projects AS P');   
       $this->db->join('lp_lesson_details AS LD', 'LD.id = P.lesson_detail_id', 'left');
       $this->db->join('lp_topic_details AS Tp', 'Tp.id = P.topic_details_id', 'left');
       $this->db->join('classes AS C', 'C.id = P.class_id', 'left');
       $this->db->join('subjects AS S', 'S.id = P.subject_id', 'left');
       $this->db->join('academic_years AS AY', 'AY.id = P.academic_year_id', 'left');
       $this->db->join('schools AS SC', 'SC.id = P.school_id', 'left');
       $this->db->where('P.id', $id);
       return $this->db->get()->row();
       
   }

}


