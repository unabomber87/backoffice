<?php 

/**
* Global Variables
*/
// LOCAL
date_default_timezone_set('Africa/Tunis');  

$site_root = "http://localhost/odclogin";

 


/**
 * upload Path 
 */

$upload_path = "/var/www/odclogin/assets/uploads/";




$debug = true;


/**
* PHP Template Variables
*/
$template_look_up	  	  = null;		//* @param array $files Filenames lookup
$template_main_block	  = "main";		//* @param string $mainblock Name of main block in the template
$template_auto_setup 	  = true;		//* @param boolean $autosetup If true, run setup() as part of constuctor
$template_ache_TTL   	  = 0;			//* @param int $cache_expiry Seconds to cache for
$template_unicity   	  = session_id();	//* @param string $cache_unique Unique file id (e.g. session_id())
$template_cache_folder    = "./cache";		//* @param string $cache_dir Cache folder
$template_cache_extension = ".xcache";		//* @param string $cache_ext Cache file extension 




?>
