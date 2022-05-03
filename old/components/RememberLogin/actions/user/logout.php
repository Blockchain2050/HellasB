<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

if (isset($_COOKIE['rl_uma'])) {
    unset($_COOKIE['rl_uma']);
	setcookie('rl_uma', '', time() - 3600, '/');
}
if (isset($_COOKIE['rl_vfp'])) {
	unset($_COOKIE['rl_vfp']);
	setcookie('rl_vfp', '', time() - 3600, '/');
}
ossn_logout();
redirect();	
