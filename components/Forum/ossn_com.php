<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team https://www.softlab24.com/contact
 * @copyright 2014-2016 SOFTLAB24 LIMITED
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

define('FORUM_EDIT_TIME_IN_MIN', 5);
define('FORUM', ossn_route()->com . 'Forum/');

require_once(FORUM . 'classes/Forum.php');
require_once(FORUM . 'classes/Categories.php');
require_once(FORUM . 'classes/Replies.php');
require_once(FORUM . 'vendors/htmLawed.php');

/**
 * Initialize the contents
 *
 * @return void
 */
function forum_init() {
		ossn_register_page('forum', 'forum_page_handler');
		ossn_extend_view('css/ossn.default', 'forum/css');
		if(ossn_isLoggedin()) {
				ossn_register_action('forum/topic/add', FORUM . 'actions/topic/add.php');
				ossn_register_action('forum/topic/edit', FORUM . 'actions/topic/edit.php');
				ossn_register_action('forum/topic/delete', FORUM . 'actions/topic/delete.php');
				ossn_register_action('forum/topic/close', FORUM . 'actions/topic/close.php');
				ossn_register_action('forum/topic/open', FORUM . 'actions/topic/open.php');
				
				ossn_register_action('forum/reply/add', FORUM . 'actions/reply/add.php');
				ossn_register_action('forum/reply/edit', FORUM . 'actions/reply/edit.php');
				ossn_register_action('forum/reply/delete', FORUM . 'actions/reply/delete.php');
		}
		if(ossn_isAdminLoggedin()) {
				ossn_register_action('forum/category/add', FORUM . 'actions/category/add.php');
				ossn_register_action('forum/category/edit', FORUM . 'actions/category/edit.php');
				ossn_register_action('forum/category/delete', FORUM . 'actions/category/delete.php');
		}
		ossn_new_js('forum', 'forum/js');
		ossn_new_external_css('summernote.css', '//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css', false);
		ossn_new_external_js('summernote.js', '//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js', false);
		
		ossn_register_callback('user', 'delete', 'ossn_user_forum_delete');
		ossn_register_callback('forum', 'reply:add', 'forum_reply_add');
		
		ossn_add_hook('notification:add', 'forum:topic:reply', 'ossn_notificaiton_forum_reply');
		ossn_add_hook('notification:view', 'forum:topic:reply', 'ossn_notification_forum_view');
		
		ossn_register_sections_menu('newsfeed', array(
				'name' => 'forum',
				'text' => ossn_print('forum'),
				'url' => ossn_site_url('forum/categories'),
				'section' => 'links',
				'icon' => true
		));
}
/**
 * Forum notification view for reply
 *
 * @param string $hook A hook name
 * @param string $type A hook type
 * @param string $return A mixed data
 * @param object $params A option values
 *
 * @return mixed data
 */
function ossn_notification_forum_view($hook, $type, $return, $object) {
		if($object->type == 'forum:topic:reply') {
				$subject = forum_get_topic($object->subject_guid);
				if(!$subject) {
						return '';
				}
				$baseurl        = ossn_site_url();
				$user           = ossn_user_by_guid($object->poster_guid);
				$user->fullname = "<strong>{$user->fullname}</strong>";
				$iconURL        = $user->iconURL()->small;
				
				$img  = "<div class='notification-image'><img src='{$iconURL}' /></div>";
				$type = "<div class='ossn-notification-icon-calander'></div>";
				if($notif->viewed !== NULL) {
						$viewed = '';
				} elseif($notif->viewed == NULL) {
						$viewed = 'class="ossn-notification-unviewed"';
				}
				
				$url               = $subject->getURL();
				$notification_read = "{$baseurl}notification/read/{$object->guid}?notification=" . urlencode($url);
				return "<a href='{$notification_read}'>
	      	 <li {$viewed}> {$img} 
		   	<div class='notfi-meta'> {$type}
		   	<div class='data'>" . ossn_print("ossn:notifications:{$object->type}", array(
						$user->fullname,
						$subject->title
				)) . '</div></div></li>';
		}
}

/**
 * Add a notfication for forum reply add
 *
 * @param string $hook A hook name
 * @param string $type A hook type
 * @param string $return A mixed data
 * @param object $params A option values
 *
 * @return array
 */
function ossn_notificaiton_forum_reply($hook, $type, $return, $params) {
		return array_merge($params, array(
				'owner_guid' => $params['notification_owner'],
				'item_guid' => $params['subject_guid']
		));
}
/**
 * Forum reply add callback
 *
 * @param string $callback A callback name
 * @param string $type A callback type
 * @param array  $params A option values
 *
 * @return void
 */
