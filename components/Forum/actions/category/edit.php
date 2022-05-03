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
  $cat = forum_get_category($guid);
  if(!$cat){
 		ossn_trigger_message(ossn_print('forum:cat:edit:failed'), 'error');
 		redirect(REF);	 
  }
  $cat->title = $title;
  $cat->description = $desc;
  
  if($cat->save()){
	  	ossn_trigger_message(ossn_print('forum:cat:edited'));
		redirect($cat->getURL(false));
  }
 ossn_trigger_message(ossn_print('forum:cat:edit:failed'), 'error');
 redirect(REF);
  