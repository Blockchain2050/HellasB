<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$site  = new OssnFile;
$site->setFile('logo_site');
$site->setExtension(array(
		'png',
));
if(isset($site->file['tmp_name']) && $site->typeAllowed()){
	$file = $site->file['tmp_name'];
	$size = filesize($file);
	if($size > 0){
			if($size > 500000){ //500KB
					ossn_trigger_message(ossn_print('theme:goblue:logo:large'), 'error');
					redirect(REF);
			}
			$contents = file_get_contents($file);
			if(strlen($contents) > 0 && file_put_contents(ossn_route()->themes.'white/images/logo.png', $contents)){
					$cache  = ossn_site_settings('cache');
					if($cache == false) {
							$done = true;
					} else {
							$done = 2;
					}								
			} else {
				$done = false;
		
			}
	}
}
$admin  = new OssnFile;
$admin->setFile('logo_admin');
$admin->setExtension(array(
		'jpg',
		'jpeg',
));
if(isset($admin->file['tmp_name']) && $admin->typeAllowed()){
	$file = $admin->file['tmp_name'];
	$size = filesize($file);
	if($size > 0){
			if($size > 500000){ //500KB
					ossn_trigger_message(ossn_print('theme:goblue:logo:large'), 'error');
					redirect(REF);
			}
			$contents = file_get_contents($file);
			if(strlen($contents) > 0 && file_put_contents(ossn_route()->themes.'white/images/logo_admin.jpg', $contents)){
					$cache  = ossn_site_settings('cache');
					if($cache == false) {
							$done = true;
					} else {
							$done = 2;
					}								
			} else {
				$done = false;
		
			}
	}
}
$admin  = new OssnFile;
$admin->setFile('background');
$admin->setExtension(array(
		'jpg',
		'jpeg',
		'png',
));
if(isset($admin->file['tmp_name']) && $admin->typeAllowed()){
	$file = $admin->file['tmp_name'];
	$size = filesize($file);
	if($size > 0){
			if($size > 500000){ //500KB
					ossn_trigger_message(ossn_print('theme:white:file:large'), 'error');
					redirect(REF);
			}
			$contents = file_get_contents($file);
			
			$SiteSettings = new OssnSite;
			$com_white_theme_mode = $SiteSettings->getSettings('com_white_theme_mode');
			$image = 'screen.png';
			if(!empty($com_white_theme_mode) && $com_white_theme_mode == 'darkmode'){
					$image = 'screen-dark.png';
			}
			if(strlen($contents) > 0 && file_put_contents(ossn_route()->themes."white/images/{$image}", $contents)){
					$cache  = ossn_site_settings('cache');
					if($cache == false) {
							$done = true;
					} else {
							$done = 2;
					}								
			} else {
				$done = false;
		
			}
	}
}
$com_white_theme_mode = input('com_white_theme_mode');
if(!empty($com_white_theme_mode)){
		$SiteSettings = new OssnSite;
		if($SiteSettings->setSetting('com_white_theme_mode', $com_white_theme_mode)){
				$done = true;	
		}
}
if($done === true){
	ossn_trigger_message(ossn_print('theme:goblue:logo:changed'));
	redirect(REF);	
} elseif($done == 2){
	//redirect and flush cache
	ossn_trigger_message(ossn_print('theme:goblue:logo:changed'));	
	$action = ossn_add_tokens_to_url("action/admin/cache/flush");
	redirect($action);	
} else {
	ossn_trigger_message(ossn_print('theme:goblue:logo:failed'), 'error');
	redirect(REF);		
}