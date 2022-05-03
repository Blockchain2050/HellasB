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
 		ossn_trigger_message(ossn_print('forum:topic:edit:failed'), 'error');
 		redirect(REF);	 
  }
  
  if(ossn_loggedin_user()->canModerate()){
	  	$topic->data->is_closed = true;
	  	if($topic->save()){
	  		ossn_trigger_message(ossn_print('forum:topic:edited'));
			redirect($topic->getURL(false));
		}
  }
 ossn_trigger_message(ossn_print('forum:topic:edit:failed'), 'error');
 redirect(REF);