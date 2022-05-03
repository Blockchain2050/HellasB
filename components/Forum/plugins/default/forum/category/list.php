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
    	<?php if(ossn_isAdminLoggedin()){ ?>
    	<a href="<?php echo ossn_site_url("forum/category/add");?>" class="btn btn-success forum-add-topic"><?php echo ossn_print('forum:add:cat');?></a>
        <?php } ?>
		<div class="forum-categories">
			<div class="row forum-cat-item forum-cat-title">
				<div class="col-md-6 col-xs-10">
					<?php echo ossn_print('forum'); ?>
				</div>
				<div class="col-md-2 col-xs-2 topics-total">
					<?php echo ossn_print('forum:total:topics'); ?>
				</div>
				<div class="col-md-3 hidden-xs">
					<?php echo ossn_print('forum:total:last:topic'); ?>
				</div>
			</div>
			<?php
				$cat =  new \Ossn\Component\Forum\Categories;
				$cats =  $cat->getList(array(
						'page_limit' => false,							 
				));
				if($cats){
					foreach($cats as $item){ 
						$last = forum_get_cat_last_topic($item->guid);
						if($last){
							$owner = ossn_user_by_guid($last->owner_guid);
						}
					?>
			<div class="row forum-cat-item">
				<div class="col-md-6 col-xs-10">
					<div class="title"><a href="<?php echo $item->getURL();?>"><i class="fa fa-list-alt"></i><?php echo $item->title;?></a></div>
					<p class="forum-cat-desc"><?php echo $item->description;?></p>
				</div>
				<div class="col-md-2 col-xs-2 topics-total topics-total-count">
					<?php echo forum_count_topics($item->guid); ?>
				</div>
				<div class="col-md-3 hidden-xs">
					<?php if($owner){ ?>
					<div class="image-user-topic"><img  src="<?php echo $owner->iconURL()->small;?>"/></div>
					<?php } ?>
					<div class="meta-data">
						<?php if($owner){ ?>
						<a href="<?php echo $owner->profileURL();?>"><?php echo $owner->fullname;?></a>
						<p><i class="fa fa-clock-o"></i> <span class="time-created"><?php echo  ossn_user_friendly_time($last->time_created);?></span></p>
						<?php } ?>
					</div>
				</div>
				<div class="col-md-1 forum-cat-edit hidden-xs">
                	<?php if(ossn_isAdminLoggedin()){ ?>
					<a href="<?php echo $item->editURL();?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
					<a href="<?php echo $item->deleteURL();?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                    <?php } ?>
				</div>
			</div>
			<?php
					unset($last);
					unset($owner);
				}
			}
			?>
		</div>
	</div>
</div>