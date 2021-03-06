<?php

/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

// delete functions are doing update
class OssnLikes extends OssnDatabase
{
	/**
	 * Like item
	 *
	 * @params integer $subject_id Id of item which users liked
	 * @params integer $guid Guid of user
	 * @params string  $type Subject type
	 *
	 * @return bool
	 */
	public function Like($subject_id, $guid, $type = 'post', $reaction_type = 'like')
	{
		if (empty($subject_id) || empty($guid) || empty($type)) {
			return false;
		}
		if (empty($reaction_type)) {
			$reaction_type = 'like';
		}
		if ($type == 'annotation') {
			$annotation                = new OssnAnnotation;
			$annotation->annotation_id = $subject_id;
			$annotation                = $annotation->getAnnotationById();
			if (empty($annotation->id)) {
				return false;
			}
		}
		if ($type == 'post') {
			$post              = new OssnObject;
			$post->object_guid = $subject_id;
			$post              = $post->getObjectById();
			if (empty($post->time_created)) {
				return false;
			}
		}
		
			$value= $this->isMyLiked($subject_id, $guid, $type);
			
			if($value==="empty"){
				$this->statement("UPDATE ossn_likes SET subtype='{$reaction_type}' WHERE(
					subject_id='{$subject_id}' AND guid='{$guid}' AND type='{$type}');");
			}else{
				$this->statement("INSERT INTO ossn_likes (`subject_id`, `guid`, `type`, `subtype`)
					           VALUES('{$subject_id}', '{$guid}', '{$type}', '{$reaction_type}');");
			}

			if ($this->execute()) {
				$this->reactionsAddRewarding($reaction_type,$guid, $subject_id,$type);
				$params['subject_guid'] = $subject_id;
				$params['owner_guid']   = $guid;
				$params['type']         = "like:{$type}";
				ossn_trigger_callback('like', 'created', $params);
				error_log("hello");
				return true;
			}
		
		return false;
	}
	/*
	reactionsAddRewarding is the functions that give or take points base on reactions from the user
	*/

	private function reactionsAddRewarding($reaction_type,$guid, $subject_id,$type)
	{	

		$owner=$this->checkOwner($guid, $subject_id,$type);
		// error_log("outside add");
		// error_log($owner);	
		if($owner===""){
			return;
		}
		
		$this->statement("SELECT points FROM tk_points WHERE (guid='{$owner}');");
		$this->execute();
		$this->check = $this->fetch();
		$points = $this->check->points;
		$pool_points = $this->getPointsFromPool();
		error_log($pool_points);
		$fake_points = 0;
		if ($reaction_type === "like") {
			if($type==='post'){
				$this->addLikePointsForPost($points,$pool_points,$owner);
			}else{
				$this->addLikePointsForComment($points,$pool_points,$owner);
			}
		} 
		elseif ($reaction_type === "dislike") {
			$points = $points - 3;
			$this->statement("UPDATE tk_points SET points='{$points}' WHERE(guid='{$owner}');");
			$this->execute();
			$this->check = $this->fetch();
			$pool_points = $pool_points + 3;
			$this->statement("UPDATE tk_points SET points='{$pool_points}' WHERE(id=0);");
			$this->execute();
		} 
		elseif ($reaction_type === "angry") {
			// $points = $points - 100;
			// $this->statement("UPDATE tk_points SET points='{$points}' WHERE(guid='{$owner}');");
			// $this->execute();
			// $this->check = $this->fetch();
		}
	}

	/*
	reactionsForRewarding is the functions that return points if user press unlike
	*/

	private function reactionsRemoveRewarding($reaction_type,$guid, $subject_id,$type)
	{

		$owner=$this->checkOwner($guid, $subject_id,$type);
		// error_log("outside add");
		// error_log($owner);	
		if($owner===""){
			return;
		}

		$this->statement("SELECT points FROM tk_points WHERE (guid='{$owner}');");
		$this->execute();
		$this->check = $this->fetch();
		$points = $this->check->points;
		$pool_points = $this->getPointsFromPool();
		
		if ($reaction_type === "like") {
			$points = $points - 3;
			$this->statement("UPDATE tk_points SET points='{$points}' WHERE(guid='{$owner}');");
			$this->execute();
			$this->check = $this->fetch();
			$pool_points = $pool_points + 3;
			$this->statement("UPDATE tk_points SET points='{$pool_points}' WHERE(id=0);");
			$this->execute();
		} elseif ($reaction_type === "dislike") {
			$points = $points + 3;
			$this->statement("UPDATE tk_points SET points='{$points}' WHERE(guid='{$owner}');");
			$this->execute();
			$this->check = $this->fetch();
			$pool_points = $pool_points - 3;
			$this->statement("UPDATE tk_points SET points='{$pool_points}' WHERE(id=0);");
			$this->execute();
		} elseif ($reaction_type === "angry") {
			// $points = $points + 100;
			// $this->statement("UPDATE tk_points SET points='{$points}' WHERE(guid='{$owner}');");
			// $this->execute();
			// $this->check = $this->fetch();
		}
	}

	/**
	 * Check if user liked item or not
	 *
	 * @params integer $subject_id Id of item which users liked
	 * @params integer $guid Guid of user
	 * @params string  $type Subject type
	 *
	 * @return bool;
	 */
	public function isLiked($subject_id, $guid, $type = 'post')
	{
		$this->statement("SELECT * FROM ossn_likes WHERE (
	                     subject_id='{$subject_id}' AND guid='{$guid}' AND type='{$type}');");
		$this->execute();
		$this->check = $this->fetch();
		if (!empty($this->check->id) and !($this->check->subtype === '')) {
			return true;
		}
		return false;
	}

	// custom function isLiked so i can do the changes for rewarding system without change all the system
	public function isMyLiked($subject_id, $guid, $type = 'post')
	{
		$this->statement("SELECT * FROM ossn_likes WHERE (
	                     subject_id='{$subject_id}' AND guid='{$guid}' AND type='{$type}');");
		$this->execute();
		$this->check = $this->fetch();
		if ($this->check->subtype === '') {
			return "empty";
		}
		if (!empty($this->check->id)) {
			return true;
		}
		return false;
	}

	/**
	 * Unlike item
	 *
	 * @params integer $subject_id Id of item which users liked
	 * @params integer $guid Guid of user
	 * @params string  $type Subject type
	 *
	 * @return bool;
	 */
	public function UnLike($subject_id, $guid, $type = 'post')
	{
		if (empty($subject_id) || empty($guid) || empty($type)) {
			return false;
		}

		$vars               = array();
		$vars['subject_id'] = $subject_id;
		$vars['type']       = $type;
		$vars['guid']       = $guid;

		ossn_trigger_callback('like', 'before:deleted', $vars);
		if ($this->isLiked($subject_id, $guid, $type)) {
			$this->statement("SELECT subtype FROM ossn_likes WHERE (
				subject_id='{$subject_id}' AND guid='{$guid}' AND type='{$type}');");
			$this->execute();
			$this->check = $this->fetch();
			if ($type === 'post') {
				$this->reactionsRemoveRewarding($this->check->subtype, $guid, $subject_id,$type);
			}
			if ($type === 'annotation') {
				$this->reactionsRemoveRewarding($this->check->subtype, $guid, $subject_id,$type);
			}
			$this->statement("UPDATE ossn_likes SET subtype='' WHERE(
	                         subject_id='{$subject_id}' AND guid='{$guid}' AND type='{$type}');");
			if ($this->execute()) {
				ossn_trigger_callback('like', 'deleted', $vars);
				return true;
			}
		}
		return false;
	}

	/**
	 * Delte subject likes
	 *
	 * @params integer $subject_id Id of item which users liked
	 * @params string  $type Subject type
	 *
	 * @return bool;
	 */

	// delete functions are doing update

	public function deleteLikes($subject_id, $type = 'post')
	{
		if (empty($subject_id) || empty($type)) {
			return false;
		}
		//[B]Like deleted callback triggered even if there is no likes #1643
		$likes = $this->GetLikes($subject_id, $type);
		if ($likes) {
			$this->statement("UPDATE ossn_likes SET subtype='' WHERE(subject_id='{$subject_id}' AND type='{$type}');");
			if ($this->execute()) {
				$vars               = array();
				$vars['subject_id'] = $subject_id;
				$vars['type']       = $type;
				ossn_trigger_callback('like', 'deleted', $vars);
				return true;
			}
		}
		return false;
	}
	/**
	 * Delete likes by user guid
	 *
	 * @params integer $owner_guid Guid of user
	 *
	 * @return bool;
	 */

	// delete functions are doing update

	public function deleteLikesByOwnerGuid($owner_guid)
	{
		if (empty($owner_guid)) {
			return false;
		}
		$this->statement("UPDATE ossn_likes SET subtype='' WHERE(guid='{$owner_guid}');");
		if ($this->execute()) {
			return true;
		}
		return false;
	}
	/**
	 * Count likes
	 *
	 * @params integer $subject_id Id of item which users liked
	 * @params string  $type Subject type
	 *
	 * @return bool;
	 */
	public function CountLikes($subject_id, $type = 'post')
	{
		$likes = $this->GetLikes($subject_id, $type);
		$this->__likes_get_all = $likes;
		if ($likes) {
			$likes = get_object_vars($likes);
			if (!empty($likes)) {
				return count($likes);
			}
		}
		return false;
	}

	/**
	 * Get likes
	 *
	 * @params integer $subject_id Id of item which users liked
	 * @params string  $type Subject type
	 *
	 * @return bool;
	 */
	public function GetLikes($subject_id, $type = 'post')
	{
		$this->statement("SELECT * FROM ossn_likes WHERE (
	                     subject_id='{$subject_id}' AND type='{$type}' AND Not subtype='');");
		$this->execute();
		return $this->fetch(true);
	}

	public function GetPoints($guid)
	{
		$this->statement("SELECT points FROM tk_points WHERE (guid='{$guid}');");
		$this->execute();
		return $this->fetch(true);
	}

	private function getPointsFromPool()
	{	
		$this->statement("SELECT points FROM tk_points WHERE (guid=0);");
		$this->execute();
		$this->check = $this->fetch();
		return $this->check->points;
	}
	//check if the one who is doing like is the owner of the comment or post
	private function checkOwner($guid, $subject_id,$type){

		if($type=='post'){
			$this->statement("SELECT owner_guid FROM ossn_object WHERE (guid='{$subject_id}');");
			$this->execute();
			$this->check = $this->fetch();
			$owner = $this->check->owner_guid;
			// owner dont give points to himself
			if($owner===$guid){
				$owner="";
				return $owner;
				
			}else{
				return $owner;
			}
			

			
		}else{
			$this->statement("SELECT owner_guid FROM ossn_annotations WHERE (id='{$subject_id}');");
			$this->execute();
			$this->check = $this->fetch();
			$owner = $this->check->owner_guid;
			// owner dont give points to himself
			if($owner === $guid){
				$owner="";
				return $owner;

			}else{
				return $owner;
			}
				
		}
	}
	private function addLikePointsForPost($points,$pool_points,$owner){

			$points = $points + 3;
			$this->statement("UPDATE tk_points SET points='{$points}' WHERE(guid='{$owner}');");
			$this->execute();
			$this->check = $this->fetch();
			$pool_points = $pool_points - 3;
			$this->statement("UPDATE tk_points SET points='{$pool_points}' WHERE(id=0);");
			$this->execute();
	
		}
	private function addLikePointsForComments($points,$pool_points,$owner,$postOwner){

			$points = $points + 2;
			$this->statement("UPDATE tk_points SET points='{$points}' WHERE(guid='{$owner}');");
			$this->execute();
			$this->statement("UPDATE tk_points SET points='{$points}' WHERE(guid='{$postOwner}');");
			$this->execute();
			$this->check = $this->fetch();
			$pool_points = $pool_points - 3;
			$this->statement("UPDATE tk_points SET points='{$pool_points}' WHERE(id=0);");
			$this->execute();
	
	}
} //class
