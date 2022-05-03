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
ossn_register_languages('de', array(
	'readmore' => 'ReadMore',
	// translation starts below this line - don't translate the line above
    'com:readmore:link:more' => ' ... Mehr anzeigen',
    'com:readmore:link:less' => ' Weniger anzeigen',
    'com:readmore:balloon:more' => 'Hier klicken, um mehr anzuzeigen',
    'com:readmore:balloon:less' => 'Hier klicken, um weniger anzuzeigen',

	'com:readmore:label:link:placement'	=> "Platzierung des Links ' ... Weiterlesen'",
	'com:readmore:option:link:placement:div' => "Link in einer neuen Zeile am Ende des Inhalts anzeigen",
	'com:readmore:option:link:placement:span' => "Link direkt am Ende des Inhalts anzeigen",

	'com:readmore:label:media:handling'	=> 'Verarbeitung eingebetteter Medien',
	'com:readmore:option:preserve:images' => 'Bilder bleiben immer sichtbar',
	'com:readmore:option:preserve:videos' => 'Videos bleiben immer sichtbar',

	'com:readmore:label:ajax:triggering' => 'Verarbeitung neuer und bearbeiteter Inhalte',
	'com:readmore:option:ajax:triggering:true' => 'Readmore sofort nach dem Speichern auslösen',
	'com:readmore:option:ajax:triggering:false' => 'ReadMore erst beim Neuladen Seite auslösen',
	
	'com:readmore:label:post:layout' => 'Post-Einstellungen',
	'com:readmore:option:post:visible:chars' => 'angezeigte Zeichen',
	'com:readmore:option:post:remaining:chars' => 'Minimum an verbleibenden Zeichen',

	'com:readmore:label:comment:layout' => 'Kommentar-Einstellungen',
	'com:readmore:option:comment:visible:chars' => 'angezeigte Zeichen',
	'com:readmore:option:comment:remaining:chars' => 'Minimum an verbleibenden Zeichen',
	
	'com:readmore:label:example' => 'Anwendungsbeispiel',
	'com:readmore:description:example' => 
		"Bei einem Post wie <code>Hello!</code> und <i>angezeigte Zeichen</i> = 4 
		würde <code>Hell</code> angezeigt, während das restliche <code>o!</code> unsichtbar bleibt.
		Daher macht es hier natürlich wenig Sinn, Readmore auszulösen.
		Darum ist <i>Minimum an verbleibenden Zeichen</i> standardmäßig auf mindestens 15 gesetzt,
		so dass es einen deutlich längeren Post wie etwa <code>Hello! How are you?</code> braucht, um Readmore auszulösen.
		Wie zuvor würde wieder <code>Hell</code> angezeight; aber da diesmal der verbleibende Rest <code>o! How are you?</code>
		in der Tat >= 15 ist, wird Readmore in diesem Fall ausgelöst.<br>
		Kurz: Je größer <i>Minimum an verbleibenden Zeichen</i> ist,
		desto später wird Readmore ausgelöst.",
));