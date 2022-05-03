<div>
	<label><?php echo ossn_print('forum:select:category');?></label>
    <?php
		echo ossn_plugin_view('input/dropdown', array(
				'name' => 'category_guid',
				'value' => (int)$params['category_guid'],
				'options' => forum_categories_to_dropdown(),
		));
	?>        
</div>
<div>
		<label><?php echo ossn_print('forum:topic:title');?></label>
        <input type="text" name="title" />
</div>
<div>
		<label><?php echo ossn_print('forum:topic:description');?></label>
        <textarea id="forum-editor" name="description"></textarea>
</div>
<div>
		<input type="submit" class="btn btn-success" value="<?php echo ossn_print('save');?>" />
</div>