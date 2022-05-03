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
  $cat_guid = input('category_guid');
  
  $cat = new \Ossn\Component\Forum\Forum;
  if($object = $cat->addTopic($title, $desc, $cat_guid)){
	  	ossn_trigger_message(ossn_print('forum:topic:added'));
		redirect($object->getURL(false));
  }
 ossn_trigger_message(ossn_print('forum:topic:add:failed'), 'error');
 redirect(REF);
  