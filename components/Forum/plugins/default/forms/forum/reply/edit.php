<div>
	<textarea name="text" id="forum-editor"><?php echo $params['reply']->getParam('forum:topic:reply');?></textarea>
</div>
<div>
	<input type="hidden" name="reply_id" value="<?php echo $params['reply']->id;?>" />
	<input type="submit" value="<?php echo ossn_print('forum:save');?>" class="btn btn-success" />
</div>