<?php
if (ossn_isLoggedin()) {
	$hide_loggedin = "hidden-xs hidden-sm";
}
?>
<!-- ossn topbar -->
<div class="topbar">
	<div class="container">
		<div class="row">
			<div class="col-md-5 col-xs-6 left-side left">
				<?php if (ossn_isLoggedin()) { ?>
					<div class="topbar-menu-left site-name">
					<a  href="https://hellasb.com/home">
					<img style="width:40px;height:40px;" src="<?php echo ossn_theme_url();?>images/hlogo.png" />
					</a>
						<?php echo ossn_view_form('search', array(
							'component' => 'OssnSearch',
							'class' => 'ossn-search',
							'autocomplete' => 'off',
							'method' => 'get',
							'security_tokens' => false,
							'action' => ossn_site_url("search"),
						), false);
						?>
						<div style="display: flex; flex-direction:row;justify-content:center;align-items:center;margin-left: 6%;">
							<div>Πόντοι:</div><fieldset class="points"  class="homelink">
									<?php ossn_call_hook('points','points') ?> 
									</fieldset>
							</div>
					</div>
				<?php } ?>
			</div>
			<div class="col-md-4 col-xs-6">
				<div class="topbar-userdata">
					<img src="<?php echo ossn_loggedin_user()->iconURL()->smaller; ?>" />
					<a style="color:white;" href="<?php echo ossn_loggedin_user()->profileURL(); ?>"><span class="name"><?php echo ossn_loggedin_user()->fullname; ?></span></a>
					<span class="homelink"><a href="<?php echo ossn_site_url(); ?>home"><?php echo ossn_print('home'); ?></a></span>
				</div>
				<div style="display:flex;flex-direction:row;
								justify-content:center;
								align-items:center;
								margin-top: 3.5%;
								font-weight: 600;">
				
				</div>
				
			</div>
			<div class="col-md-3 col-xs-6 text-right right-side">
				<div class="topbar-menu-right">

					<li class="ossn-topbar-dropdown-menu">
						<div class="dropdown">
							<?php
							if (ossn_isLoggedin()) {
								echo ossn_plugin_view('output/url', array(
									'role' => 'button',
									'data-toggle' => 'dropdown',
									'data-target' => '#',
									'text' => '<i class="fa fa-sort-desc"></i>',
								));
								echo ossn_view_menu('topbar_dropdown');
							}
							?>
						</div>
					</li>
					<?php
					if (ossn_isLoggedin()) {
						echo ossn_plugin_view('notifications/page/topbar');
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- added this div to make navbar stay top without hide other elements -->
<div class="my-fix-topbar-class"></div>
<!-- ./ ossn topbar -->