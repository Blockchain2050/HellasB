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

$readmore_link_placements = array(
	'div',
	'span'
);
foreach($readmore_link_placements as $style){
	 $link_placement_options[$style] = ossn_print("com:readmore:option:link:placement:{$style}"); 
}
$linkPlacement = 'div';
$preserveImages = 'checked';
$preserveVideos = 'checked';
$readmore_ajax_triggering = array(
	'true',
	'false'
);
foreach($readmore_ajax_triggering as $style){
	 $ajax_triggering_options[$style] = ossn_print("com:readmore:option:ajax:triggering:{$style}"); 
}
$triggerAjaxOnEdit = 'true';
$postVisibleChars = 126;
$postRemainingChars = 15;
$commentVisibleChars = 30;
$commentRemainingChars = 15;

$component = new OssnComponents;
$settings = $component->getComSettings('ReadMore');
if($settings) {
	$linkPlacement = $settings->linkPlacement;
	$preserveImages = $settings->preserveImages;
	$preserveVideos = $settings->preserveVideos;
	$triggerAjaxOnEdit = $settings->triggerAjaxOnEdit;
	$postVisibleChars = $settings->postVisibleChars;
	$postRemainingChars = $settings->postRemainingChars;
	$commentVisibleChars = $settings->commentVisibleChars;
	$commentRemainingChars = $settings->commentRemainingChars;
}

?> 

<div>
	<label><?php echo ossn_print('com:readmore:label:link:placement');?></label>
	<?php 
		echo ossn_plugin_view('input/radio', array(
				'name' => 'linkPlacement',
				'value' => $linkPlacement,
				'options' => $link_placement_options,
				'class' => ''
		));
	?>		
</div>
<div>
	<br>
	<label><?php echo ossn_print('com:readmore:label:media:handling');?></label>
	<div>
		<input type="checkbox" name="preserveImages" value="checked" <?php echo ' ' . $preserveImages;?> > <?php echo ossn_print('com:readmore:option:preserve:images');?>
	</div>
	<div>
		<input type="checkbox" name="preserveVideos" value="checked" <?php echo ' ' . $preserveVideos;?> > <?php echo ossn_print('com:readmore:option:preserve:videos');?> 
	</div>
</div>
<div class="input-grou">
	<br>
	<label><?php echo ossn_print('com:readmore:label:ajax:triggering');?></label>
	<?php 
		echo ossn_plugin_view('input/radio', array(
				'name' => 'triggerAjaxOnEdit',
				'value' => $triggerAjaxOnEdit,
				'options' => $ajax_triggering_options,
				'class' => ''
		));
	?>		
</div>
<div class="input-group">
	<br>
	<label><?php echo ossn_print('com:readmore:label:post:layout');?></label>
	<div class="row">
		<div class="col-sm-8"><?php echo ossn_print('com:readmore:option:post:visible:chars');?>
		</div>
		<div class="col-sm-3">
			<input class="form-control-sm" type="number" name="postVisibleChars" min="0" value="<?php echo $postVisibleChars; ?>" />
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8"><?php echo ossn_print('com:readmore:option:post:remaining:chars');?>
		</div>
		<div class="col-sm-3">
			<input class="form-control-sm" type="number" name="postRemainingChars" min="1" value="<?php echo $postRemainingChars; ?>" />
		</div>
	</div>
	<br>
	<label><?php echo ossn_print('com:readmore:label:comment:layout');?></label>
	<div class="row">
		<div class="col-sm-8"><?php echo ossn_print('com:readmore:option:post:visible:chars');?>
		</div>
		<div class="col-sm-3">
			<input class="form-control-sm" type="number" name="commentVisibleChars" min="0" value="<?php echo $commentVisibleChars; ?>" />
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8"><?php echo ossn_print('com:readmore:option:post:remaining:chars');?>
		</div>
		<div class="col-sm-3">
			<input class="form-control-sm" type="number" name="commentRemainingChars" min="1" value="<?php echo $commentRemainingChars; ?>" />
		</div>
	</div>
</div>
<div>
	<br>
	<label><?php echo ossn_print('com:readmore:label:example');?></label>
	<div>
		<?php echo ossn_print('com:readmore:description:example');?>
	</div>
</div>	
<br />
<br />
<input type="submit" value="<?php echo ossn_print('save');?>" class="btn btn-success"/>

<script>
$(document).ready(function(){
	$('.radio-block span').css('font-weight', 'normal');
	$('.radio-block').css('margin', '0');
	$("input[type='number']").css('padding', '0');
	$("input[type='number']").css('margin-bottom', '0');
});
</script>