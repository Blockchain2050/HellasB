<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
 $component = new OssnComponents;
 
 $path = input('pattern');
 if(empty($path)){
	 ossn_trigger_message(ossn_print('firstlogin:cannot:save'), 'error');
	 redirect(REF);
 }
 $vars = array(
	'pattern' => $path,
  );
 if($component->setSettings('FirstLogin', $vars)){
	 ossn_trigger_message(ossn_print('firstlogin:saved'));
	 redirect(REF);
 } else {
	 ossn_trigger_message(ossn_print('firstlogin:cannot:save'), 'error');
	 redirect(REF);	 
 }