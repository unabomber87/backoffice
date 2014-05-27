<?php


class NewsDAO {
    
    
    /**
     *
     * @var Database 
     */
    
    private $dblink;
    
    function __construct(Database $dblink) {
        $this->dblink = $dblink;
    }

    

	
	public function get_news_by_id($id){
			$query_select = "SELECT * FROM news WHERE news_id = %s";
		
			$news_array = $this->dblink->query(sprintf($query_select,$this->dblink->cleanUp($id, "int")));
		
		                
            if (!$news_array) return null;
            
            $news = new News();
            $news->setNewsid($news_array[0]['news_id']);
            $news->setNewstitle($news_array[0]['news_title']);
            $news->setNewsbody($news_array[0]['news_body']);
            $news->setNewsimg($news_array[0]['news_img']);
            $news->setNewsdate($news_array[0]['news_date']);
            $news->setNewsactive($news_array[0]['news_active']);
		               
			return $news;	
	}

	public function get_all_news(){
	
			$query = "SELECT * FROM news";
			$news_array = $this->dblink->query($query);
			if (!$news_array) return null;
			$result = array();
			foreach ($news_array as $news_obj){
					$news = new News();
				    $news->setNewsid($news_obj['news_id']);
				    $news->setNewstitle($news_obj['news_title']);
				    $news->setNewsbody($news_obj['news_body']);
				    $news->setNewsimg($news_obj['news_img']);
				    $news->setNewsdate($news_obj['news_date']);
				    $news->setNewsactive($news_obj['news_active']);
				    array_push($result, $news);	
			}
			
			return $result;
			
	}

    public function insert_news($news){
    
    		$query = "INSERT INTO `news`(`news_title`, `news_body`, `news_img`, `news_date`, `news_active`) VALUES (%s, %s, %s, %s, %s)";
    		$res = $this->dblink->query(
		    sprintf($query,
		    						$this->dblink->cleanUp($news->getNewstitle(), "text"),
		            				$this->dblink->cleanUp($news->getNewsbody(), "text"),
		            				$this->dblink->cleanUp($news->getNewsimg(), "text"),
		            				$this->dblink->cleanUp($news->getNewsdate(), "text"),
		            				$this->dblink->cleanUp($news->getNewsactive(), "int")
		            ));
		            
		    return $res;    
    }  
    
    
    public function update_news($news){
    
    		$query = "UPDATE `news` SET `news_title`= %s,`news_body`= %s,`news_img`= %s,`news_date`= %s,`news_active`= %s WHERE `news_id`= %s";
    		$res = $this->dblink->query(
		    sprintf($query,
		    						$this->dblink->cleanUp($news->getNewstitle(), "text"),
		            				$this->dblink->cleanUp($news->getNewsbody(), "text"),
		            				$this->dblink->cleanUp($news->getNewsimg(), "text"),
		            				$this->dblink->cleanUp($news->getNewsdate(), "text"),
		            				$this->dblink->cleanUp($news->getNewsactive(), "int"),
		            				$this->dblink->cleanUp($news->getNewsid(), "int")
		            ));
		            
		    return $res; 
    
    
    }
    
    public function delete_news($id){
    
    		$query = "DELETE FROM `news` WHERE `news_id` = %s";
    		$res = $this->dblink->query(
		    sprintf($query,
		            				$this->dblink->cleanUp($id, "int")
		            ));
		            
		    return $res; 
    
    }
}

?>
