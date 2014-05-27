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


	if(!isset($_POST["news"])){
			/**
			* Create the template object
			*/
			$template_file 	= "tpl_add_news.html";  //* @param string $file Template file to work on
			$template_dir  	= $files_root."/tpl/fr/news";       	 //* @param string $tpldir Location of template files
						                        //* (useful for keeping files outside web server root)

			$tpl = new CachingXTemplate($template_file, $template_dir , $template_look_up, 
						                $template_main_block, $template_auto_setup, $template_ache_TTL, 
						                $template_unicity, $template_cache_folder , $template_cache_extension);


			$tpl->assign('id',0);
			$tpl->assign('files_root',$files_root);
			$tpl->assign('site_root',$site_root);
			$tpl->assign('title_page','News');
			$tpl->parse('main');
			$tpl->out('main');
	}

	else{
			if($_POST["news_id"] == "0"){
				$post_news = $_POST['news'];
		
				foreach ($post_news as $key => $value) {
				
						$news_post[$key] = trim($value);
				}
				$news_post['news_active'] = (isset($news_post['news_active'])? 1 :0);
				$news_post['news_date'] = date("Y-m-d H:i");
			
		
				$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
				$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
				$filename = time();
				$news = new News();
			
				/** upload img **/
				if ((isset($_FILES['image']['tmp_name'])&&($_FILES['image']['error'] == UPLOAD_ERR_OK)) && (in_array($extension_upload,$extensions_valides))) {
							move_uploaded_file($_FILES['image']['tmp_name'], $upload_path."/".$filename.".".$extension_upload);
							$news->setNewsimg($filename.".".$extension_upload);
				}
				else $news->setNewsimg("");
		
				/** set param **/
				$news->setNewstitle($news_post["news_title"]);
				$news->setNewsbody($news_post["news_body"]);
				$news->setNewsactive($news_post['news_active']);
				$news->setNewsdate($news_post['news_date']);
			
				/** insert news **/
				$db = new Database($username_MyCONN, $password_MyCONN, $hostname_MyCONN, $database_MyCONN);
				$news_dao = new NewsDAO($db);
			
				$res = $news_dao->insert_news($news);
				$db->disconnect();
				header("Location: index.php");
			}
			else{
			
				$post_news = $_POST['news'];
		
				foreach ($post_news as $key => $value) {
				
						$news_post[$key] = trim($value);
				}
				$news_post['news_active'] = (isset($news_post['news_active'])? 1 :0);
				/** get news **/
				$db = new Database($username_MyCONN, $password_MyCONN, $hostname_MyCONN, $database_MyCONN);
				$news_dao = new NewsDAO($db);
				$news = $news_dao->get_news_by_id($_POST["news_id"]);
				
				/** set param **/
				$news->setNewstitle($news_post["news_title"]);
				$news->setNewsbody($news_post["news_body"]);
				$news->setNewsactive($news_post['news_active']);
				
				
				/** image **/
				$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
				$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
				$filename = time();
				if ((isset($_FILES['image']['tmp_name'])&&($_FILES['image']['error'] == UPLOAD_ERR_OK)) && (in_array($extension_upload,$extensions_valides))) {
							unlink($upload_path."/".$news->getNewsimg());
							move_uploaded_file($_FILES['image']['tmp_name'], $upload_path."/".$filename.".".$extension_upload);
							$news->setNewsimg($filename.".".$extension_upload);
				}

				$res = $news_dao->update_news($news);
				$db->disconnect();
				header("Location: index.php");
			
			}
	}
}
?>
