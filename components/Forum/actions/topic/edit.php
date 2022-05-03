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
  $title = input('title');
  $desc = input('description');
  $guid = input('guid');
  $cat_guid = input('category_guid');
  
  $topic = forum_get_topic($guid);
  if(!$topic || ($topic->owner_guid !== ossn_loggedin_user()->guid && !ossn_loggedin_user()->canModerate())){
 		ossn_trigger_message(ossn_print('forum:topic:edit:failed'), 'error');
 		redirect(REF);	 
  }
  $topic->title = $title;
  $topic->description = $desc;
  $topic->data->category_guid = $topic_guid;
  
  if($topic->save()){
	  	ossn_trigger_message(ossn_print('forum:topic:edited'));
		redirect($topic->getURL(false));
  }
 ossn_trigger_message(ossn_print('forum:topic:edit:failed'), 'error');
 redirect(REF);
  