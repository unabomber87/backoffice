<?php


	$files_root = "../..";


	require_once($files_root.'/lib/globals.php');
	require_once($files_root.'/inc/caching_xtemplate.class.php');
	require_once($files_root."/inc/database.inc.php");
	require_once($files_root."/lib/db_conn.php");
	require_once($files_root."/inc/news/News.php");
	require_once($files_root."/inc/news/NewsDAO.php");
	
	if (!isset($_SESSION)) session_start();


	if (!isset($_SESSION['user']))
	{
	   header ("Location: ".$site_root."/login.php");
	}
	else
	{



	/**
	* Extract the page identifier for use with the Backlinks object
	*/
	$page_identifier = str_replace("/", "", $_SERVER['PHP_SELF']);

	/**
	* Create the template object
	*/
	$template_file 	= "tpl_index.html";  //* @param string $file Template file to work on
	$template_dir  	= $files_root."/tpl/fr/news";       	 //* @param string $tpldir Location of template files
		                                //* (useful for keeping files outside web server root)

	$tpl = new CachingXTemplate($template_file, $template_dir , $template_look_up, 
		                        $template_main_block, $template_auto_setup, $template_ache_TTL, 
		                        $template_unicity, $template_cache_folder , $template_cache_extension);

	$tpl->assign('site_root',$site_root);
	$db = new Database($username_MyCONN, $password_MyCONN, $hostname_MyCONN, $database_MyCONN);

	
	$news_dao = new NewsDAO($db);
	
	$all_news = $news_dao->get_all_news();
	
	foreach($all_news as $news){
	
			$tpl->assign('title',$news->getNewstitle());
			$tpl->assign('body',$news->getNewsbody());
			$date = date("d-m-Y H:i", strtotime($news->getNewsdate()));
			$tpl->assign('date',$date);
			$checkactive = ($news->getNewsactive() == 1 ? 'checked' : '');
			$tpl->assign('active',$checkactive);
			$tpl->assign('id',$news->getNewsid());
			$tpl->assign('img',$news->getNewsimg());
			$tpl->parse('main.news_block');
	}

	

	$db->disconnect();

	$tpl->assign('files_root',$files_root);
	
	$tpl->assign('title_page','News');
	$tpl->parse('main');
	$tpl->out('main');
	}
?>
