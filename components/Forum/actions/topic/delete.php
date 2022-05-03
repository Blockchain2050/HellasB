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
  set_time_limit(0);
  $guid = input('guid');
  $topic = forum_get_topic($guid);
  if(!$topic){
 		ossn_trigger_message(ossn_print('forum:topic:delete:failed'), 'error');
 		redirect(REF);	 
  }
  
  if($topic->owner_guid == ossn_loggedin_user()->guid || ossn_loggedin_user()->canModerate()){
	  	if(forum_topic_delete($topic)){
		  	ossn_trigger_message(ossn_print('forum:topic:deleted'));
			redirect(REF);
		}
  }
 ossn_trigger_message(ossn_print('forum:topic:delete:failed'), 'error');
 redirect(REF);