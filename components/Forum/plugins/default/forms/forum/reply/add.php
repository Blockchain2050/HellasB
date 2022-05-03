<div>
	<textarea name="text" id="forum-editor"></textarea>
</div>
<div>
	<input type="hidden" name="topic_guid" value="<?php echo $params['forum']->guid;?>" />
	<input type="submit" value="<?php echo ossn_print('forum:reply:button');?>" class="btn btn-success" />
</div>