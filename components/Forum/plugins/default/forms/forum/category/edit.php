<div>
		<label><?php echo ossn_print('forum:category:title');?></label>
        <input type="text" name="title" value="<?php echo $params['category']->title;?>" />
</div>
<div>
		<label><?php echo ossn_print('forum:category:description');?></label>
        <textarea name="description"><?php echo $params['category']->description;?></textarea>
</div>
<div>
		<input type="hidden" name="guid" value="<?php echo $params['category']->guid;?>" />
		<input type="submit" class="btn btn-success" value="<?php echo ossn_print('save');?>" />
</div>