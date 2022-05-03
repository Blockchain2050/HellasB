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
  
  $cat = new \Ossn\Component\Forum\Categories;
  if($cat->addCat($title, $desc)){
	  	ossn_trigger_message(ossn_print('forum:cat:added'));
		redirect('forum/categories');
  }
 ossn_trigger_message(ossn_print('forum:cat:add:failed'), 'error');
 redirect(REF);
  