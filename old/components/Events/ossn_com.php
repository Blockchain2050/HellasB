<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
define('EVENTS', ossn_route()->com . 'Events/');
define('EVENTS_SORT_BY_DATE', true); //set false if you wanted to sort events as in the order they created
require_once(EVENTS . 'classes/Events.php');
ossn_register_system_sdk('Events', 'events_init_30');