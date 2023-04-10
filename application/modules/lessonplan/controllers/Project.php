<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Project_Model', 'project', true);           
        
        if($this->session->userdata('role_id') == STUDENT){
            $this->data['subjects']  = $this->project->get_list('subjects',array('status'=>1, 'class_id'=>$this->session->userdata('class_id')), '','', '', 'id', 'ASC'); 
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
    //     $this->layout->title($this->lang->line('manage_project'). ' | ' . SMS);
    //     $this->layout->view('project/index', $this->data);
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
            redirect('lessonplan/project/index');
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
                
        $school = $this->project->get_school_by_id($school_id);
        $this->data['projectList'] = $this->project->get_project_list($school_id, $class_id, $subject_id, @$school->academic_year_id);               
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->project->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
       
        $this->data['schools'] = $this->schools;
        $this->data['class_id'] = $class_id;
        $this->data['school_id'] = $school_id;       
        $this->data['subject_id'] = $subject_id;
        
         
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_Project'). ' | ' . SMS);
        $this->layout->view('Project/index', $this->data);
     
     }
/*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new project" user interface                 
    *                    and process to store "project" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
     public function add() {

    check_permission(ADD);

      if ($_POST) {
          $this->_prepare_projects_validation();
        //   if ($this->form_validation->run() === TRUE) {
              $data = $this->_get_posted_projects_data();

            // check if subject is exist in projects table
              $school = $this->project->get_school_by_id($data['school_id']);
            $exist = $this->project->get_single('projects', array('class_id' => $data['class_id'], 'subject_id'=>$data['subject_id'], 'lesson_detail_id'=>$data['lesson_detail_id'], 'topic_details_id'=>$data['topic_details_id'],'name'=>$data['project'], 'Question'=>$data['question'], 'academic_year_id'=> $school->academic_year_id));
              if($exist){
                  $this->project->update('projects', $data, array('id' => $exist->id));
                  $insert_id = $exist->id;
              }else{
                  $insert_id = $this->project->insert('projects', $data);
              }
              if ($insert_id) {
                               
                  success($this->lang->line('insert_success'));
                  redirect('lessonplan/project/index');
                  
              } else {
                  error($this->lang->line('insert_failed'));
                  redirect('lessonplan/project/add');
              }
         
      }
      
      
       //$school = $this->topic->get_school_by_id($school_id);
      //$this->data['lessons'] = $this->topic->get_topic_list($school_id, $class_id, $subject_id, @$school->academic_year_id); 
      
      $this->data['projectList'] = $this->project->get_project_list('1');     
    //   echo "Something here";
    //   exit();
       //   $condition = array();
    //   $condition['status'] = 1;        
    //   if($this->session->userdata('role_id') != SUPER_ADMIN){            
    //       $condition['school_id'] = $this->session->userdata('school_id');
    //       $this->data['classes'] = $this->projects->get_list('classes', $condition, '','', '', 'id', 'ASC');
    //   }
      $this->data['schools'] = $this->schools;
    //   $this->data['class_id'] = '';
    //   $this->data['school_id'] = '';       
    //   $this->data['subject_id'] = '';

      $this->data['add'] = TRUE;  
      $this->layout->title($this->lang->line('add') .' | '. SMS);
      $this->layout->view('project/index', $this->data);
  }
   /*****************Function Delete project**********************************
    * @type            : Function
    * @function name   : save
    * @description     : delete "project" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = 'null') {

        check_permission(DELETE);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('lessonplan/project/index');    
        }
                
        if ($this->project->delete('projects', array('id' => $id))) { 
            
            $this->project->delete('projects', array('id' => $id));
            success($this->lang->line('delete_success')); 
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('lessonplan/project/index');
    }
  /*****************Function get_single_project **********************************
    * @type            : Function
    * @function name   : get_single_project
    * @description     : Load "project Single project " user interface                 
    *                       
    * @param           : $class_id integer value
    * @return          : null 
    * 

  # gets the single record data using the get_single_project function
  # and sends the data to "project" 
  # stores the data to the project/get_single_project view which is displayed
  # in the Modal in index.php view

  ********************************************************** */

  public function get_single_project(){
        
    $project_id = $this->input->post('project_id');
    $this->data['project'] = $this->project->get_single_project($project_id);  
    $this->data['project_details'] = get_project_detail_by_project_id($project_id);       
    echo $this->load->view('project/get_single_project', $this->data);
 }

