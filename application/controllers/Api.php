<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller {


   public function index() {    
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_AOI'). ' | ' . SMS);
        $this->data['sample'] = $this->db->get('aois')->result();
        $this->layout->view('menu/sample',$this->data);
     
     }

    
}  
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "topic List" user interface                 
    *                       
    * @param           : $class_id integer value
    * @return          : null 
    * ********************************************************** */
//     public function index($class_id = null) {

        
//         // check_permission(VIEW);
//         if(isset($class_id) && !is_numeric($class_id)){
//             error($this->lang->line('unexpected_error'));
//             redirect('lessonplan/AOI/index');
//         }
        
//        //  for super admin        
//         $school_id = '';
//         $subject_id = '';        
//         if($_POST){   
//             $school_id = $this->input->post('school_id');
//             $class_id  = $this->input->post('class_id');           
//             $subject_id  = $this->input->post('subject_id');           
//         }
        
//         if ($this->session->userdata('role_id') != SUPER_ADMIN) {
//             $school_id = $this->session->userdata('school_id');    
//         }               
//         if ($this->session->userdata('role_id') == STUDENT) {
//             $class_id = $this->session->userdata('class_id');    
//         }  
                
//         $school = $this->aoi->get_school_by_id($school_id);
//         $this->data['topics'] = $this->aoi->get_topic_list($school_id, $class_id, $subject_id, @$school->academic_year_id);               
        
//         $condition = array();
//         $condition['status'] = 1;        
//         if($this->session->userdata('role_id') != SUPER_ADMIN){            
//             $condition['school_id'] = $this->session->userdata('school_id');
//             $this->data['classes'] = $this->aoi->get_list('classes', $condition, '','', '', 'id', 'ASC');
//         }
       
//         $this->data['schools'] = $this->schools;
//         $this->data['class_id'] = $class_id;
//         $this->data['school_id'] = $school_id;       
//         $this->data['subject_id'] = $subject_id;
        
         
//         $this->data['list'] = TRUE;
//         $this->layout->title($this->lang->line('manage_AOI'). ' | ' . SMS);
//         $this->layout->view('AOI/index', $this->data);
     
//      }

// }