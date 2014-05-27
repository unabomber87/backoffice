<?php 


	$files_root = "../..";


	require_once($files_root.'/lib/globals.php');
	require_once($files_root."/inc/database.inc.php");
	require_once($files_root."/lib/db_conn.php");
	require_once($files_root."/inc/news/News.php");
	require_once($files_root."/inc/news/NewsDAO.php");
	
	if (!isset($_SESSION)) session_start();


	if (!isset($_SESSION['user'])){
	   header ("Location: ".$site_root."/login.php");
	}
	else{
	
			if(isset($_POST["action"]) && ($_POST["action"] == "activate")){
			
						$id = $_POST["news_id"];
						$state = $_POST["state"];
						$db = new Database($username_MyCONN, $password_MyCONN, $hostname_MyCONN, $database_MyCONN);
						$news_dao = new NewsDAO($db);
						$news = $news_dao->get_news_by_id($id);
						if($state == "true"){
								$news->setNewsactive(1);
						}
						else{
								$news->setNewsactive(0);
						}
						
						$news_dao->update_news($news);
						$db->disconnect();
			}
	
	}
?>
