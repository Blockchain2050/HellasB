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
global $Ossn;
$ossnmenu = new OssnMenu;
$ossnmenu->sortMenu('footer');
$menus = $Ossn->menu['footer'];
array_shift($menus);
array_pop($menus);
foreach($menus as $menu) {
		foreach($menu as $link) {
				$class = "menu-footer-" . $link['name'];
				if(isset($link['class'])) {
						$link['class'] = $class . ' ' . $link['class'];
				} else {
						$link['class'] = $class;
				}
				unset($link['name']);
				echo ossn_plugin_view('output/url', $link);
		}
}
