<?php


$files_root = ".";



require_once($files_root.'/lib/globals.php');
require_once($files_root.'/inc/caching_xtemplate.class.php');
require_once($files_root."/inc/database.inc.php");
require_once($files_root."/lib/db_conn.php");


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
$template_dir  	= $files_root."/tpl/fr";       	 //* @param string $tpldir Location of template files
                                    //* (useful for keeping files outside web server root)

$tpl = new CachingXTemplate($template_file, $template_dir , $template_look_up, 
                            $template_main_block, $template_auto_setup, $template_ache_TTL, 
                            $template_unicity, $template_cache_folder , $template_cache_extension);



$tpl->assign('files_root',$files_root);
$tpl->assign('site_root',$site_root);
$tpl->assign('page_title','Hello');
$tpl->parse('main');
$tpl->out('main');
}
?>
