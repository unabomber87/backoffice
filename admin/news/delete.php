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

			$id = $_GET["news_id"]; 
			$db = new Database($username_MyCONN, $password_MyCONN, $hostname_MyCONN, $database_MyCONN);
			$news_dao = new NewsDAO($db);
			$news = $news_dao->get_news_by_id($id);
			
			unlink($upload_path."/".$news->getNewsimg());
			
			$news_dao->delete_news($id);
			$db->disconnect();
			header("Location: index.php");
	}
	
	
?>
