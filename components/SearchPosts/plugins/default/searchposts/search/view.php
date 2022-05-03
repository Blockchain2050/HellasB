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
ossn_add_hook('wall', 'post:menu', 'ossn_wall_post_menu_view_post');
$comments = $params['users'];

if ($comments) {
    foreach ($comments as $comment) {
	$wall_comment = ossn_wallpost_to_item($comment); 
	echo ossn_wall_view_template($wall_comment);
    }

}

function ossn_wall_post_menu_view_post($hook, $type, $return, $params) {
	$view_post_link = ossn_plugin_view('output/url', array(
													'text' => "View Post",
													'href' =>  ossn_site_url() . 'post/view/' . $params['post']->guid,
													'class' => 'btn btn-primary',
												));
	return $view_post_link;
}	
	?>

