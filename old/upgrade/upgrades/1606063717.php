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
if(class_exists('Events')) {
		set_time_limit(0);
		$version = 'v3.0';
		$site    = new OssnSite;
		$setting = $site->getSettings('com_event_upgrade');
		
		if(!isset($setting->value) || isset($setting->value) && $setting->value != $version) {
				define('EVENTS', ossn_route()->com . 'Events/');
				define('EVENTS_SORT_BY_DATE', true);
				require_once(EVENTS . 'classes/Events.php');
				$events = new Events;
				$all    = $events->getEvents(array(
						'page_limit' => false
				));
				if($all) {
						foreach($all as $event) {
								$event->data->container_type = 'user';
								$event->data->container_guid = $event->owner_guid;
								$event->save();
								
								error_log("Event upgraded from 2.x to 3.x | {$event->guid}");
						}
				}
				$site->setSetting('com_event_upgrade', $version);
		} else {
				error_log("Event component | nothing to do.");
		}
}

$new_components = array(
		'RememberLogin',
);

$components = new OssnComponents;
$systemcoms = $components->getComponents();

foreach($new_components as $item) {
		if(!in_array($item, $systemcoms)) {
				$components->enable($item);
		}
}