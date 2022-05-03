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

define('__SEARCH_POSTS__', ossn_route()->com . 'SearchPosts/');

/**
 * Initialize Component
 *
 * @return void;
 * @access private
 */
function com_search_posts_init() {
		ossn_extend_view('css/ossn.default', 'css/searchposts');
		
		ossn_add_hook('search', 'type:posts', 'com_posts_search_handler');
		
		ossn_register_callback('page', 'load:search', 'com_posts_search_link');
}

/**
 * Online member search page handler
 *
 * @return mixdata;
 * @access private
 */

function com_posts_search_handler($hook, $type, $return, $params) {
	//only return possible result if user is logged in
	if(ossn_loggedin_user()->guid){
		$wall = new OssnWall;
		$query = input('q');
		$search_options = array("search_type" => true, "description" => $query);
		
		//if not admin user add where caluse to limit reach
		if(!ossn_isAdminLoggedin()){
			
			//bof build array of friends user id's
			$user    = new OssnUser;
			$friends = $user->getFriends(ossn_loggedin_user()->guid);
			//add self user id so we can find self's posts too
			$fuid_list = array(ossn_loggedin_user()->guid);
			if($friends){
				foreach($friends as $friend){
					$fuid_list[] = $friend->guid;
				}
			}
			//eof build array of friends user id's
			
			$search_options['wheres'] = 'owner_guid IN ('.implode(",",$fuid_list) .')';
		}
		
		$posts = $wall->GetPosts($search_options);
		// take currently in use query - plus count option in order to return the number of records found
		$search_options['count'] = true;
		// get count
		$count = $wall->GetPosts($search_options);
		$found['users'] = $posts;

		$search = ossn_plugin_view('searchposts/search/view', $found);
        $search .= ossn_view_pagination($count);
        if(empty($posts)) {
            return ossn_print('ossn:search:no:result');
         }
            return $search;
        }else{
            return ossn_print('ossn:search:no:result');
        }
}

/**
 * Add 'Posts' link on search page
 *
 * @return void;
 * @access private
 */
function com_posts_search_link($event, $type, $params) {
		$url = OssnPagination::constructUrlArgs(array(
				'type'
		));
		ossn_register_menu_link('posts', 'com:searchposts:posts', "search?type=posts{$url}", 'search');
}

ossn_register_callback('ossn', 'init', 'com_search_posts_init');
