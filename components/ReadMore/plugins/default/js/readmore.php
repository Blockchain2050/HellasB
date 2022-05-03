//<script>
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence 
 * @link      https://www.opensource-socialnetwork.org/
 */

// language strings
var com_readmore_moreLink = Ossn.Print('com:readmore:link:more');
var com_readmore_lessLink = Ossn.Print('com:readmore:link:less');
var com_readmore_moreBalloon = Ossn.Print('com:readmore:balloon:more');
var com_readmore_lessBalloon = Ossn.Print('com:readmore:balloon:less');

// configurable options
// appearance of "... Read more": either 'div' = on new line or 'span' = at the end of text
var com_readmore_linkPlacement = 'div';

// display images and videos in collapsed mode? yes=true or no=false
var com_readmore_preserveImages = true;
var com_readmore_preserveVideos = true;
var com_readmore_preservePostBackground = true;

// trigger readmore on new posts/comments and post/comment-edits
var com_readmore_triggerOnAjaxEdit = true; 

// number of visible chars when collapsed
var com_readmore_postVisibleChars = 126; 
var com_readmore_commentVisibleChars = 30;

// minimum number of remaining (=hidden) chars when collapsed to trigger Readmore
var com_readmore_postRemainingChars = 15;
var com_readmore_commentRemainingChars = 15;

<?php
$component = new OssnComponents;
$settings = $component->getComSettings('ReadMore');
if($settings) {
	$commentRemainingChars = $settings->commentRemainingChars;
	?>
	com_readmore_linkPlacement  = '<?php echo $settings->linkPlacement; ?>';
	com_readmore_preserveImages = '<?php echo $settings->preserveImages; ?>';
	com_readmore_preserveVideos = '<?php echo $settings->preserveVideos; ?>';
	com_readmore_triggerOnAjaxEdit = JSON.parse(<?php echo $settings->triggerAjaxOnEdit; ?>);
	com_readmore_postVisibleChars = <?php echo $settings->postVisibleChars; ?>;
	com_readmore_postRemainingChars = <?php echo $settings->postRemainingChars; ?>;
	com_readmore_commentVisibleChars = <?php echo $settings->commentVisibleChars; ?>;
	com_readmore_commentRemainingChars = <?php echo $settings->commentRemainingChars; ?>;
<?php	
}
?>

