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
  $cat = forum_get_category($guid);
  if(!$cat){
 		ossn_trigger_message(ossn_print('forum:cat:delete:failed'), 'error');
 		redirect(REF);	 
  }
  $cat->title = $title;
  $cat->description = $desc;
  
  if($cat->deleteObject()){
	  	$forum =  new \Ossn\Component\Forum\Forum;
		$topics =  $forum->getTopics($cat->guid, array(
				'page_limit' => false,														  
		));
		if($topics){
			foreach($topics as $topic){
					forum_topic_delete($topic);
			}
		}
	  	ossn_trigger_message(ossn_print('forum:cat:deleted'));
		redirect(REF);
  }
 ossn_trigger_message(ossn_print('forum:cat:delete:failed'), 'error');
 redirect(REF);
  