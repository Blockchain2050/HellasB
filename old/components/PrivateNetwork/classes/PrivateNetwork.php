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
class PrivateNetwork {
		private function allowed_Pages($part) {
				$pages = ossn_call_hook('private:network', 'allowed:pages', false, array(
						// *1* OSSN allowed core pages
						// only first part of url will be checked
						array(
							'css',
							'js',
							'action',
							'administrator',
							'uservalidate',
							'resetlogin',
							'index',
							'login',
							'api',
							'avatar',
							'userverified',
							'two_factor_login',
							'captcha',
							'sharedblogs',
							'contact',
						),
						// *2* be more specific: 'part1/part2' of url must match
						// make sure part1 is not listed in the array above!
						// in this example the footer links 'About' and 'Terms' are shown, while 'Privacy' needs logging in
						array(
							'notification/count',
							'messages/getnew',
							'site/about',
							'site/terms',
							//'site/privacy',			// remove the 2 slashes in the beginning of this line to allow the 'Privacy' Page
							//'u/botox',				// allow this member's profile page
						),
						// *3* be even more specific: 'part1/part2/part3' of url must match
						// make sure part1 and part 2 are not listed in the arrays above!
						array(
							'ossnchat/boot/ossn.boot.chat.js',
							//'p/438/public',			// example custom page
							//'post/view/432',			// one special post to be shared
							//
							// here is an experiment with specific albums and photos
							// but things are getting really tricky here
							// because unfortunately there's no straight logic in Ossn links
							//
							// with 'u/botox' above I do reach /u/botox/photos
							// but her profile album isn't 'u/botox/photos/album/profile-photos
							// but 'album/profile/2', so I would also need to add it here
							//'album/profile/2',
							// then it would need a
							//'album/getphoto/2',
						),
						// *4* add more pages to allow with url like 'part1/part2/part3/part4'
						array(
							// and finally a
							//'photos/user/view/18',
							// theoretically working, but who would like to mess around with stuff like that?! :)
						),
						// *5* add more pages to allow with url like 'part1/part2/part3/part4/part5'
						array(
						)
				));
				return $pages[$part];
		}

		/**
		 * Deny for visiting page
		 *
		 * @param null
		 * 
		 * @return void
		 */
		private function deney($restricted_url) {
				// store visited page for next login
				setcookie('ossn_restricted_url_visited', $restricted_url, time() + (60 * 2), "/");  // 2 minutes
				ossn_trigger_message(ossn_print('com:private:network:deney', array($restricted_url)), 'error');
				redirect();
		}
		
		/**
		 * Start the PrivateNetwork Process
		 *
		 * @param null
		 * 
		 * @return array
		 */
		public function start($params) { 
				if($params && !empty($params['handler'])) {
						$visited_url = $params['handler'] . '/' . implode("/", $params['page']);
						for($i = count($params['page']); $i >= 0; $i--) {
							// assemble handler and pages array to url like h/p0/p1/....
							$url = $params['handler'] . '/' . implode("/", $params['page']);
							if(in_array($params['handler'], $this->allowed_Pages(0)) || in_array($url, $this->allowed_Pages($i))) {
								// to keep things fast, ignore complete url first, and check if handler is already matching (old logic)
								// if not, try to find complete url in corresponding array
								// yes, matching entry found!
								return;
							}
							// no, drop rightmost part of url and continue
							// this way we can keep the old 'wildcard' logic with any number of url elements
							array_pop($params['page']);
						}
						$this->deney($visited_url);
				}
		}
}