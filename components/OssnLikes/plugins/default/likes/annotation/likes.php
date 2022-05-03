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
if(!isset($params['annotation_id']) || isset($params['annotation_id']) && empty($params['annotation_id'])){
	return;	
}
$datalikes   = ''; 
$OssnLikes	 = new OssnLikes;
$likes_total = $OssnLikes->CountLikes($params['annotation_id'], 'annotation');
$datalikes   = $likes_total;

if($datalikes  > 0){ 
	foreach($OssnLikes->__likes_get_all as $item){
			$last_three_icons[$item->subtype] = $item->subtype;
	}
	$last_three = array_slice($last_three_icons, -3);
?>
				<span class="ossn-likes-annotation-total">
					<?php
						// Show total likes
						echo ossn_plugin_view('output/url', array(
										'href' => 'javascript:void(0);', 
										'text' => $likes_total, 
										'onclick' => "Ossn.ViewLikes({$params['annotation_id']}, 'annotation')",
										'class' => "ossn-total-likes ossn-total-likes-{$params['annotation_id']}",
										'data-likes' => $datalikes,
						));
					?>
					</span>                    
					<div class="ossn-reaction-list">
						<?php if(isset($last_three['like'])){ ?>
						<li>
							<div class="emoji  emoji--like">
								<div class="emoji__hand">
									<div class="emoji__thumb"></div>
								</div>
							</div>
						</li>
						<?php } ?>  
						<?php if(isset($last_three['dislike'])){ ?>
						<li>
							<div class="emoji  emoji--dislike">
								<div class="emoji__hand">
									<div class="emoji__thumb"></div>
								</div>
							</div>
						</li>
						<?php } ?>                                
						<?php if(isset($last_three['angry'])){ ?>
						<li>
						<img style="position:relative;margin-top: -115px;" width='20px' height='20px' src="<?php echo ossn_theme_url();?>images/fake.png"/>
						</li>
						<?php } ?>
					</div>
<?php } ?>  