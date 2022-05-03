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
	$owner = ossn_user_by_guid($params['forum']->owner_guid);
	$category = forum_get_category($params['forum']->category_guid);
?>
<div class="col-md-11 forum">
	<div class="row forum-title-top">
		<div class="col-md-12">
			<div class="breadcrumb-forum">
				<li><a href="<?php echo ossn_site_url('forum/categories');?>">Forum</a> /</li>
				<li><a href="<?php echo $category->getURL();?>"><?php echo $category->title;?></a> /</li>
				<li><a href="<?php echo $params['forum']->getURL();?>"><?php echo $params['forum']->title;?></a></li>
			</div>
			<div class="forum-item-controls">
				<?php 
					if(ossn_isLoggedin() && ossn_loggedin_user()->canModerate()){
					      					if(!$params['forum']->isClosed()){ 
					?>
				<a href="<?php echo $params['forum']->closeURL();?>" class="btn btn-warning"><i class="fa fa-info"></i>Close</a>
				<?php } else { ?>
				<a href="<?php echo $params['forum']->openURL();?>" class="btn btn-warning"><i class="fa fa-info"></i>Open</a>                    
				<?php   } 
					}
					if($params['forum']->canEdit() && $params['forum']->owner_guid == ossn_loggedin_user()->guid || (ossn_isLoggedin() && ossn_loggedin_user()->canModerate())){ ?>
				<a href="<?php echo $params['forum']->editURL();?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
				<a href="<?php echo $params['forum']->deleteURL();?>" class="btn btn-danger"><i class="fa fa-times"></i></a>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="forum-item">
		<div class="row">
			<div class="col-md-2 user-data">
				<div class="user-image">
					<img src="<?php echo $owner->iconURL()->large;?>" />
				</div>
				<div class="user-meta">
					<li class="user-profile"><a href="<?php echo $owner->profileURL();?>"><i class="fa fa-user"></i><?php echo $owner->fullname;?></a></li>
					<li class="time-created"><i class="fa fa-clock-o"></i> <?php echo ossn_user_friendly_time($params['forum']->time_created);?></li>
				</div>
			</div>
			<div class="col-md-10">
				<div class="forum-title"><?php echo $params['forum']->title;?></div>
				<div>
					<?php echo forum_view_text($params['forum']->description);?>
                    
				</div>
			</div>
		</div>
	</div>
	<div class="replies">
		<?php
			$replies = new \Ossn\Component\Forum\Replies;
			$list = $replies->getReplies($params['forum']->guid);
			$count_replies = $replies->getReplies($params['forum']->guid, array(
						'count' => true,																	
			));
			if($list){
				foreach($list as $item){
					$user = ossn_user_by_guid($item->owner_guid);
			?>
		<div class="forum-item">
			<div class="row">
				<div class="col-md-2 user-data">
					<div class="user-image">
						<img src="<?php echo $user->iconURL()->large;?>" />
					</div>
					<div class="user-meta">
						<li class="user-profile"><a href="<?php echo $user->profileURL();?>"><i class="fa fa-user"></i><?php echo $user->fullname;?></a></li>
						<li class="time-created"><i class="fa fa-clock-o"></i> <?php echo ossn_user_friendly_time($item->time_created);?></li>
					</div>
				</div>
				<div class="col-md-10">
					<div class="forum-title"><?php echo ossn_print('forum:reply', array($params['forum']->title));?></div>
					<p><?php echo forum_view_text($item->getParam('forum:topic:reply'));?></p>
					<div class="replies-controls">
						<?php
							if($item->canEdit() && $item->owner_guid == ossn_loggedin_user()->guid || (ossn_isLoggedin() && ossn_loggedin_user()->canModerate())){ ?>
						<a href="<?php echo $item->editURL();?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
						<a href="<?php echo $item->deleteURL();?>" class="btn btn-danger"><i class="fa fa-times"></i></a>
						<?php } ?>     
					</div>
				</div>
			</div>
		</div>
		<?php } 
			}
			?>
	</div>
	<div class="reply-to-forum">
		<?php
			if((ossn_isLoggedin() && !$params['forum']->isClosed()) || (ossn_isLoggedin() && ossn_loggedin_user()->canModerate())){ 
				echo ossn_view_form('forum/reply/add', array(
								'action' => ossn_site_url('action/forum/reply/add'),
								'params' => $params,
				 ));
			}
		?>            
	</div>
    <?php
		echo ossn_view_pagination($count_replies);
	?>
</div>	