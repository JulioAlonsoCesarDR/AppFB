<?php

class UserModel extends CI_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    
    function insert($userData)
    {
        
        $this->db->insert('dataUs', $userData);
    }

   

}