<?php

/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
?>
<script>
	$(document).ready(function() {
		$('footer').find('.col-md-11').addClass('col-md-12').removeClass('col-md-11');
	});
</script>
<div class="row ossn-page-contents">
	<div class="col-md-6 home-left-contents">
		<div class="description">
			<?php echo ossn_print('home:top:heading', array(ossn_site_settings('site_name'))); ?>
		</div><br />
		<img src="<?php echo ossn_theme_url(); ?>images/users.png" />
		<p style="color:black;font-weight:600; margin-top:10px">To HellasB είναι το πρώτο μέσο κοινωνικής δικτύωσης στον κόσμο που προσφέρει στους χρήστες του,
		απόλυτη προστασία από την συλλογή των προσωπικών τους στοιχείων για οποιαδήποτε χρήση, συμπεριλαμβανομένης και της κατευθυνόμενης διαφημιστικής προβολής οποιουδήποτε,
		ενώ ταυτόχρονα θα επιβραβεύει τους χρήστες του για τον χρόνο που δαπανούν σε αυτό επικοινωνώντας ελεύθερα, αλλά εντός των όρων της κοινότητας,
		με άλλους χρήστες και τις διαφημιζόμενες σε αυτό εταιρίες.</p>
		<p style="color:black;font-weight:600;">Το HellasB, ως μέσο κοινωνικής δικτύωσης νέας γενιάς,
		ενσωματώνει και θα ενσωματώνει συνεχώς όλες τις σύγχρονες τεχνολογίες που είναι διαθέσιμες για την επίτευξη του πιο πάνω στόχου μέσα από απόλυτα διαφανείς σχέσεις ανάμεσα σε όλους τους εμπλεκόμενους σε αυτό.</p>
	</div>
	<div class="col-md-6">
		<?php
		$contents = ossn_view_form('signup', array(
			'id' => 'ossn-home-signup',
			'action' => ossn_site_url('action/user/register')
		));
		$heading = "<p>" . ossn_print('its:free') . "</p>";
		echo ossn_plugin_view('widget/view', array(
			'title' => ossn_print('create:account'),
			'contents' => $heading . $contents,
		));
		?>
		<div style="position:relative;right:0;" class="container">
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Language Option
					<span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li><a href="#">Ελληνικά</a></li>
					<li><a href="#">English</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>