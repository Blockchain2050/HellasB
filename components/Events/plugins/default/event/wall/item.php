<?php
/**
 * Open Source Social Network
 *
 * @package   (Informatikon.com).ossn
 * @author    OSSN Core Team <info@opensource-socialnetwork.org>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
$entity = ossn_get_entity($params['post']->item_guid);
$event = ossn_get_event($entity->owner_guid);
if($event->container_type == 'user'){
	echo ossn_plugin_view('event/wall/user', $params);
}
if($event->container_type == 'group'){
	echo ossn_plugin_view('event/wall/group', $params);
}