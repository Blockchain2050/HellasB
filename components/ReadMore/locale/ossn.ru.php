<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
ossn_register_languages('ru', array(
	'readmore' => 'ReadMore',
	// translation starts below this line - don't translate the line above
    'com:readmore:link:more' => ' ... Read More',
    'com:readmore:link:less' => ' Read Less',
    'com:readmore:balloon:more' => 'Click to Show More',
    'com:readmore:balloon:less' => 'Click to Show Less',

	'com:readmore:label:link:placement'	=> "Placement of the ' ... Read more ' link",
	'com:readmore:option:link:placement:div' => "display link on a new line at the bottom of the content",
	'com:readmore:option:link:placement:span' => "display link inline at the end of the content",

	'com:readmore:label:media:handling'	=> 'Processing of embedded media',
	'com:readmore:option:preserve:images' => 'preserve images from collapsing',
	'com:readmore:option:preserve:videos' => 'preserve videos from collapsing',

	'com:readmore:label:ajax:triggering' => 'Processing of new and edited content',
	'com:readmore:option:ajax:triggering:true' => 'trigger Readmore immediately after saving',
	'com:readmore:option:ajax:triggering:false' => 'keep content uncollapsed until next page reload',
	
	'com:readmore:label:post:layout' => 'Post settings',
	'com:readmore:option:post:visible:chars' => 'uncollapsed visible characters',
	'com:readmore:option:post:remaining:chars' => 'minimum remaining characters',

	'com:readmore:label:comment:layout' => 'Comment settings',
	'com:readmore:option:comment:visible:chars' => 'uncollapsed visible characters',
	'com:readmore:option:comment:remaining:chars' => 'minimum remaining characters',
	
	'com:readmore:label:example' => 'Example of usage',
	'com:readmore:description:example' => 
		"With a post like <code>Hello!</code> and <i>uncollapsed visible characters</i> set to 4 
		<code>Hell</code> would be visible while the remaining <code>o!</code> is hidden.
		Hence, it doesn't make much sense to trigger Readmore here at all, right?.
		That's why <i>minimum remaining characters</i> is set to at least 15 by default,
		so triggering Readmore would need a longer post like <code>Hello! How are you?</code>.
		Again <code>Hell</code> would be visible, but this time the remaining invisible part <code>o! How are you?</code>
		is in fact >= 15 and Readmore will do its job.<br>
		In short: The larger the value of <i>minimum remaining characters</i>,
		the later Readmore gets triggered.",
));