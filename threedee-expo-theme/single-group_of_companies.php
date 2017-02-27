<?php
/**
 * Template for Custom Post Type: Company group
 */
?>

<?php

/**
 * First lets get header "other"
 */
get_header('other');

/**
 * Check if sketchfab there are sketchfab elements available:
 * If true show sketchfab as the first element,
 * if false show youtube section.
 */
if ( ve_sketchfab_empty() == true) {
	ve_get_youtube_section();
	?>
	<script type="application/javascript">
		$(document).ready(function($) {
			$(".youtube-section").css({"padding-top":"76px"});
		});
	</script>
	<?php
}
else {
	ve_get_sketchfab_section();
}

/**
 * Get the information section:
 */
ve_get_information_section();

/**
 * Get linked companies section:
 */

ve_get_linked_companies_section();

/**
 * Check if sketchfab there are sketchfab elements available:
 * If true then don't show youtube here again.
 * if false, show youtube section here.
 */
if ( ve_sketchfab_empty() == true) {
	// do nothing here.
}
else {
	ve_get_youtube_section();
}

/**
 * Get team section:
 */

ve_get_team_section();

/**
 * Get 360 photos section:
 */

ve_get_360_photo_section();

/**
 * Get contact us section:
 */

ve_get_contact_us_section();

/**
 * Get material section:
 */

ve_get_material_section();

/**
 * Get footer section:
 */

get_footer();

?>