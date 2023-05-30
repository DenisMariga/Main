<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Verify_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function verify($purchase_code){
        // Remove the curl request and related code
        // ...
    
        // Perform the database operations directly
        $sql = "CREATE TABLE IF NOT EXISTS `purchase` (
            `id` int(11) NOT NULL,
            `purchase_code` varchar(255) NOT NULL,
            `status` tinyint(1) NOT NULL,
            `created_at` datetime NOT NULL,
            `modified_at` datetime NOT NULL,
            `created_by` int(11) NOT NULL,
            `modified_by` int(11) NOT NULL
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";   
        $this->db->query($sql);
    
        $data = array();
        $data['id'] = 1;
        $data['purchase_code'] = $purchase_code;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = 1;
        $data['status'] = 1;       
        $this->db->empty_table('purchase');     
        $this->db->insert('purchase', $data);
    }
    
}