function comReadMorePost(element) {
	$(element).each(function() {
		if($(this).find(".readMoreHidden").length || (com_readmore_preservePostBackground && $(this).is('.postbg-container'))) {
			return;
		}
		var allText = $(this).text();
		if(allText.length > com_readmore_postVisibleChars && allText.length - com_readmore_postVisibleChars >= com_readmore_postRemainingChars) {
			if(!$(this).hasClass('addReadMore')) {
				// don't add class again in edit mode
				$(this).addClass('addReadMore showlesscontent');
			}
			var allHtml = $(this).html();
			var visibleText = allText.substring(0, com_readmore_postVisibleChars);
			// check for postbg
			if($(this).is('.postbg-container') && $(this).hasClass('showlesscontent')) {
				$(this).removeClass('postbg-container');
				$(this).removeClass('postbg-text');
				$(this).addClass('postbg-showlesscontent');
			}
			// check for images
			var image = $(this).parent().find('img');
			if($(image).length) {
				if(!com_readmore_preserveImages) {
					// mark for later toggling
					$(image).addClass('addReadMore readMorePostImage');
					// keep state in edit mode
					if($(this).hasClass('showmorecontent')) {
						$(image).show();
					} else {
						$(image).hide();
					}	
				}
			}	
			// check for embedded videos
			var videoEmbeddings = $(this).find('.ossn_embed_video');
			var videoSpans = '';
			if(videoEmbeddings.length) {
				if(com_readmore_preserveVideos) {
					for(i = 0; i < videoEmbeddings.length; i++) {
						videoSpans += $(videoEmbeddings[i]).prop('outerHTML');
					}
				}
			}
			//
			visibleText = visibleText.replace(/\n/g, "<br>");
			// restoring link and hashtag html
			var tmpVisibleHtml = visibleText;
			tmpVisibleHtml = tmpVisibleHtml.replace(/(^|[^<>])\b((?:https?):\/\/[^<>\s]+\b)/gi, '<a href="$2" target="_blank">$2</a>');
			<?php 
			if(com_is_active('HashTag')) {
			?>
				tmpVisibleHtml = tmpVisibleHtml.replace(/#([^\d]\w+)/gi,'<a class="ossn-hashtag-item" href="' + Ossn.site_url + 'hashtag/$1">#$1</a>');
			<?php
			}
			?>
			var enlargedLengthByTags = tmpVisibleHtml.length - visibleText.length;
			if(allHtml.substring(0, com_readmore_postVisibleChars  + enlargedLengthByTags) == tmpVisibleHtml.substring(0, com_readmore_postVisibleChars + enlargedLengthByTags)) {
				visibleText = tmpVisibleHtml;
			}
			var replacedPost = "<span class='readMoreVideo'>" + visibleText + videoSpans + "</span><span class='readMoreHidden'>" + allHtml + "</span><" + com_readmore_linkPlacement + " class='readMore'  title='" + com_readmore_moreBalloon + "'>" + com_readmore_moreLink + "</" + com_readmore_linkPlacement + "><" + com_readmore_linkPlacement + " class='readLess' title='" + com_readmore_lessBalloon + "'>" + com_readmore_lessLink + "</" + com_readmore_linkPlacement + ">";
			$(this).html(replacedPost);
		} else { // no readmore
			$(this).removeClass('addReadMore showlesscontent showmorecontent');
			// remove style from image if after editing the original textlenght has been shortened below com_readmore_postVisibleChars
			if(!com_readmore_preserveImages) {
				var image = $(this).parent().find('img');
				$(image).removeAttr('style');
				$(image).removeClass('addReadMore readMorePostImage');
			}
		}
	});
}
	
function comReadMoreComment(element) {
	$(element).each(function() {
		if($(this).find(".readMoreHidden").length) {
			return;
		}
		// since comments come with an invisible leading space
		// +/- 1 is added in some places to prevent confusion with regards to chosen settings
		var allText = $(this).text();
		if(allText.length - 1 > com_readmore_commentVisibleChars && allText.length -1 - com_readmore_commentVisibleChars >= com_readmore_commentRemainingChars) {
			if(!$(this).hasClass('addReadMore')) {
				// don't add class again in edit mode
				$(this).addClass('addReadMore showlesscontent');
			}
			var imageClone = '';
			var existingClone = $(this).parent().parent().find('.readMoreCommentImage');
			if($(this).parent().find('img').length && ! $(existingClone).length) {
				// clone original image to append it later at the bottom
				var image = $(this).parent().find('img');
				var imageClone = $(image).clone();
				// mark for later toggling
				$(imageClone).addClass('addReadMore readMoreCommentImage');
				if(!com_readmore_preserveImages) {
					if($(this).hasClass('showmorecontent')) {
						// keep state in edit mode
						$(imageClone).show();
					} else {
						$(imageClone).hide();
					}	
				}
				// and hide original
				$(image).hide();
			}
			var allHtml = $(this).html();
			var visibleText = allText.substring(1, com_readmore_commentVisibleChars + 1);
			visibleText = visibleText.replace(/\n/g, "<br>");
			var tmpVisibleHtml = visibleText;
			tmpVisibleHtml = tmpVisibleHtml.replace(/(^|[^<>])\b((?:https?):\/\/[^<>\s]+\b)/gi, '<a href="$2" target="_blank">$2</a>');
			<?php 
			if(com_is_active('HashTag')) {
			?>
				tmpVisibleHtml = tmpVisibleHtml.replace(/#([^\d]\w+)/gi,'<a class="ossn-hashtag-item" href="' + Ossn.site_url + 'hashtag/$1">#$1</a>');
			<?php
			}
			?>
			var enlargedLengthByTags = tmpVisibleHtml.length - visibleText.length;
			if(allHtml.substring(1, com_readmore_commentVisibleChars + 1 + enlargedLengthByTags) == tmpVisibleHtml.substring(0, com_readmore_commentVisibleChars + 1 + enlargedLengthByTags)) {
				visibleText = tmpVisibleHtml;
			}
			var replacedComment = "<span class='readMoreVideo'>" + visibleText + "</span><span class='readMoreHidden'>" + allHtml + "</span><" + com_readmore_linkPlacement + " class='readMore'  title='" + com_readmore_moreBalloon + "'>" + com_readmore_moreLink + "</" + com_readmore_linkPlacement + "><" + com_readmore_linkPlacement + " class='readLess' title='" + com_readmore_lessBalloon + "'>" + com_readmore_lessLink + "</" + com_readmore_linkPlacement + ">";
			$(this).html(replacedComment);
			$(imageClone).insertAfter($(this).parent());
		} else { // no readmore
			$(this).removeClass('addReadMore showlesscontent showmorecontent');
			if($(this).parent().find('img:hidden').length) {
				// restore original structure: remove clone and unhide original
				var imageClone = $(this).parent().parent().find('.readMoreCommentImage');
				$(imageClone).remove();
				var imageOriginal = $(this).parent().find('img:hidden');
				$(imageOriginal).removeAttr('style');
			}
		}
	});
}

//Calling ReadMore after Page Load and manual pagination
document.addEventListener("DOMContentLoaded", function(){
	comReadMorePost('.post-contents p');
	comReadMoreComment('.comment-text');
	$(document).on("click", ".readMore,.readLess", function() {
		var clicked = $(this).closest(".addReadMore");
		$(clicked).toggleClass("showlesscontent showmorecontent");
		if(!com_readmore_preserveImages) {
			if($(clicked).hasClass('comment-text')) {
				// images in comment
				$(clicked).parent().parent().find('.readMoreCommentImage').toggle();
			} else {
				// images in post
				$(clicked).parent().find('.readMorePostImage').toggle();
			}	
		}

		// extra toggle for colored postings - not used by default
		if($(clicked).is('.postbg-container')) {
			$(clicked).removeClass('postbg-container');
			$(clicked).removeClass('postbg-text');
			$(clicked).addClass('postbg-showlesscontent');
		} else {
			if($(clicked).is('.postbg-showlesscontent')) {
				$(clicked).addClass('postbg-container');
				$(clicked).addClass('postbg-text');
				$(clicked).removeClass('postbg-showlesscontent');
			}
		}
	});
});

$(document).ajaxComplete(function(event, xhr, settings) {
	var substrings = ['?offset='];
	if(substrings.some(substrings=>settings.url.includes(substrings))) {
		//Calling ReadMore on Autopagination
		comReadMorePost('.post-contents p');
		comReadMoreComment('.comment-text');
	}

	if(com_readmore_triggerOnAjaxEdit) {
		substrings = ['/action/wall/post/a', '/action/wall/post/u', '/action/wall/post/g', '/action/wall/post/embed'];
		if (substrings.some(substrings=>settings.url.includes(substrings))) {
			//Calling ReadMore on new created post and after post-edit
			if(xhr.responseText.split('activity-item-').length > 1) {
				var postId = '#activity-item-' + xhr.responseText.split('activity-item-')[1].split('\"')[0].split('\\')[0];
				comReadMorePost(postId + ' .post-contents p');
			}
		}
		substrings = ['/action/post/comment', '/action/post/entity/comment', '/action/comment/embed'];
		if (substrings.some(substrings=>settings.url.includes(substrings))) {
			//Calling ReadMore on new created comment and after comment-edit
			if(xhr.responseText.split('id=\\"').length > 1) {
				var commentId = '#' + xhr.responseText.split('id=\\"')[1].split('\\"')[0];
				comReadMoreComment(commentId + ' .comment-text');
			}
		}
	}
});
