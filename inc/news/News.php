<?php

class News {
   
    private $news_id;

    private $news_title;

    private $news_body;
    
    private $news_img;
    
    private $news_date;
    
    private $news_active;

    function __construct() {
        
    }

	/** getter **/
    public function getNewsid() {
        return $this->news_id;
    }

    public function getNewstitle() {
        return $this->news_title;
    }

    public function getNewsbody() {
        return $this->news_body;
    }

	public function getNewsimg() {
        return $this->news_img;
    }
    
    public function getNewsdate() {
        return $this->news_date;
    }
    
    public function getNewsactive() {
        return $this->news_active;
    }
	
	/** setter **/
    public function setNewsid($news_id) {
        $this->news_id = $news_id;
    }
    
    public function setNewstitle($news_title) {
        $this->news_title = $news_title;
    }

    public function setNewsbody($news_body) {
        $this->news_body = $news_body;
    }

    public function setNewsimg($news_img) {
        $this->news_img = $news_img;
    }

    public function setNewsdate($news_date) {
        $this->news_date = $news_date;
    }

	public function setNewsactive($news_active) {
        $this->news_active = $news_active;
    }
    
}

?>
