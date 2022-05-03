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

$OssnLikes = new OssnLikes;

$object = $params['entity_guid'];;
$count = $OssnLikes->CountLikes($object, 'entity');

$user_liked = '';
if (ossn_isLoggedIn()) { 
            if ($OssnLikes->isLiked($object, ossn_loggedin_user()->guid, 'entity')) {
                $user_liked = true;
            }
}
/* Likes and comments don't show for nonlogged in users */ 
if($count) {
	foreach($OssnLikes->__likes_get_all as $item){
		$last_three_icons[$item->subtype] = $item->subtype;
	}
	$last_three = array_slice($last_three_icons, -3);
	?>
    <div class="like-share">
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
    	<span class="ossn-reaction-title-wholiked">
        <?php if ($user_liked == true && $count == 1) { ?>
            <?php echo ossn_print("ossn:liked:you"); ?>
        <?php
        } elseif ($user_liked == true && $count > 1) {
            $count = $count - 1;
            $total = 'person';
            if ($count > 1) {
                $total = 'people';
            }
            $link['onclick'] = "Ossn.ViewLikes({$object}, 'entity');";
            $link['href'] = 'javascript:void(0);';
            $link['text'] = ossn_print("ossn:like:{$total}", array($count));
            $link = ossn_plugin_view('output/url', $link);
            echo ossn_print("ossn:like:you:and:this", array($link));
        } elseif (!$user_liked) {
            $total = 'person';
            if ($count > 1) {
                $total = 'people';
            }
            $link['onclick'] = "Ossn.ViewLikes({$object}, 'entity');";
            $link['href'] = 'javascript:void(0);';
            $link['text'] = ossn_print("ossn:like:{$total}", array($count));
            $link = ossn_plugin_view('output/url', $link);
            echo ossn_print("ossn:like:this", array($link));
        }?>
        </span>
    </div>
<?php } ?>

