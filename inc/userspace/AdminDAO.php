<?php


class AdminDAO {
    
    
    /**
     *
     * @var Database 
     */
    
    private $dblink;
    
    function __construct(Database $dblink) {
        $this->dblink = $dblink;
    }

    

	
	public function admin_get_user_by_login($login){
			$query_select = "SELECT * FROM admins WHERE admin_login = %s";
		
			$admin_array = $this->dblink->query(sprintf($query_select,$this->dblink->cleanUp($login, "text")));
		
		                
            if (!$admin_array) return null;
            
            $admin = new Admin();
            $admin->setAdminid($admin_array[0]['admin_id']);
            $admin->setAdminlogin($admin_array[0]['admin_login']);
            $admin->setAdminpasswd($admin_array[0]['admin_passwd']);
		               
			return $admin;	
	}

        

        
        
	public function  isLoginCorrect($login,$password){
		$query_select = "SELECT * FROM admins WHERE admin_login = %s AND admin_passwd = %s ;";
		$user_array = $this->dblink->query(
		    sprintf($query_select,
		    						$this->dblink->cleanUp($login, "text"),
		            				$this->dblink->cleanUp($password, "text")
		            ));
		    return $user_array;
	}

        
    
    
    
    
}

?>
