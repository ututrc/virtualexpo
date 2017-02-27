<?php
/**
 * Header for Front page:
 */
?>

<?php get_header(); ?>

<?php
	if ( is_user_logged_in() ) {
		if ( wp_is_mobile() ){
			?>
			<div class="full-width header-section-mobile white-bg">
			
			<?php
		}
		else {
			?>
			<div class="full-width header-section white-bg logged-in-content">
			<?php
		}
	}
	else {
		?>
		<div class="full-width header-section white-bg">
		<?php
	}
	?>
		<nav class="navbar navbar-default navbar-fixed-top">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="<?php site_url() ?>">
				<img class="logo-area" src="<?php echo get_template_directory_uri().'/images/logo.png'; ?>">
			</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<?php ve_get_header_navigation() ?>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
	</div>