#### --- End single Records Code ---- ##



   

     
     /*****************Function _prepare_topic_validation**********************************
     * @type            : Function
     * @function name   : _prepare_projects_validation
     * @description     : Process "topic" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
     private function _prepare_projects_validation() {
         
         $this->load->library('form_validation');
         $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
 
         $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
         $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
         $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required');
         $this->form_validation->set_rules('lesson_detail_id', $this->lang->line('lesson'), 'trim|required');
         $this->form_validation->set_rules('topic_details_id', $this->lang->line('topic'), 'trim|required');
         $this->form_validation->set_rules('project_name', $this->lang->line('Project'), 'trim|required');
         $this->form_validation->set_rules('project', $this->lang->line('Poject_quiz'), 'trim');
     }    
   /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Departments" user interface                 
    *                    with populated "DepartmentS" value 
    *                    and process update "Departments" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('lessonplan/project/index');
        }
        
        if ($_POST) {
            $this->_prepare_projects_validation();
            // if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_projects_data();
                $updated = $this->project->update('projects', $data, array('id' => $this->input->post('id')));

                if ($updated) {                   
                    success($this->lang->line('update_success'));
                    redirect('lessonplan/project/index');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('lessonplan/project/edit/' . $this->input->post('id'));
                }
           
        }

        if ($id) {
            $this->data['project'] = $this->project->get_single_project($id);

            if (!$this->data['project']) {
                redirect('lessonplan/project/index');
            }
        }
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->topic->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }  
        $school_id = $this->data['project']->school_id;
        $class_id = $this->data['project']->class_id;
        $subject_id = $this->data['project']->subject_id;
        $school = $this->project->get_school_by_id($school_id);
        
        $this->data['projectList'] = $this->project->get_project_list($school_id, $class_id, $subject_id, $school->academic_year_id); 
        $this->data['project_details'] = get_project_detail_by_project_id($this->data['project']->id); 
        
        $this->data['schools'] = $this->schools;
        $this->data['class_id'] = $class_id;
        $this->data['school_id'] = $school_id;       
        $this->data['subject_id'] = $subject_id;
               
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('lessonplan/project/index', $this->data);
    }
     
     /*****************Function _get_posted_topic_data**********************************
     * @type            : Function
     * @function name   : _get_posted_topic_data
     * @description     : Prepare "topic" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
     private function _get_posted_projects_data() {
 
         $items = array();
         $items[] = 'school_id';
         $items[] = 'class_id';
         $items[] = 'subject_id';
         $items[] = 'lesson_detail_id';
         $items[] = 'topic_details_id';
         $items[] = 'Question';
         $items[] = 'name';
         
         $data = elements($items, $_POST);
         
         $data['modified_at'] = date('Y-m-d H:i:s');
         $data['modified_by'] = logged_in_user_id();
         
         if ($this->input->post('id')) {
             $data['status'] = 1; //  will be from post
         } else {
             
             $school = $this->project->get_school_by_id($data['school_id']);
             
             if(!$school->academic_year_id){
                 error($this->lang->line('set_academic_year_for_school'));
                 redirect('lessonplan/project/index');  
             }
             
             $data['academic_year_id'] = $school->academic_year_id;  
                         
             $data['status'] = 1;
             $data['created_at'] = date('Y-m-d H:i:s');
             $data['created_by'] = logged_in_user_id();
         }
         
         return $data;
     }
 
     
     


}