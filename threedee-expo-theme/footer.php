<?php
/**
 * Footer:
 */
if ( is_singular( 'group_of_companies' ) ) {
	$background_color = "#efefef";
	$home_bar_background_color = "#efefef";
	if (get_field('footer_background_color')) {
		$background_color = get_field('footer_background_color');
	}
	if (get_field('footer_home_bar_background_color')) {
		$home_bar_background_color = get_field('footer_home_bar_background_color');
	}
}
?>

<div class="footer black-bg" style="background-color: <?php echo $background_color; ?>">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-3 col-md-3 contact-area">
				<?php get_footer_address(); ?>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-3 phone-area">
				<?php get_footer_phone_number(); ?>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-3 www-area">
				<?php get_footer_www_address(); ?>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-3 grey-footer-bg align-right company-footer-text" style="background-color: <?php echo $home_bar_background_color; ?>">
				<a class="home-link" href="<?php echo get_home_url();?>">
					<img src="<?php echo get_template_directory_uri().'/images/icon_home.png'; ?>" class="footer-icon">
					<br>
					<span class="white-text expo-text"><?php echo __('Virtual Expo', 'three-dee-expo') ?></span>
				</a>
			</div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>