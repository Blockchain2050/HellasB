<div>
	<label><?php echo ossn_print('forum:select:category');?></label>
    <?php
		echo ossn_plugin_view('input/dropdown', array(
				'name' => 'category_guid',
				'value' => (int)$params['forum']->category_guid,
				'options' => forum_categories_to_dropdown(),
		));
	?>        
</div>
<div>
		<label><?php echo ossn_print('forum:topic:title');?></label>
        <input type="text" name="title" value="<?php echo $params['forum']->title;?>"/>
</div>
<div>
		<label><?php echo ossn_print('forum:topic:description');?></label>
        <textarea id="forum-editor" name="description"><?php echo $params['forum']->description;?></textarea>
</div>
<div>
		<input type="hidden" name="guid" value="<?php echo $params['forum']->guid;?>" />
		<input type="submit" class="btn btn-success" value="<?php echo ossn_print('save');?>" />
</div>