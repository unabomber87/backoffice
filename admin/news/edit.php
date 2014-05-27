<?php

	$files_root = "../..";


	require_once($files_root.'/lib/globals.php');
	require_once($files_root.'/inc/caching_xtemplate.class.php');
	require_once($files_root."/inc/database.inc.php");
	require_once($files_root."/lib/db_conn.php");
	require_once($files_root."/inc/news/News.php");
	require_once($files_root."/inc/news/NewsDAO.php");

	if (!isset($_SESSION)) session_start();


	if (!isset($_SESSION['user'])){
	   header ("Location: ".$site_root."/login.php");
	}
	else{

		if(isset($_GET["news_id"])){
			$id = $_GET["news_id"]; 
			$db = new Database($username_MyCONN, $password_MyCONN, $hostname_MyCONN, $database_MyCONN);
			$news_dao = new NewsDAO($db);
			$news = $news_dao->get_news_by_id($id);
			
			$template_file 	= "tpl_add_news.html";
			$template_dir  	= $files_root."/tpl/fr/news";

			
			$tpl = new CachingXTemplate($template_file, $template_dir , $template_look_up, 
						                $template_main_block, $template_auto_setup, $template_ache_TTL, 
						                $template_unicity, $template_cache_folder , $template_cache_extension);

			$tpl->assign('site_root',$site_root);
			
			$tpl->assign('title',$news->getNewstitle());
			$tpl->assign('body',$news->getNewsbody());
			$tpl->assign('date',$news->getNewsdate());
			$checkactive = ($news->getNewsactive() == 1 ? 'checked' : '');
			$tpl->assign('active',$checkactive);
			$tpl->assign('id',$news->getNewsid());
			$tpl->assign('img',$news->getNewsimg());
			$tpl->assign('files_root',$files_root);
			$db->disconnect();
			$tpl->assign('title_page','News');
			$tpl->parse('main');
			$tpl->out('main');
		}

		else header("Location: index.php");
	}

?>
