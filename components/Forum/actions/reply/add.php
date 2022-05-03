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
  $topic_guid = input('topic_guid');
  
  $cat = new \Ossn\Component\Forum\Replies;
  if($cat->addReply($text, $topic_guid)){
	  	ossn_trigger_message(ossn_print('forum:topic:reply:added'));
		redirect(REF);
  }
 ossn_trigger_message(ossn_print('forum:topic:reply:failed'), 'error');
 redirect(REF);
  