function forum_reply_add($callback, $type, $params) {
		$topic = forum_get_topic($params['subject_guid']);
		if(class_exists("OssnNotifications") && $topic) {
				$notification = new OssnNotifications;
				$notification->add("forum:topic:reply", $params['owner_guid'], $params['subject_guid'], NULL, $topic->owner_guid);
				
				$vars                 = array();
				$vars['poster_guid']  = $params['owner_guid'];
				$vars['owner_guid']   = $topic->owner_guid;
				$vars['subject_guid'] = $params['subject_guid'];
				ossn_trigger_callback('forum', 'notification:add', $vars);
		}
		//notify to other users
		$replies = new \Ossn\Component\Forum\Replies;
		$list    = $replies->getReplies($params['subject_guid'], array(
				'page_limit' => false
		));
		if($list) {
				foreach($list as $item) {
						if($item->owner_guid !== ossn_loggedin_user()->guid) {
								$users[] = $item->owner_guid;
						}
				}
				$allusers = array_unique($users);
				if(!empty($allusers)) {
						foreach($allusers as $user_guid) {
								if(class_exists("OssnNotifications")) {
										$notification = new OssnNotifications;
										$notification->add("forum:topic:reply", $params['owner_guid'], $params['subject_guid'], NULL, $user_guid);
										
										$vars                 = array();
										$vars['poster_guid']  = $params['owner_guid'];
										$vars['owner_guid']   = $user_guid;
										$vars['subject_guid'] = $params['subject_guid'];
										ossn_trigger_callback('forum', 'notification:add', $vars);
								}
						}
				}
		}
}
/**
 * User delete , all forums , topics
 *
 * @param string $callback A callback name
 * @param string $type A callback type
 * @param array  $params A option values
 *
 * @return void
 */
function ossn_user_forum_delete($callback, $type, $params) {
		$guid   = $params['entity']->guid;
		$forum  = new \Ossn\Component\Forum\Forum;
		$topics = $forum->getUserTopics($guid, array(
				'page_limit' => false
		));
		if($topics) {
				foreach($topics as $item) {
						forum_topic_delete($item);
				}
		}
		
		$replies = new \Ossn\Component\Forum\Replies;
		$all     = $replies->getUserReplies($guid);
		if($all) {
				foreach($all as $reply) {
						if(!empty($reply)) {
								$reply->deleteAnnotation($reply->id);
						}
				}
		}
}
/**
 * Forum categories to dropdown
 *
 * @return array
 */
function forum_categories_to_dropdown() {
		$cat     = new \Ossn\Component\Forum\Categories;
		$list    = $cat->getList(array(
				'page_limit' => false
		));
		$lists[] = ossn_print('forum:select:category');
		if($list) {
				foreach($list as $item) {
						$lists[$item->guid] = $item->title;
				}
		}
		return $lists;
}
/**
 * Forum count topics by category guid
 *
 * @param integer $cat_guid A category guid
 *
 * @return integer
 */
function forum_count_topics($cat_guid) {
		$new   = new \Ossn\Component\Forum\Forum;
		$count = $new->getTopics($cat_guid, array(
				'count' => true
		));
		if($count) {
				return $count;
		}
		return 0;
}
/**
 * Forum count replies by topic guid
 *
 * @param integer $cat_guid A Topic guid
 *
 * @return integer
 */
function forum_count_replies($cat_guid) {
		$new   = new \Ossn\Component\Forum\Replies;
		$count = $new->getReplies($cat_guid, array(
				'count' => true
		));
		if($count) {
				return $count;
		}
		return 0;
}
/**
 * Forum get last reply of category
 *
 * @param integer $cat_guid A valid guid
 *
 * @return object
 */
function forum_get_last_replies($cat_guid) {
		$new     = new \Ossn\Component\Forum\Replies;
		$replies = $new->getReplies($cat_guid, array(
				'limit' => 1,
				'order_by' => 'a.id DESC'
		));
		if($replies) {
				return $replies[0];
		}
		return false;
}
/**
 * Forum get last topic of category
 *
 * @param integer $cat_guid A valid guid
 *
 * @return object
 */
function forum_get_cat_last_topic($cat_guid) {
		$new   = new \Ossn\Component\Forum\Forum;
		$topic = $new->getLastTopic($cat_guid);
		if($topic) {
				return $topic[0];
		}
		return false;
}
/**
 * Forum topic delete
 *
 * @param integer $topic A valid guid
 *
 * @return object
 */
function forum_topic_delete($topic) {
		if(isset($topic) && $topic instanceof \Ossn\Component\Forum\Forum) {
				if($topic->deleteObject()) {
						$replies = new \Ossn\Component\Forum\Replies;
						$list    = $replies->getReplies($topic->guid, array(
								'page_limit' => false
						));
						if($list) {
								foreach($list as $item) {
										if(!empty($item)) {
												$item->deleteAnnotation($item->id);
										}
								}
						}
						if(!empty($topic->guid)) {
								//delete notifications releated to topic
								$notifications = new OssnDatabase;
								
								$vars           = array();
								$vars['from']   = 'ossn_notifications';
								$vars['wheres'] = array(
										"type='forum:topic:reply' AND subject_guid='{$topic->guid}'"
								);
								$notifications->delete($vars);
						}
						
						return true;
				}
		}
		return false;
}
/**
 * Forum view text
 *
 * @param text $text A valid text
 *
 * @return string
 */
