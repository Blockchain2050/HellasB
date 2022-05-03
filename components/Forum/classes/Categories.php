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
class Categories extends \OssnObject {
		/**
 		 * Forum add category
		 *
		 * @param string $name A category name
		 * @param string $desc A category description
		 * 
		 * @return integer|boolean
		 */
		public function addCat($name, $desc) {
				if(!empty($name) && !empty($desc)) {
						$this->title       = $name;
						$this->description = $desc;
						$this->owner_guid  = 1;
						$this->type        = 'site';
						$this->subtype     = 'forum:category';
						return $this->addObject();
				}
		}
		/**
 		 * Categories list
		 *
		 * @param array $name A option values
		 * 
		 * @return array|boolean
		 */		
		public function getList($params = array()) {
				$vars = array(
						'type' => 'site',
						'subtype' => 'forum:category'
				);
				$args = array_merge($vars, $params);
				return $this->searchObject($args);
		}
		/**
 		 * Get a URL of category
		 *
		 * @param boolean $full if you wanted to show full url or just URI
		 * 
		 * @return string
		 */			
		public function getURL($full = true) {
				$title = \OssnTranslit::urlize($this->title);
				if($full) {
						return ossn_site_url("forum/category/view/{$this->guid}/{$title}");
				}
				return "forum/category/view/{$this->guid}/{$title}";
		}
		/**
 		 * Get a URL to delete category
		 * 
		 * @return string
		 */			
		public function deleteURL() {
				return ossn_site_url("action/forum/category/delete?guid={$this->guid}", true);
		}
		/**
 		 * Get a URL to edit category
		 * 
		 * @return string
		 */			
		public function editURL() {
				$title = \OssnTranslit::urlize($this->title);
				return ossn_site_url("forum/category/edit/{$this->guid}/{$title}");
		}
}