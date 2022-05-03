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
namespace Ossn\Component\Forum;
class Forum extends \OssnObject {
		/**
 		 * Forum add topic
		 *
		 * @param string  $title A topic title
		 * @param string  $desc A detailed information
		 * @param integer $category_guid A category_guid
		 * 
		 * @return object|boolean
		 */	
		public function addTopic($title, $desc, $category_guid) {
				if(!empty($title) && !empty($desc) && !empty($category_guid)) {
						$this->title       = $title;
						$this->description = $desc;
						$this->owner_guid  = ossn_loggedin_user()->guid;
						$this->type        = 'user';
						$this->subtype     = 'forum:item';
						
						$this->data->category_guid = $category_guid;
						if($guid = $this->addObject()) {
								return forum_get_topic($guid);
						}
				}
				return false;
		}
		/**
 		 * Get user topics
		 *
		 * @param array $params A option values
		 * 
		 * @return object
		 */			
		public function getUserTopics($user_guid, $params = array()) {
				if(empty($user_guid)) {
						return false;
				}
				$vars = array(
						'type' => 'user',
						'subtype' => 'forum:item',
						'owner_guid' => $user_guid
				);
				$args = array_merge($vars, $params);
				return $this->searchObject($args);
		}
		/**
 		 * Get category topics
		 *
		 * @param array $params A option values
		 * 
		 * @return object
		 */			
		public function getTopics($cat_guid, $params = array()) {
				if(empty($cat_guid)) {
						return false;
				}
				$vars = array(
						'type' => 'user',
						'subtype' => 'forum:item',
						'order_by' => 'o.guid DESC',
						'entities_pairs' => array(
								array(
										'name' => 'category_guid',
										'value' => "{$cat_guid}"
								)
						)
				);
				$args = array_merge($vars, $params);
				return $this->searchObject($args);
		}
		/**
 		 * Get category last topic
		 *
		 * @param integer $cat_guid A category guid
		 * @param array   $params   A option values
		 * 
		 * @return object
		 */			
		public function getLastTopic($cat_guid, $params = array()) {
				if(empty($cat_guid)) {
						return false;
				}
				$vars = array(
						'type' => 'user',
						'subtype' => 'forum:item',
						'limit' => 1,
						'order_by' => 'o.guid DESC',
						'entities_pairs' => array(
								array(
										'name' => 'category_guid',
										'value' => "{$cat_guid}"
								)
						)
				);
				$args = array_merge($vars, $params);
				return $this->searchObject($args);
		}
		/**
 		 * Get a URL of topic
		 *
		 * @param boolean $full if you wanted to show full url or just URI
		 * 
		 * @return string
		 */			
		public function getURL($full = true) {
				$title = \OssnTranslit::urlize($this->title);
				if($full) {
						return ossn_site_url("forum/topic/{$this->guid}/{$title}");
				}
				return "forum/topic/{$this->guid}/{$title}";
		}
		/**
 		 * Get a edit URL of topic
		 *
		 * @return string
		 */			
		public function editURL() {
				$title = \OssnTranslit::urlize($this->title);
				return ossn_site_url("forum/edit/{$this->guid}/{$title}");
		}
		/**
 		 * Get a delete URL for topic
		 *
		 * @return string
		 */				
		public function deleteURL() {
				$title = \OssnTranslit::urlize($this->title);
				return ossn_site_url("action/forum/topic/delete?guid={$this->guid}", true);
		}
		/**
 		 * Check if the forum is closed or not.
		 *
		 * @return boolean
		 */				
		public function isClosed() {
				if(isset($this->is_closed) && $this->is_closed == true) {
						return true;
				}
				return false;
		}
		/**
 		 * Close topic URL
		 *
		 * @return string
		 */				
		public function closeURL() {
				$title = \OssnTranslit::urlize($this->title);
				return ossn_site_url("action/forum/topic/close?guid={$this->guid}", true);
		}
		/**
 		 * Topic open URL
		 *
		 * @return string
		 */				
		public function openURL() {
				$title = \OssnTranslit::urlize($this->title);
				return ossn_site_url("action/forum/topic/open?guid={$this->guid}", true);
		}
		/**
 		 * Check if user can edit the topic
		 *
		 * @return boolean
		 */				
		public function canEdit() {
				if(isset($this->time_created)) {
						if(time() - $this->time_created > FORUM_EDIT_TIME_IN_MIN * 60) {
								return false;
						}
				}
				return true;
		}
}