function forum_view_text($text) {
		if($text) {
				$data 	= html_entity_decode($text, ENT_COMPAT, 'UTF-8');
				return htmLawed($data, 
					array(
						 'safe' => true,
						 'elements' => '* -script -object', 
						 'schemes' => '*:http,https,data,ftp,news,mailto,rtsp,teamspeak,gopher,mms,callto'
				));
				
		}
		return '';
}
/**
 * Forum get topic
 *
 * @param integer $guid A valid guid
 *
 * @return object
 */
function forum_get_topic($guid) {
		if(!empty($guid)) {
				if($object = ossn_get_object($guid)) {
						if($object->subtype == 'forum:item') {
								$array = (array) $object;
								return arrayObject($array, '\Ossn\Component\Forum\Forum');
						}
				}
		}
		return false;
}
/**
 * Forum get category
 *
 * @param integer $guid A valid guid
 *
 * @return object
 */
function forum_get_category($guid) {
		if(!empty($guid)) {
				if($object = ossn_get_object($guid)) {
						if($object->subtype == 'forum:category') {
								$array = (array) $object;
								return arrayObject($array, '\Ossn\Component\Forum\Categories');
						}
				}
		}
		return false;
}
/**
 * Forum get reply
 *
 * @param integer $guid A valid guid
 *
 * @return object
 */
function forum_get_reply($guid) {
		if(!empty($guid)) {
				if($object = ossn_get_annotation($guid)) {
						if($object->type == 'forum:topic:reply') {
								$array = (array) $object;
								return arrayObject($array, '\Ossn\Component\Forum\Replies');
						}
				}
		}
		return false;
}
/**
 * Forum object
 *
 * @return object
 */
function forum() {
		$new = new \Ossn\Component\Forum\Forum;
		return $forum;
}
/**
 * Forum page handler
 *
 * @return mixdata
 */
function forum_page_handler($pages) {
		ossn_load_external_js('summernote.js');
		ossn_load_external_css('summernote.css');
		ossn_load_js('forum');
		
		switch($pages[0]) {
				case 'category':
						switch($pages[1]) {
								case 'add':
										$title               = ossn_print('forum:cat:add');
										$contents['content'] = ossn_plugin_view('forum/category/add');
										$content             = ossn_set_page_layout('newsfeed', $contents);
										echo ossn_view_page($title, $content);
										break;
								case 'view':
										if($forum = forum_get_category($pages[2])) {
												$title               = $forum->title;
												$contents['content'] = ossn_plugin_view('forum/category/view', array(
														'category' => $forum
												));
												$content             = ossn_set_page_layout('contents', $contents);
												echo ossn_view_page($title, $content);
										} else {
												ossn_error_page();
										}
										break;
								case 'edit':
										if($forum = forum_get_category($pages[2])) {
												$title               = $forum->title;
												$contents['content'] = ossn_plugin_view('forum/category/edit', array(
														'category' => $forum
												));
												$content             = ossn_set_page_layout('newsfeed', $contents);
												echo ossn_view_page($title, $content);
										} else {
												ossn_error_page();
										}
										break;
								default:
										ossn_error_page();
						}
						break;
				case 'reply':
						switch($pages[1]) {
								case 'edit':
										if($reply = forum_get_reply($pages[2])) {
												$title               = ossn_print('forum:reply:edit');
												$contents['content'] = ossn_plugin_view('forum/reply/edit', array(
														'reply' => $reply
												));
												$content             = ossn_set_page_layout('newsfeed', $contents);
												echo ossn_view_page($title, $content);
										} else {
												ossn_error_page();
										}
										break;
								default:
										ossn_error_page();
						}
						break;
				case 'categories':
						$title               = ossn_print('forum:categories');
						$contents['content'] = ossn_plugin_view('forum/category/list', array(
								'category_guid' => $pages[1]
						));
						$content             = ossn_set_page_layout('contents', $contents);
						echo ossn_view_page($title, $content);
						break;
				case 'add':
						$title               = ossn_print('forum:topic:add');
						$contents['content'] = ossn_plugin_view('forum/topic/add', array(
								'category_guid' => $pages[1]
						));
						$content             = ossn_set_page_layout('newsfeed', $contents);
						echo ossn_view_page($title, $content);
						break;
				case 'edit':
						if($forum = forum_get_topic($pages[1])) {
								$title               = $forum->title;
								$contents['content'] = ossn_plugin_view('forum/topic/edit', array(
										'forum' => $forum
								));
								$content             = ossn_set_page_layout('newsfeed', $contents);
								echo ossn_view_page($title, $content);
						} else {
								ossn_error_page();
						}
						break;
				case 'topic':
						if($forum = forum_get_topic($pages[1])) {
								$title               = $forum->title;
								$contents['content'] = ossn_plugin_view('forum/topic/view', array(
										'forum' => $forum
								));
								$content             = ossn_set_page_layout('contents', $contents);
								echo ossn_view_page($title, $content);
						} else {
								ossn_error_page();
						}
						break;
				default:
						ossn_error_page();
		}
}
ossn_register_callback('ossn', 'init', 'forum_init');