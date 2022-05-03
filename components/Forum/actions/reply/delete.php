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
  $text = input('text');
  $id = input('guid');
  
  $reply = forum_get_reply($id);
  $subject = forum_get_topic($reply->subject_guid);

  if(!$reply || !$subject || empty($id) || ($reply->owner_guid !== ossn_loggedin_user()->guid && !ossn_loggedin_user()->canModerate())){
 		ossn_trigger_message(ossn_print('forum:topic:reply:delete:failed'), 'error');
 		redirect(REF);
  }
  if($reply->deleteAnnotation($id)){
	  	ossn_trigger_message(ossn_print('forum:topic:reply:deleted'));
		redirect(REF);
  }
 ossn_trigger_message(ossn_print('forum:topic:reply:delete:failed'), 'error');
 redirect(REF);
  