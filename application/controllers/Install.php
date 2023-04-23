<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Install.php**********************************
 * @product name    : Uganda School ERP
 * @type            : Class
 * @class name      : Install
 * @description     : This is Install class of the application.  
 * @author          :  Denis Mariga Kamara	
 * @url             :        
 * @support         : denismariga50@gmail.com	
 * @copyright       : Denis Mariga Kamara 	
 * ********************************************************** */

class Install extends CI_Controller {
    /*     * **************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : this function redirect to installation process            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */

    public function index() {
       redirect(base_url() . 'installation/setting');             
    }

}
