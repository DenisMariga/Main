<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aoi_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function get_aoi_list($school_id, $class_id = null,  $subject_id = null, $academic_year_id = null){
        # code...
        $this->db->select('A.*,  SC.school_name, LD.Ltitle, Tp.title, C.name AS class_name, S.name AS subject, AY.session_year');
        $this->db->from('aois AS A');   
        $this->db->join('lp_lesson_details AS LD', 'LD.id = A.lesson_detail_id', 'left');
        $this->db->join('classes AS C', 'C.id = A.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = A.subject_id', 'left');
        $this->db->join('lp_topic_details AS Tp', 'Tp.id = A.topic_details_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = A.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = A.school_id', 'left');
        
   
        if($school_id){
           $this->db->where('A.school_id', $school_id); 
        }        
        if($class_id > 0){
             $this->db->where('A.class_id', $class_id);
        }        
        if($academic_year_id){
            $this->db->where('A.academic_year_id', $academic_year_id);
        }
        
        if($subject_id){
            $this->db->where('A.subject_id', $subject_id);
        }

        

          
        $this->db->order_by('LD.id', 'ASC');
        return $this->db->get()->result();        
        
    }

    #gets single record and sends it to the aoi controller
      
    public function get_single_aoi($id){
         
        $this->db->select('A.*,  SC.school_name, LD.Ltitle, Tp.title,C.name AS class_name, S.name AS subject,  S.teacher_id, AY.session_year');
       $this->db->from('aois AS A');   
       $this->db->join('lp_lesson_details AS LD', 'LD.id = A.lesson_detail_id', 'left');
       $this->db->join('lp_topic_details AS Tp', 'Tp.id = A.topic_details_id', 'left');
       $this->db->join('classes AS C', 'C.id = A.class_id', 'left');
       $this->db->join('subjects AS S', 'S.id = A.subject_id', 'left');
       $this->db->join('academic_years AS AY', 'AY.id = A.academic_year_id', 'left');
       $this->db->join('schools AS SC', 'SC.id = A.school_id', 'left');
       $this->db->where('A.id', $id);
       return $this->db->get()->row();
       
   }

    }


