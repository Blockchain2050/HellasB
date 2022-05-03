<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

$linkPlacement = input('linkPlacement');
$preserveImages = input('preserveImages');
$preserveVideos = input('preserveVideos');
$triggerAjaxOnEdit = input('triggerAjaxOnEdit');
$postVisibleChars = input('postVisibleChars');
$postRemainingChars = input('postRemainingChars');
$commentVisibleChars = input('commentVisibleChars');
$commentRemainingChars = input('commentRemainingChars');

$component = new OssnComponents;
if($component->setSettings('ReadMore', 
	array(
		'linkPlacement' => $linkPlacement,
		'preserveImages' => $preserveImages,
		'preserveVideos' => $preserveVideos,
		'triggerAjaxOnEdit' => $triggerAjaxOnEdit,
		'postVisibleChars' => $postVisibleChars,
		'postRemainingChars' => $postRemainingChars,
		'commentVisibleChars' => $commentVisibleChars,
		'commentRemainingChars' => $commentRemainingChars
	))){
	if(ossn_site_settings('cache') == true) {
		ossn_disable_cache();
		ossn_create_cache();
		ossn_trigger_message(ossn_print('cache:flushed'));
	}		
	ossn_trigger_message(ossn_print('ossn:admin:settings:saved'));
	redirect(REF);
} else {
	ossn_trigger_message(ossn_print('ossn:admin:settings:save:error'), 'error');
	redirect(REF);
}
