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
class Replies extends \OssnAnnotation {
		/**
 		 * Forum add reply
		 *
		 * @param string  $text 	  A reply text
		 * @param integer $topic_guid A valid guid
		 * 
		 * @return boolean
		 */		
		public function addReply($text, $topic_guid) {
				if(!empty($text) && !empty($topic_guid)) {
						$this->subject_guid = $topic_guid;
						$this->owner_guid   = ossn_loggedin_user()->guid;
						$this->type         = 'forum:topic:reply';
						$this->value        = $text;
						if($annotation = $this->addAnnotation()){
								$params['annotation_id'] = $annotation;
								$params['owner_guid'] = ossn_loggedin_user()->guid;
								$params['subject_guid'] = $topic_guid;
								ossn_trigger_callback('forum', 'reply:add', $params);
								return true;
						}
				}
				return false;
		}
		/**
 		 * Get user replies
		 *
		 * @param integer  $owner_guid A owner guid
		 * @param array    $params A option values
		 * 
		 * @return boolean|objects
		 */				
		public function getUserReplies($owner_guid, $params = array()) {
				if(empty($owner_guid)) {
						return false;
				}
				$vars = array(
						'type' => 'forum:topic:reply',
						'owner_guid' => $owner_guid
				);
				$args = array_merge($vars, $params);
				return $this->searchAnnotation($args);
		}	
		/**
 		 * Get replies by topic guid
		 *
		 * @param integer  $topic_guid A valid guid
		 * @param array    $params A option values
		 * 
		 * @return boolean|objects
		 */			
		public function getReplies($subject_guid, $params = array()) {
				if(empty($subject_guid)) {
						return false;
				}
				$vars = array(
						'type' => 'forum:topic:reply',
						'order_by' => 'a.id ASC',
						'subject_guid' => $subject_guid
				);
				$args = array_merge($vars, $params);
				return $this->searchAnnotation($args);
		}	
		/**
 		 * Check if user can edit the reply
		 *
		 * @return boolean
		 */			
		public function canEdit(){
			if(isset($this->time_created)){
				if(time() - $this->time_created > FORUM_EDIT_TIME_IN_MIN * 60){
					return false;
				}
			}
			return true;
		}
		/**
 		 * Get a edit URL of reply
		 *
		 * @return string
		 */				
		public function editURL() {
				$title = \OssnTranslit::urlize($this->getParam('forum:topic:reply'));
				return ossn_site_url("forum/reply/edit/{$this->id}/{$title}");
		}
		/**
 		 * Get a delete URL of topic
		 *
		 * @return string
		 */				
		public function deleteURL() {
				return ossn_site_url("action/forum/reply/delete?guid={$this->id}", true);
		}		
}