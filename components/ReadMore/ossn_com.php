<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
 
define('__READMORE__', ossn_route()->com . 'ReadMore/');

function com_ReadMore_init() {
	if(method_exists(new OssnSite, 'setSetting')) {
		ossn_extend_view('css/ossn.default', 'css/readmore');
		ossn_extend_view('js/opensource.socialnetwork', 'js/readmore');
		if(ossn_isAdminLoggedin()){
			ossn_register_com_panel('ReadMore', 'settings');
			ossn_register_action('ReadMore/admin/settings', __READMORE__ . 'actions/ReadMore/admin/settings.php');		
		}
		if(ossn_isLoggedin()) {
			ossn_unregister_action('comment/embed');
			ossn_register_action('comment/embed', __READMORE__ . 'actions/comment/embed.php');
			ossn_unregister_action('wall/post/embed');
			ossn_register_action('wall/post/embed', __READMORE__ . 'actions/wall/post/embed.php');
		}
	} else {
		error_log('Readmore: Error version mismatch');
		ossn_trigger_message(ossn_print('ossn:admin:settings:save:error'), 'error');
		$comp = new OssnComponents;
		$comp->DISABLE('ReadMore');
		redirect(REF);
	}
}
ossn_register_callback('ossn', 'init', 'com_ReadMore_init');
