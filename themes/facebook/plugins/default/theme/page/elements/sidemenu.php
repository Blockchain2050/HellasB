<div style="display:flex; flex-direction:row;">
	<div id="sidebar-button">
		<button class="openbtn" onclick="openNav()">☰ Επιλογές</button>
	</div>
	<div id="mySidebar" class="sidemenu">


		<?php
		if (ossn_is_hook('newsfeed', "sidebar:left")) {
			echo '<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>';
			$newsfeed_left = ossn_call_hook('newsfeed', "sidebar:left", NULL, array());
			echo implode('', $newsfeed_left);
		}
		?>
	</div>
</div>