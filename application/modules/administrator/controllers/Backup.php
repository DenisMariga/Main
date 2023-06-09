<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * *****************Backup.php**********************************
 * @product name    : Uganda School ERP
 * @type            : Class
 * @class name      : Backup
 * @description     : Backup system database by system adminstrator.  
 * @author          :  Denis Mariga Kamara	
 * @url             :        
 * @support         : denismariga50@gmail.com	
 * @copyright       : Denis Mariga Kamara 	
 * ********************************************************** */
class Backup extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Administrator_Model', 'administrator', true);
         
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
          error($this->lang->line('permission_denied'));
          redirect('dashboard/index');
        }
    }
    
    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load user interface for backup database and take backup database                
    *                    
    * @param           : null integer value
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);
        
        if ($_POST) {             
            if (IS_LIVE == TRUE) {
              
                $this->load->dbutil();
                $conf = array(
                    'format' => 'zip',
                    'filename' => 'database-backup.sql'
                );
                $backup = $this->dbutil->backup($conf);
                $this->load->helper('download');
                force_download('database-backup.zip', $backup);
                
                create_log('Has been taken database backup');
                redirect('administrator/backup/index');
            } else {
                error($this->lang->line('in_demo_db_backup'));
                redirect('administrator/backup/index');
            }
        } else {
            $this->layout->title($this->lang->line('backup_database'). ' | ' . SMS);
            $this->layout->view('backup/index', $this->data);  
        }
    }
    
    
}
