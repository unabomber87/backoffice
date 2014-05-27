<?php

$files_root = ".";
require_once($files_root.'/lib/globals.php');
require_once($files_root."/lib/db_conn.php");
require_once($files_root.'/inc/database.inc.php');
require_once($files_root.'/inc/userspace/AdminDAO.php');
require_once($files_root.'/inc/userspace/Admin.php');
require_once($files_root.'/inc/caching_xtemplate.class.php');


/** session manager **/
if (!isset($_SESSION)){ 
	session_start();
}

if ( (isset($_SESSION['user'])) && (isset($_SESSION['user']['id'])) ) header ("Location: ".$files_root."/admin/index.php");


$dblink = new Database($username_MyCONN, $password_MyCONN, $hostname_MyCONN, $database_MyCONN);

$admin_dao = new AdminDAO($dblink);    


if ((isset($_POST['login'])) && (isset($_POST['passwd']))){
	
	
	if ($admin_dao->isLoginCorrect($_POST['login'], $_POST['passwd']))
	{
		$logged_user = $admin_dao->admin_get_user_by_login($_POST['login']);
		$_SESSION['user']['login'] = $logged_user->getAdminlogin();
		
		header ("Location: ".$files_root."/index.php");
	}
	else {
	  
	  $connect_string = "<span style='color:red'>Erreur de connexion</span>";     
		
	}
 	
}	
else{
    $connect_string = "";  
}




/**
* Extract the page identifier for use with the Backlinks object
*/
$page_identifier = str_replace("/", "", $_SERVER['PHP_SELF']);







/**
* Create the template object
*/
$template_file 	= "tpl_login.html";  //* @param string $file Template file to work on
$template_dir  	= $files_root."/tpl/fr";       	 //* @param string $tpldir Location of template files
                                    //* (useful for keeping files outside web server root)

$tpl = new CachingXTemplate($template_file, $template_dir , $template_look_up, 
                            $template_main_block, $template_auto_setup, $template_ache_TTL, 
                            $template_unicity, $template_cache_folder , $template_cache_extension);


//$dblink->disconnect();


$tpl->assign('login_msg',$connect_string);
$tpl->assign('files_root',$files_root);
$tpl->assign('site_root',$site_root);
$tpl->assign('page_title','Login');
$tpl->parse('main');
$tpl->out('main');

?>
