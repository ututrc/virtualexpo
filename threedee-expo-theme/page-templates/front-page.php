<?php
/**
 * Template Name: Front Page
 */
?>

<?php get_header('front-page'); ?>

<?php ve_get_sketchfab_section(); ?>

<?php ve_get_information_section(); ?>

<div class="full-width padded-top-bottom grey-bg" id="front-page-companies">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center padded-bottom black-text">
				<span class="section-title-text" id="front-page-companies-title-text">
					<?php echo __('Companies', 'threedee-expo') ?>
				</span>
			</div>
			<div class="col-lg-12">
				<?php get_companies_or_group_of_companies('companies'); ?>
			</div>
		</div>
	</div>
</div>

<div class="full-width padded-top-bottom" id="front-page-group-of-companies">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center padded-bottom">
				<span class="section-title-text" id="front-page-group-of-companies-title-text">
					<?php echo __('Group of Companies', 'threedee-expo') ?>
				</span>
			</div>
			<div class="col-lg-12">
				<?php get_companies_or_group_of_companies('group_of_companies'); ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
