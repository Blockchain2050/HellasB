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
 ?>
<div class="col-md-11">
	<div class="ossn-page-contents">
    	<?php if(ossn_isLoggedin()){ ?>
		<a href="<?php echo ossn_site_url("forum/add/{$params['category']->guid}");?>" class="btn btn-success forum-add-topic"><?php echo ossn_print('forum:topic:add');?></a>
        <?php } ?>
		<div class="forum-categories">
			<div class="row forum-cat-item forum-cat-title">
				<div class="col-md-6 col-xs-10">
					<?php echo ossn_print('forum:topics'); ?>
				</div>
				<div class="col-md-2  col-xs-2 topics-total">
					<?php echo ossn_print('forum:total:topics'); ?>
				</div>
				<div class="col-md-3 hidden-xs">
					<?php echo ossn_print('forum:total:last:reply'); ?>
				</div>
			</div>
			<?php
				$cat =  new \Ossn\Component\Forum\Forum;
				$cats =  $cat->getTopics($params['category']->guid);
				$count =  $cat->getTopics($params['category']->guid, array(
								'count' => true,														   
				));
				if($cats){
					foreach($cats as $item){
							$owner = ossn_user_by_guid($item->owner_guid);
							$last_reply = forum_get_last_replies($item->guid);
							if($last_reply){
								$owner = ossn_user_by_guid($last_reply->owner_guid);
								$item->time_created = $last_reply->time_created;
							}
						?>
			<div class="row forum-cat-item">
				<div class="col-md-6 col-xs-10">
					<div class="title topics-list-title"><a href="<?php echo $item->getURL();?>"><i class="fa fa-list-alt"></i><?php echo $item->title;?></a></div>
				</div>
				<div class="col-md-2 col-xs-2 topics-total topics-total-count">
					<?php echo forum_count_replies($item->guid); ?>
				</div>
				<div class="col-md-3 hidden-xs">
					<div class="image-user-topic"><img  src="<?php echo $owner->iconURL()->small;?>"/></div>
					<div class="meta-data">
						<a href="<?php echo $owner->profileURL();?>"><?php echo $owner->fullname;?></a>
						<p><i class="fa fa-clock-o"></i> <span class="time-created"><?php echo  ossn_user_friendly_time($item->time_created);?></span></p>
					</div>
				</div>
			</div>
			<?php 
				}
				echo ossn_view_pagination($count);
			}
			?>
		</div>
	</div>
</div>