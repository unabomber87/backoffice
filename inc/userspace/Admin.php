<?php

class Admin {
   
    private $admin_id;

    private $admin_login;

    private $admin_passwd;

    function __construct() {
        
    }

	/** getter **/
    public function getAdminid() {
        return $this->admin_id;
    }

    public function getAdminlogin() {
        return $this->admin_login;
    }

    public function getAdminpasswd() {
        return $this->admin_passwd;
    }

	
	
	/** setter **/
    public function setAdminid($admin_id) {
        $this->admin_id = $admin_id;
    }
    
    public function setAdminlogin($admin_login) {
        $this->admin_login = $admin_login;
    }

    public function setAdminpasswd($admin_passwd) {
        $this->admin_passwd = $admin_passwd;
    }

    


    
}

?>
