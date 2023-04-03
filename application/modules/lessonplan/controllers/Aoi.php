<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aoi extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Aoi_Model', 'aois', true);           
        
        if($this->session->userdata('role_id') == STUDENT){
            $this->data['subjects']  = $this->aois->get_list('subjects',array('status'=>1, 'class_id'=>$this->session->userdata('class_id')), '','', '', 'id', 'ASC'); 
        }
        
         // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_lesson_plan')){                        
              redirect('dashboard/index');
            }
        }

      
    }


    // public function greeting(){
    //     // echo "hello there";
    //     $this->data['list'] = TRUE;
    //     $this->layout->title($this->lang->line('manage_AOI'). ' | ' . SMS);
    //     $this->layout->view('AOI/index', $this->data);
    // }

    
// }  
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "topic List" user interface                 
    *                       
    * @param           : $class_id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($class_id = null) {

        // $this->load->util_helper('permission');

        // check_permission(view);
        if(isset($class_id) && !is_numeric($class_id)){
            error($this->lang->line('unexpected_error'));
            redirect('lessonplan/AOI/index');
        }
        
       //  for super admin        
        $school_id = '';
        $subject_id = '';        
        if($_POST){   
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');           
            $subject_id  = $this->input->post('subject_id'); 
            


            // echo "Hello World";
        }
        
        if ($this->session->userdata('role_id') != SUPER_ADMIN) {
            $school_id = $this->session->userdata('school_id');    
        }               
        if ($this->session->userdata('role_id') == STUDENT) {
            $class_id = $this->session->userdata('class_id');    
        }  
                
        $school = $this->aois->get_school_by_id($school_id);
        $this->data['aois'] = $this->aois->get_aoi_list($school_id, $class_id, $subject_id, @$school->academic_year_id);               
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->aois->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
       
        $this->data['schools'] = $this->schools;
        $this->data['class_id'] = $class_id;
        $this->data['school_id'] = $school_id;       
        $this->data['subject_id'] = $subject_id;
        // $this->data['topic_id'] = _id;
        
         
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_AOI'). ' | ' . SMS);
        $this->layout->view('AOI/index', $this->data);
     
     }

     public function add() {

        check_permission(ADD);

      if ($_POST) {
          $this->_prepare_aois_validation();
          if ($this->form_validation->run() === TRUE) {
              $data = $this->_get_posted_aois_data();

              // check if subject is exist in aois table
              $school = $this->aois->get_school_by_id($data['school_id']);
              $exist = $this->aois->get_single('aois', array('class_id' => $data['class_id'], 'subject_id'=>$data['subject_id'], 'lesson_detail_id'=>$data['lesson_detail_id'], 'academic_year_id'=> $school->academic_year_id));
              if($exist){
                  $this->aois->update('aois', $data, array('id' => $exist->id));
                  $insert_id = $exist->id;
              }else{
                  $insert_id = $this->aois->insert('aois', $data);
              }
              
              if ($insert_id) {
                  
                  $this->_save_aoi($insert_id);                    
                  success($this->lang->line('insert_success'));
                  redirect('lessonplan/aoi/index');
                  
              } else {
                  error($this->lang->line('insert_failed'));
                  redirect('lessonplan/aoi/add');
              }
          } else {
              $this->data['post'] = $_POST;                
          }
      }
      
      
       //$school = $this->topic->get_school_by_id($school_id);
      //$this->data['lessons'] = $this->topic->get_topic_list($school_id, $class_id, $subject_id, @$school->academic_year_id); 
      
      $this->data['aois'] = $this->aois->get_aoi_list();     
      
      $condition = array();
      $condition['status'] = 1;        
      if($this->session->userdata('role_id') != SUPER_ADMIN){            
          $condition['school_id'] = $this->session->userdata('school_id');
          $this->data['classes'] = $this->aois->get_list('classes', $condition, '','', '', 'id', 'ASC');
      }
      
      $this->data['add'] = TRUE;  
      $this->layout->title($this->lang->line('add') .' | '. SMS);
      $this->layout->view('aoi/index', $this->data);
  }

  /*****************Function get_single_aoi **********************************
    * @type            : Function
    * @function name   : get_single_aoi
    * @description     : Load "Aoi Single AOI " user interface                 
    *                       
    * @param           : $class_id integer value
    * @return          : null 
    * 

  # gets the single record data using the get_single_aoi function
  # and sends the data to "aoi" 
  # stores the data to the Aoi/get_single_aoi view which is displayed
  # in the Modal in index.php view

  ********************************************************** */

  public function get_single_aoi(){
        
    $aois_id = $this->input->post('aoi_id');
    $this->data['aoi'] = $this->aois->get_single_aoi($aois_id);  
    $this->data['aoi_details'] = get_aoi_detail_by_aoi_id($aois_id);       
    echo $this->load->view('aoi/get_single_aoi', $this->data);
 }

#### --- End single Records Code ---- ##



   

     
     /*****************Function _prepare_topic_validation**********************************
     * @type            : Function
     * @function name   : _prepare_aois_validation
     * @description     : Process "topic" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
     private function _prepare_aois_validation() {
         
         $this->load->library('form_validation');
         $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
 
         $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
         $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
         $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required');
         $this->form_validation->set_rules('lesson_detail_id', $this->lang->line('lesson'), 'trim|required');
         $this->form_validation->set_rules('topic_details_id', $this->lang->line('topic'), 'trim|required');
         $this->form_validation->set_rules('aoi_name', $this->lang->line('AOI'), 'trim|required');
         $this->form_validation->set_rules('note', $this->lang->line('Aoi_quiz'), 'trim');
     }    
 
     
     /*****************Function _get_posted_topic_data**********************************
     * @type            : Function
     * @function name   : _get_posted_topic_data
     * @description     : Prepare "topic" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
     private function _get_posted_aois_data() {
 
         $items = array();
         $items[] = 'school_id';
         $items[] = 'class_id';
         $items[] = 'subject_id';
         $items[] = 'lesson_detail_id';
         $items[] = 'note';
         
         $data = elements($items, $_POST);
         
         $data['modified_at'] = date('Y-m-d H:i:s');
         $data['modified_by'] = logged_in_user_id();
         
         if ($this->input->post('id')) {
             $data['status'] = 1; //  will be from post
         } else {
             
             $school = $this->topic->get_school_by_id($data['school_id']);
             
             if(!$school->academic_year_id){
                 error($this->lang->line('set_academic_year_for_school'));
                 redirect('lessonplan/topic/index');  
             }
             
             $data['academic_year_id'] = $school->academic_year_id;  
                         
             $data['status'] = 1;
             $data['created_at'] = date('Y-m-d H:i:s');
             $data['created_by'] = logged_in_user_id();
         }
         
         return $data;
     }
 
     
     


}