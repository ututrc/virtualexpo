<?php
/**
 * Functions for threedee-expo-theme:
 * Plugins required to use this theme properly:
 * - Advanced Custom Fields Pro (Version 5.3.6.1)
 * - Advanced Custom Fields: Image Crop Add-on (Version 1.4.7)
 * - PDF Image Generator (Version 1.3.9) (Requires ImageMagick from server-side)
 * - User Role Editor (Version 4.24)
 */

/**
 * ######################## Table of index:
 * 1 Basic functions
 *      1.1 Register scripts
 *      1.2 Register custom post types
 *      1.3 Register custom taxonomies
 *      1.4 Remove unnecessary columns from pages
 *      1.5 User role based styles
 *      1.6 User role based restrictions
 *      1.7 Go to home page when logout
 *      1.8 Remove unnecessary admin bar nodes
 *      1.9 Remove TinyMCE Editor
 * 2 shared functions
 *      2.1 Shared functions - Get footer address:
 *      2.2 Shared functions - Get footer phone number:
 *      2.3 Shared functions - Get footer www address:
 *      2.4 Shared functions - Check if information section is empty:
 *      2.5 Shared functions - About Us Text:
 *      2.6 Shared functions - Our Business Text:
 *      2.7 Shared functions - Mission Text:
 *      2.8 Shared functions - Youtube videos:
 *      2.9 Shared functions - Pictures & PDF:
 *      2.10 Shared functions - Title text:
 *      2.11 Shared functions - Slogan text:
 *      2.12 Shared functions -  Sketchfab elements:
 *      2.13 Shared functions -  Team members:
 *      2.14 Shared functions -  Make team member html card:
 *      2.15 Shared functions -  contact form:
 *      2.16 Shared functions - load contact form:
 *      2.17 Shared functions - Ajax contact form:
 * 3 Front Page functions:
 *      3.1 Front page functions - Get random sketchfab (from companies) to front page showcase:
 *      3.2 Front page functions - Get Companies or Group of companies:
 * 4 Group of Companies
 *      4.1 Group of Companies - Add companies meta box to admin side:
 *      4.2 Group of Companies - Load companies to the meta box:
 *      4.3 Group of Companies - Save meta box data to the post:
 *      4.4 Group of Companies - Get Companies that are linked to group of company:
 * 5 Virtual expo (new functions replacing some old functions)
 *      5.1 Virtual Expo - Get header section other:
 *      5.2 Virtual Expo - Is sketchfab available?
 *      5.3 Virtual Expo - Get Sketchfab section:
 *      5.4 Virtual Expo - Get Information Section:
 *      5.5 Virtual Expo - Get companies section (group of companies / partnership page):
 *      5.6 Virtual Expo - Get youtube section:
 *      5.7 Virtual Expo - Get team members:
 *      5.8 Virtual Expo - Get contact us section:
 *      5.9 Virtual Expo - Get material section:
 *      5.10 Virtual Expo - Get 360 photo section:
 *      5.11 Virtual Expo - Get 360 photos:
 * 6 New Layout
 *      6.1 New Layout - Get logo to header section:
 *      6.2 New Layout - Get navigation to header section:
 *      6.3 New Layout - Generate sub-navigation section to companies section:
 *      6.4 New Layout - Generate sub-navigation section to group of companies (partnership) section:
 *      6.5 New Layout - company or group-of-companies title in front of the information section title
 */

/**
 * ######################## 1 Basic functions:
 */

/**
 * ######################## 1.1 Register scripts:
 */

function threedee_expo_scripts(){
	if (!is_admin()){
		wp_deregister_script( 'jquery' );
		wp_register_script('jquery', get_template_directory_uri(). '/includes/jquery/jquery-1.11.3.min.js', false, '1.11.3');
		wp_enqueue_script('jquery');
	}
	else{
		//don't replace jquery
	}

	/**
	 * Load stylesheet
	 */
	wp_enqueue_style( 'threedee-expo-style', get_stylesheet_uri() );
	/**
	 * Load Bootstrap CSS & js:
	 */
	wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/includes/bootstrap/css/bootstrap.min.css');
	wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/includes/bootstrap/js/bootstrap.min.js');
	/**
	 * Load Owl Carousel:
	 */
	// load owl carousel js
	wp_enqueue_script('owl-carousel-js', get_template_directory_uri().'/includes/owl-carousel/owl.carousel.js', array('jquery') );
	// load owl carousel css
	wp_enqueue_style( 'owl-carousel-css', get_template_directory_uri() . '/includes/owl-carousel/owl.carousel.css' );
	// load owl carousel theme css
	wp_enqueue_style( 'owl-carousel-css-theme', get_template_directory_uri() . '/includes/owl-carousel/owl.theme.css' );
	/**
	 * Load isotope js:
	 */
	wp_enqueue_script('isotope-js', get_template_directory_uri().'/includes/isotope/isotope.js', array('jquery') );
	/**
	 * Load Sketchfab js:
	 */
	wp_enqueue_script('sketchfab-js', get_template_directory_uri().'/includes/sketchfab/sketchfab-viewer-1.0.0.js', array('jquery') );
	/**
	 * Load main JS file:
	 */
	wp_enqueue_script('main-js', get_template_directory_uri().'/js/main.js', array('jquery') );
	/**
	 * Load bixtext JS file:
	 */
	wp_enqueue_script('bigtext-js', get_template_directory_uri().'/js/bigtext.js', array('jquery'));
}
add_action( 'wp_enqueue_scripts', 'threedee_expo_scripts' );

/**
 * ######################## 1.2 Register scripts and styles to admin:
 */

function register_scripts_admin() {
	wp_enqueue_style('font-awesome', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');
}

add_action( 'admin_enqueue_scripts', 'register_scripts_admin' );

/**
 * ######################## 1.2 Register custom post types:
 */

function create_custom_post_types(){
	/**
	 * Arguments for company labels
	 */
	$args_labels_company = array(
		'name'              =>  __('Companies', 'threedee-expo'),
		'singular_name'     =>  __('Company', 'threedee-expo'),
		'add_new_item'      =>  __('Add New Company', 'threedee-expo'),
		'edit_item'         =>  __('Edit Company', 'threedee-expo'),
		'new_item'          =>  __('New Company', 'threedee-expo'),
		'view_item'         =>  __('View Company', 'threedee-expo'),
		'search_items'      =>  __('Search Companies', 'threedee-expo'),
		'not_found'         =>  __('No companies found', 'threedee-expo'),
		'not_found_in_trash'=>  __('No companies found in Trash', 'threedee-expo'),
		'all_items'         =>  __('All Companies', 'threedee-expo'),
		'archives'          =>  __('Company Archives', 'threedee-expo'),
	);
	/**
	 * Arguments for company capabilities
	 */
	$args_capabilities_company = array(
		'publish_posts'         => 'publish_companies',
		'edit_posts'            => 'edit_companies',
		'edit_others_posts'     => 'edit_others_companies',
		'delete_posts'          => 'delete_companies',
		'delete_others_posts'   => 'delete_others_companies',
		'read_private_posts'    => 'read_private_companies',
		'edit_post'             => 'edit_company',
		'delete_post'           => 'delete_company',
		'read_post'             => 'read_company',
	);
	/**
	 * Arguments for register companies
	 */
	$args_company = array(
		'labels'            =>  $args_labels_company,
		'description'       =>  'Companies.',
		'public'            =>  true,
		'has_archive'       =>  true,
		'rewrite'	        =>  array('slug' => 'company'),
		'menu_icon'         =>  'dashicons-businessman',
		'capability_type'   =>  'companies',
		'capabilities'      =>  $args_capabilities_company,
		'map_meta_cap'      =>  true,
		'supports'          =>  array('author','title')
	);
	/**
	 * Arguments for company labels
	 */
	$args_labels_group_of_companies = array(
		'name'              =>  __('Group of Companies', 'threedee-expo'),
		'singular_name'     =>  __('Group of Company', 'threedee-expo'),
		'add_new_item'      =>  __('Add New Group of Companies', 'threedee-expo'),
		'edit_item'         =>  __('Edit Group of Companies', 'threedee-expo'),
		'new_item'          =>  __('New Group of Companies', 'threedee-expo'),
		'view_item'         =>  __('View Group of Companies', 'threedee-expo'),
		'search_items'      =>  __('Search Group of Companies', 'threedee-expo'),
		'not_found'         =>  __('No Group of Companies found', 'threedee-expo'),
		'not_found_in_trash'=>  __('No Group of Companies found in Trash', 'threedee-expo'),
		'all_items'         =>  __('All Group of Companies', 'threedee-expo'),
		'archives'          =>  __('Group of Companies Archives', 'threedee-expo'),
	);
	/**
	 * Arguments for company capabilities
	 */
	$args_capabilities_group_of_companies = array(
		'publish_posts'         => 'publish_group_of_companies',
		'edit_posts'            => 'edit_group_of_companies',
		'edit_others_posts'     => 'edit_others_group_of_companies',
		'delete_posts'          => 'delete_group_of_companies',
		'delete_others_posts'   => 'delete_others_group_of_companies',
		'read_private_posts'    => 'read_private_group_of_companies',
		'edit_post'             => 'edit_group_of_company',
		'delete_post'           => 'delete_group_of_company',
		'read_post'             => 'read_group_of_company',
	);
	/**
	 * Arguments for register companies
	 */
	$args_group_of_companies = array(
		'labels'            =>  $args_labels_group_of_companies,
		'description'       =>  'Group of Companies.',
		'public'            =>  true,
		'has_archive'       =>  true,
		'rewrite'	        =>  array('slug' => 'group_of_companies'),
		'menu_icon'         =>  'dashicons-groups',
		'capability_type'   =>  'group_of_companies',
		'capabilities'      =>  $args_capabilities_group_of_companies,
		'map_meta_cap'      =>  true,
		'supports'          =>  array('author','title')
	);
	register_post_type( 'companies', $args_company);
	register_post_type( 'group_of_companies',$args_group_of_companies);
}
add_action( 'init', 'create_custom_post_types' );

/**
 * ######################## 1.3 Register custom taxonomies:
 */

function register_company_categories_taxonomy() {
	register_taxonomy(
		'company_category',
		'companies',
		array(
			'label' => __( 'Company Category' ),
			'rewrite' => false,
			'hierarchical'	=> true
		)
	);
}
add_action( 'init', 'register_company_categories_taxonomy' );

/**
 * ######################## 1.4 Remove unnecessary columns from PAGES:
 */

function custom_columns( $columns ){
	if (current_user_can('administrator')) {
		// Remove 'Comments' Column
		unset($columns['comments']);
	}
	else {
		// Remove 'Comments' Column
		unset($columns['comments']);
		unset($columns['author']);
	}
	return $columns;
}
add_filter( 'manage_pages_columns', 'custom_columns' );
add_filter( 'manage_edit-companies_columns', 'custom_columns' );
add_filter( 'manage_edit-group_of_companies_columns', 'custom_columns' );

/**
 * ######################## 1.5 User role based styles:
 */

function user_role_admin_styles(){
	/**
	 * Admin:
	 */
	if (current_user_can('administrator')){
		// load admin-admin-style.css
		wp_enqueue_style( 'editor-style', get_template_directory_uri() . '/css/admin-admin-style.css' );
		// Remove posts and comments from admin menu:
		remove_menu_page( 'edit.php' );                   //Posts
		remove_menu_page( 'edit-comments.php' );          //Comments
	}
	/**
	 * NOT Admin:
	 */
	else {
		remove_menu_page( 'index.php' );                  //Dashboard
		remove_menu_page( 'upload.php' );                 //Media
		/**
		 * Load Editor style
		 */
		wp_enqueue_style( 'editor-style', get_template_directory_uri() . '/css/editor-admin-style.css' );
	}
}
add_action( 'admin_menu', 'user_role_admin_styles' );

/**
 * ######################## 1.6 User role based restrictions:
 */
function restrict_admin_with_redirect() {

	$restrictions = array(
		'/wp-admin/widgets.php',
		'/wp-admin/widgets.php',
		'/wp-admin/user-new.php',
		'/wp-admin/upgrade-functions.php',
		'/wp-admin/upgrade.php',
		'/wp-admin/themes.php',
		'/wp-admin/theme-install.php',
		'/wp-admin/theme-editor.php',
		'/wp-admin/setup-config.php',
		'/wp-admin/plugins.php',
		'/wp-admin/plugin-install.php',
		'/wp-admin/options-writing.php',
		'/wp-admin/options-reading.php',
		'/wp-admin/options-privacy.php',
		'/wp-admin/options-permalink.php',
		'/wp-admin/options-media.php',
		'/wp-admin/options-head.php',
		'/wp-admin/options-general.php.php',
		'/wp-admin/options-discussion.php',
		'/wp-admin/options.php',
		'/wp-admin/network.php',
		'/wp-admin/ms-users.php',
		'/wp-admin/ms-upgrade-network.php',
		'/wp-admin/ms-themes.php',
		'/wp-admin/ms-sites.php',
		'/wp-admin/ms-options.php',
		'/wp-admin/ms-edit.php',
		'/wp-admin/ms-delete-site.php',
		'/wp-admin/ms-admin.php',
		'/wp-admin/moderation.php',
		'/wp-admin/menu-header.php',
		'/wp-admin/menu.php',
		'/wp-admin/edit-tags.php',
		'/wp-admin/edit-tag-form.php',
		'/wp-admin/edit-link-form.php',
		'/wp-admin/edit-comments.php',
		'/wp-admin/credits.php',
		'/wp-admin/about.php',
	);

	foreach ( $restrictions as $restriction ) {
		/**
		 * If user is NOT Admin, then redirect all the above to company edit page:
		 */
		if ( ! current_user_can( 'manage_options' ) && $_SERVER['PHP_SELF'] == $restriction ) {
			if (!current_user_can('companies')) {
				wp_redirect( 'edit.php?post_type=companies' );
			}
			if (!current_user_can('group_of_companies')) {
				wp_redirect( 'edit.php?post_type=group_of_companies' );
			}
			exit;
		}
	}
	/**
	 * If user is NOT Admin, then don't show the dashboard page, instead go STRAIGHT to news edit page
	 */
	if ( !current_user_can( 'manage_options' ) && preg_match( '#wp-admin/?(index.php)?$#', $_SERVER[ 'REQUEST_URI' ] ) ) {
		if (current_user_can( 'group_of_companies')){
			wp_redirect( 'edit.php?post_type=group_of_companies' );
			exit;
		}
		else {
			wp_redirect( 'edit.php?post_type=companies' );
			exit;
		}
	}
}
add_action( 'admin_init', 'restrict_admin_with_redirect' );

/**
 * ######################## 1.7 Go to home page when logout:
 */

function go_home(){
	wp_redirect( home_url() );
	exit();
}
add_action('wp_logout','go_home');

/**
 * ######################## 1.8 Remove unnecessary admin bar nodes:
 */

function remove_wp_nodes( $wp_admin_bar ) {
	if (current_user_can('administrator')){
		$wp_admin_bar->remove_node( 'comments' );
		$wp_admin_bar->remove_node( 'new-post' );
		$wp_admin_bar->remove_node( 'new-link' );
		$wp_admin_bar->remove_node( 'new-media' );
	}
	else {
		$wp_admin_bar->remove_node( 'wp-logo' );
		$wp_admin_bar->remove_node( 'comments' );
		$wp_admin_bar->remove_node( 'dashboard' );
		$wp_admin_bar->remove_node( 'search' );
		$wp_admin_bar->remove_node( 'view-site' );
		$wp_admin_bar->remove_node( 'new-post' );
		$wp_admin_bar->remove_node( 'new-page' );
		$wp_admin_bar->remove_node( 'new-link' );
		$wp_admin_bar->remove_node( 'new-media' );
	}
}
add_action( 'admin_bar_menu', 'remove_wp_nodes', 999 );

/**
 * ######################## 1.9 Remove TinyMCE Editor:
 */

function my_remove_post_type_support()
{
	remove_post_type_support('page', 'editor');
	remove_post_type_support('post', 'editor');
	remove_post_type_support('companies', 'editor');
	remove_post_type_support('group_of_companies', 'editor');
}
add_action('init', 'my_remove_post_type_support', 10);

/**
 * ######################## 2 Shared functions:
 */

/**
 * ######################## 2.1 Shared functions - Get footer address:
 */

function get_footer_address() {
	$street_address = '';
	$city = '';
	$postal_code = '';
	$country = '';
	/**
	 * Check if we are in front-page:
	 */
	if (is_page_template('page-templates/front-page.php')){
		if ( get_field('front_page_contact_street_address') )
			$street_address = get_field('front_page_contact_street_address');
		if ( get_field('front_page_contact_city') )
			$city = get_field('front_page_contact_city');
		if ( get_field('front_page_contact_postal_code') )
			$postal_code = get_field('front_page_contact_postal_code');
		if ( get_field('front_page_contact_country') )
			$country = get_field('front_page_contact_country');
	}
	/**
	 * If NOT in front-page:
	 */
	else {
		/**
		 * Check if we are in companies page:
		 */
		if (is_singular('companies')) {
			if ( get_field('company_contact_street_address') )
				$street_address = get_field('company_contact_street_address');
			if ( get_field('company_contact_city') )
				$city = get_field('company_contact_city');
			if ( get_field('company_contact_postal_code') )
				$postal_code = get_field('company_contact_postal_code');
			if ( get_field('company_contact_country') )
				$country = get_field('company_contact_country');
		}
		/**
		 * Check if we are in group of companies page:
		 */
		if (is_singular('group_of_companies')) {
			if ( get_field('group_of_companies_contact_street_address') )
				$street_address = get_field('group_of_companies_contact_street_address');
			if ( get_field('group_of_companies_contact_city') )
				$city = get_field('group_of_companies_contact_city');
			if ( get_field('group_of_companies_contact_postal_code') )
				$postal_code = get_field('group_of_companies_contact_postal_code');
			if ( get_field('group_of_companies_contact_country') )
				$country = get_field('group_of_companies_contact_country');
		}
	}
	if ($street_address == '' && $city == '' && $postal_code == '' && $country == '') {
		/**
		 * Don't show the red marker for address.
		 */
	}
	else {
		/**
		 * Generate google_maps_url:
		 */
		$google_maps_url = 'http://maps.google.com/?q='.$street_address.','.$city.','.$postal_code;
		?>
		<a href="<?php echo $google_maps_url; ?>" class="contact-link" target="_blank">
			<img src="<?php echo get_template_directory_uri().'/images/icon_address.png'; ?>" class="footer-icon">
			<br>
			<span class="contact-street-address"><?php echo $street_address; ?></span>
			<span class="contact-postal-code-and-city"><?php echo $postal_code; ?> <?php echo $city; ?></span>
			<span class="contact-country"><?php echo $country; ?></span>
		</a>
		<?php
	}
}

/**
 * ######################## 2.2 Shared functions - Get footer phone number:
 */

function get_footer_phone_number() {
	$contact_person = '';
	$phone_number = '';
	/**
	 * Check if we are in front-page:
	 */
	if (is_page_template('page-templates/front-page.php')){
		if ( get_field('front_page_contact_person') )
			$contact_person = get_field('front_page_contact_person');
		if ( get_field('front_page_contact_phone_number') )
			$phone_number = get_field('front_page_contact_phone_number');
	}
	/**
	 * If NOT in front-page:
	 */
	else {
		/**
		 * Check if we are in companies page:
		 */
		if (is_singular('companies')) {
			if ( get_field('company_contact_phone_number') )
				$phone_number = get_field('company_contact_phone_number');
		}
		/**
		 * Check if we are in group of companies page:
		 */
		if (is_singular('group_of_companies')) {
			if ( get_field('group_of_companies_contact_phone_number') )
				$phone_number = get_field('group_of_companies_contact_phone_number');
		}
	}
	if ($contact_person == '' && $phone_number == '') {
		/**
		 * Don't show the green phone icon
		 */
	}
	else {
		?>
		<img src="<?php echo get_template_directory_uri().'/images/icon_phone.png'; ?>" class="footer-icon">
		<br>
		<span class="contact-person"><?php echo $contact_person; ?></span>
		<span class="contact-phone-number"><?php echo $phone_number; ?></span>
		<?php
	}
}

/**
 * ######################## 2.3 Shared functions - Get footer www address:
 */

function get_footer_www_address() {
	$url = '';
	/**
	 * Check if we are in front-page:
	 */
	if (is_page_template('page-templates/front-page.php')){
		// Don't show www address on front page
	}
	/**
	 * If NOT in front-page:
	 */
	else {
		/**
		 * Check if we are in companies page:
		 */
		if (is_singular('companies')) {
			if ( get_field('company_contact_url') ) {
				$url = get_field('company_contact_url');
			}
		}
		/**
		 * Check if we are in group of companies page:
		 */
		if (is_singular('group_of_companies')) {
			if ( get_field('group_of_companies_contact_url') ) {
				$url = get_field('group_of_companies_contact_url');
			}
		}
	}
	if ($url == '') {
		/**
		 * Don't show the visit website text and desktop icon
		 */
	}
	else {
		?>
		<a href="<?php echo $url; ?>" class="home-url-link">
			<img src="<?php echo get_template_directory_uri().'/images/icon_website.png'; ?>" class="footer-icon">
			<br>
			<span class="contact-url"><?php echo __('Visit Website', 'threedee_expo') ?></span>
		</a>
		<?php
	}

}

/**
 * ######################## 2.4 Shared functions - Check if information section is empty:
 */

function ve_information_section_is_empty() {
	/**
	 * Flag that is used to determine if there is content on some of the information fields
	 */
	$empty_flag = false;
	/**
	 * Check if we are in front-page:
	 */
	if (is_page_template('page-templates/front-page.php')){
		if ( get_field('front_page_about_us') ) {
			$empty_flag = true;
		}
		if ( get_field('front_page_mission') ) {
			$empty_flag = true;
		}
		return $empty_flag;
	}
	/**
	 * If NOT in front-page:
	 */
	else {
		/**
		 * Check if we are in companies page:
		 */
		if (is_singular('companies')) {
			if ( get_field('company_about_us') ) {
				$empty_flag = true;
			}
			if ( get_field('company_mission') ) {
				$empty_flag = true;
			}
			if ( get_field('company_our_business') ) {
				$empty_flag = true;
			}
			return $empty_flag;
		}
		/**
		 * Check if we are in group of companies page:
		 */
		if (is_singular('group_of_companies')) {
			if ( get_field('group_of_companies_about_us') ) {
				$empty_flag = true;
			}
			if ( get_field('group_of_companies_mission') ) {
				$empty_flag = true;
			}
			if ( get_field('group_of_companies_our_business') ) {
				$empty_flag = true;
			}
			return $empty_flag;
		}
	}
}

/**
 * ######################## 2.5 Shared functions - About Us Text:
 */

function get_about_us_text() {
	/**
	 * Check if we are in front-page:
	 */
	if (is_page_template('page-templates/front-page.php')){
		if ( get_field('front_page_about_us') ) {
			echo wpautop(get_field('front_page_about_us'));
		}
		else {
			?>
			<script type="application/javascript">
				jQuery(document).ready(function($) {
					$(".about-us-title").addClass("display-none-class");
				});
			</script>
			<?php
		}
	}
	/**
	 * If NOT in front-page:
	 */
	else {
		/**
		 * Check if we are in companies page:
		 */
		if (is_singular('companies')) {
			if ( get_field('company_about_us') ) {
				echo wpautop(get_field('company_about_us'));
			}
			else {
				?>
				<script type="application/javascript">
					jQuery(document).ready(function($) {
						$(".about-us-title").addClass("display-none-class");
					});
				</script>
				<?php
			}
		}
		/**
		 * Check if we are in group of companies page:
		 */
		if (is_singular('group_of_companies')) {
			if ( get_field('group_of_companies_about_us') ) {
				echo wpautop(get_field('group_of_companies_about_us'));
			}
			else {
				?>
				<script type="application/javascript">
					jQuery(document).ready(function($) {
						$(".about-us-title").addClass("display-none-class");
					});
				</script>
				<?php
			}
		}
	}
}

/**
 * ######################## 2.6 Shared functions - Our Business Text:
 */

function get_our_business_text() {
	/**
	 * Check if we are in companies page:
	 */
	if (is_singular('companies')) {
		if ( get_field('company_our_business') ) {
			echo wpautop(get_field('company_our_business'));
		}
		else {
			?>
			<script type="application/javascript">
				jQuery(document).ready(function($) {
					$(".our-business-title").addClass("display-none-class");
				});
			</script>
			<?php
		}
	}
	/**
	 * Check if we are in group of companies page:
	 */
	if (is_singular('group_of_companies')) {
		if ( get_field('group_of_companies_our_business') ) {
			echo wpautop(get_field('group_of_companies_our_business'));
		}
		else {
			?>
			<script type="application/javascript">
				jQuery(document).ready(function($) {
					$(".our-business-title").addClass("display-none-class");
				});
			</script>
			<?php
		}
	}
}

/**
 * ######################## 2.7 Shared functions - Mission Text:
 */

function get_mission_text() {
	/**
	 * Check if we are in front-page:
	 */
	if (is_page_template('page-templates/front-page.php')){
		if ( get_field('front_page_mission') ) {
			echo wpautop(get_field('front_page_mission'));
		}
		else {
			?>
			<script type="application/javascript">
				jQuery(document).ready(function($) {
					$(".mission-title").addClass("display-none-class");
				});
			</script>
			<?php
		}
	}
	/**
	 * If NOT in front-page:
	 */
	else {
		/**
		 * Check if we are in companies page:
		 */
		if (is_singular('companies')) {
			if ( get_field('company_mission') ) {
				echo wpautop(get_field('company_mission'));
			}
			else {
				?>
				<script type="application/javascript">
					jQuery(document).ready(function($) {
						$(".mission-title").addClass("display-none-class");
					});
				</script>
				<?php
			}
		}
		/**
		 * Check if we are in group of companies page:
		 */
		if (is_singular('group_of_companies')) {
			if ( get_field('group_of_companies_mission') ){
				echo wpautop(get_field('group_of_companies_mission'));
			}
			else {
				?>
				<script type="application/javascript">
					jQuery(document).ready(function($) {
						$(".mission-title").addClass("display-none-class");
					});
				</script>
				<?php
			}
		}
	}
}

/**
 * ######################## 2.8 Shared functions - Youtube videos:
 */

function get_youtube_videos() {
	if ( is_singular( 'companies' ) ) {
		$field_name_repeater = 'company_youtube_repeater';
		$youtube_url_field = 'company_youtube_url';
	}
	if ( is_singular( 'group_of_companies' ) ) {
		$field_name_repeater = 'group_of_companies_youtube_repeater';
		$youtube_url_field = 'group_of_companies_youtube_url';
	}
	if (have_rows($field_name_repeater) ) {
		/**
		 * Create an array for youtube ids:
		 */
		$youtube_id_array = array();
		/**
		 * Go through all the data in company_youtube_repeater field:
		 */
		while (have_rows($field_name_repeater) ) {
			the_row();
			/**
			 * youtube id is a substring of the whole url, cut the https://www.youtube.com/watch?v= away from the string.
			 */
			$youtube_id = substr(get_sub_field($youtube_url_field), 32);
			/**
			 * Push the youtube id to the youtube_id_array
			 */
			array_push($youtube_id_array,$youtube_id);
		} // end of while
		/**
		 * Create a string with youtube embed URL:
		 */
		$youtube_url_embed = 'https://youtube.com/embed/';
		$counter = 0;
		/**
		 * Count the youtube_id_array and if there is only one youtube video, then create a playlist that loops this one video
		 */
		if (count($youtube_id_array) == 1) {
			$youtube_url_embed .= $youtube_id_array[0].'?version=3&loop=1&modestbranding=1&rel=0&playlist='.$youtube_id_array[0];
		}
		/**
		 * If there are more than one videos:
		 */
		else {
			foreach($youtube_id_array as $youtube_ids) {
				/**
				 * When the counter is 1 (second video), then add control options to the embed url
				 */
				if ($counter == 1) {
					$youtube_url_embed .= '?version=3&loop=1&modestbranding=1&rel=0&playlist=';
				}
				$youtube_url_embed .= $youtube_ids.',';
				$counter++;
			}
			/**
			 * Remove the last colon from the embed url
			 */
			$youtube_url_embed = rtrim($youtube_url_embed,',');
		}
		?>
		<iframe class="youtube-iframe" src="<?php echo $youtube_url_embed; ?>" width="100%" height="500px" frameborder="0" allowfullscreen></iframe>
		<?php
	}

	/**
	 * If there are NO youtube videos -> HIDE youtube section, change team section bg-color to brown and texts to white
	 */
	else {
		// Do nothing
	}
}

/**
 * ######################## 2.9 Shared functions - Pictures & PDF:
 */

function get_pictures_and_pdf() {
	if ( is_singular( 'companies' ) ) {
		$field_name = 'company_pictures_and_pdf';
	}
	if ( is_singular( 'group_of_companies' ) ) {
		$field_name = 'group_of_companies_pictures_and_pdf';
	}
	if ( get_field($field_name) ) {
		$file_ids = get_field($field_name);
		foreach ($file_ids as $file_id) {
			$file_type = $file_id['mime_type'];
			if ($file_type == 'application/pdf') {
				$my_thumbnail_id = get_post_thumbnail_id($file_id['id']);
				?>
				<div class="item">
					<a href="<?php echo wp_get_attachment_url($file_id['id']); ?>">
						<img src="<?php echo wp_get_attachment_url( $my_thumbnail_id ); ?>" alt="Owl Image">
					</a>
				</div>
				<?php
			}
			else {
				?>
				<div class="item">
					<a href="<?php echo $file_id['url']; ?>">
						<img src="<?php echo $file_id['url']; ?>" alt="Owl Image">
					</a>
				</div>
				<?php
			}
		}
	}
}

/**
 * ######################## 2.10 Shared functions - Title text:
 */

function get_title_text() {
	?>
	<span class="company-title-text"><?php the_title(); ?></span>
	<?php
}

/**
 * ######################## 2.11 Shared functions - Slogan text:
 */

function get_slogan() {
	if ( is_singular( 'companies' ) ) {
		$field_name = 'company_slogan';
	}
	if ( is_singular( 'group_of_companies' ) ) {
		$field_name = 'group_of_companies_slogan';
	}
	global $post;
	if (get_post_meta($post->ID, $field_name, true)){
		$slogan = '"'.get_post_meta($post->ID, $field_name, true).'"';
		$slogan_string_count = strlen($slogan);
		if ($slogan_string_count <= 124) {
			?>
			<span class="company-slogan-text" style="font-size: 18px;">
		<?php
		echo $slogan;
		?>
		</span>
			<?php
		}
		else {
			?>
			<span class="company-slogan-text" style="font-size: 14px;">
		<?php
		echo $slogan;
		?>
		</span>
			<?php
		}
	}
	else {
		// no company slogan, don't display anything.
	}
}

/**
 * ######################## 2.12 Shared functions -  Sketchfab elements:
 */

function get_sketchfab_elements() {
	if ( is_singular( 'companies' ) ) {
		$field_name_repeater = 'company_sketchfab_repeater';
		$sketchfab_url_meta = 'company_sketchfab_url';
		$sketchfab_annotation_cycle_meta = 'company_sketchfab_annotation_cycle';
		$sketchfab_auto_spin_meta = 'company_sketchfab_auto_spin';
	}
	if ( is_singular( 'group_of_companies' ) ) {
		$field_name_repeater = 'group_of_companies_sketchfab_repeater';
		$sketchfab_url_meta = 'group_of_companies_sketchfab_url';
		$sketchfab_annotation_cycle_meta = 'group_of_companies_sketchfab_annotation_cycle';
		$sketchfab_auto_spin_meta = 'group_of_companies_sketchfab_auto_spin';
	}
	if (have_rows($field_name_repeater) ) {
		$sketchfab_counter = 0;
		/**
		 * Go through all the data in company_sketchfab_repeater field:
		 */
		?>
		<div id="owl-sketchfab" class="owl-carousel owl-theme">
			<?php
			while (have_rows($field_name_repeater) ) {
				the_row();
				/**
				 * First sketchfab element starts automatically (autostart=1):
				 */
				if ( $sketchfab_counter == 0 ){
					/**
					 * if the user is one mobile, DO NOT start the Sketchfab automatically:
					 */
					if (wp_is_mobile()) {
						$sketchfab_url = get_sub_field($sketchfab_url_meta).'/embed?annotation_cycle='.get_sub_field($sketchfab_annotation_cycle_meta).'&autospin='.get_sub_field($sketchfab_auto_spin_meta);
					}
					/**
					 * User is not using mobile, start sketchfab automatically:
					 */
					else {
						$sketchfab_url = get_sub_field($sketchfab_url_meta).'/embed?autostart=1&annotation_cycle='.get_sub_field($sketchfab_annotation_cycle_meta).'&autospin='.get_sub_field($sketchfab_auto_spin_meta);
					}
				}
				else {
					$sketchfab_url = get_sub_field($sketchfab_url_meta).'/embed?annotation_cycle='.get_sub_field($sketchfab_annotation_cycle_meta).'&autospin='.get_sub_field($sketchfab_auto_spin_meta);
				}
				?>
				<div class="item">
					<iframe src="<?php echo $sketchfab_url ?>" class="sketchfab-iframe" id="sketchfab-frame-<?php echo $sketchfab_counter; ?>" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
				</div>
				<?php
				$sketchfab_counter++;
			}
			?>
		</div>
		<?php
	}
	/**
	 * If there are NO sketchfab elements -> HIDE sketchfab section.
	 */
	else {
		?>
		<script type="application/javascript">
			$(document).ready(function() {
				$(".sketchfab-owl-carousel").addClass("display-none-class");
			});
		</script>
		<?php
	}
}

/**
 * ######################## 2.13 Shared functions -  Team members:
 */

function get_team_members() {
	if ( is_singular( 'companies' ) ) {
		$field_name_repeater = 'company_team_member_repeater';
		$name_meta = 'company_team_member_name';
		$job_title_meta = 'company_team_member_job_title';
		$phone_number_meta = 'company_team_member_phone_number';
		$email_meta = 'company_team_member_email';
		$picture_meta = 'company_team_member_picture';
	}
	if ( is_singular( 'group_of_companies' ) ) {
		$field_name_repeater = 'group_of_companies_team_member_repeater';
		$name_meta = 'group_of_companies_team_member_name';
		$job_title_meta = 'group_of_companies_team_member_job_title';
		$phone_number_meta = 'group_of_companies_team_member_phone_number';
		$email_meta = 'group_of_companies_team_member_email';
		$picture_meta = 'group_of_companies_team_member_picture';
	}
	$team_member_count = 0;
	/**
	 * Check if there are data in the team_member_repeater field:
	 */
	$team_member_name_array = array();
	$team_member_job_title_array = array();
	$team_member_phone_number_array = array();
	$team_member_email_array = array();
	$team_member_picture_url_array = array();
	if (have_rows($field_name_repeater)) {
		/**
		 * Go through all the data in the team_member_repeated field
		 */
		while ( have_rows($field_name_repeater) ) {
			/**
			 * the_row() function gets the row data
			 */
			the_row();
			array_push( $team_member_name_array , get_sub_field($name_meta) );
			array_push( $team_member_job_title_array , get_sub_field($job_title_meta) );
			array_push( $team_member_phone_number_array , get_sub_field($phone_number_meta) );
			array_push( $team_member_email_array , get_sub_field($email_meta) );
			array_push( $team_member_picture_url_array , get_sub_field($picture_meta) );
			$team_member_count++;
		}
	}
	/**
	 * Different styles for different amount of team members
	 */
	switch ($team_member_count) {
		case 0:
			/**
			 * There are no team members -> HIDE our team section
			 */
			break;
		case 1:
			?>
			<div class="col-lg-6 center-block">
				<?php
				make_team_member_html_card(
					$team_member_name_array[0],
					$team_member_job_title_array[0],
					$team_member_phone_number_array[0],
					$team_member_email_array[0],
					$team_member_picture_url_array[0],
					'grey-underline')
				?>
			</div>
			<?php
			break;
		case 2:
			?>
			<div class="col-sm-6 col-md-6 col-lg-6">
				<?php
				make_team_member_html_card(
					$team_member_name_array[0],
					$team_member_job_title_array[0],
					$team_member_phone_number_array[0],
					$team_member_email_array[0],
					$team_member_picture_url_array[0],
					'grey-underline')
				?>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6">
				<?php
				make_team_member_html_card(
					$team_member_name_array[1],
					$team_member_job_title_array[1],
					$team_member_phone_number_array[1],
					$team_member_email_array[1],
					$team_member_picture_url_array[1],
					'grey-underline')
				?>
			</div>
			<?php
			break;
		case 3:
			?>
			<div class="col-sm-6 col-md-4 col-lg-3 col-lg-offset-1">
				<?php
				make_team_member_html_card(
					$team_member_name_array[0],
					$team_member_job_title_array[0],
					$team_member_phone_number_array[0],
					$team_member_email_array[0],
					$team_member_picture_url_array[0],
					'grey-underline')
				?>
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3">
				<?php
				make_team_member_html_card(
					$team_member_name_array[1],
					$team_member_job_title_array[1],
					$team_member_phone_number_array[1],
					$team_member_email_array[1],
					$team_member_picture_url_array[1],
					'grey-underline')
				?>
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3">
				<?php
				make_team_member_html_card(
					$team_member_name_array[2],
					$team_member_job_title_array[2],
					$team_member_phone_number_array[2],
					$team_member_email_array[2],
					$team_member_picture_url_array[2],
					'grey-underline')
				?>
			</div>
			<?php
			break;
		case 4:
			?>
			<div class="col-sm-6 col-md-4 col-lg-3">
				<?php
				make_team_member_html_card(
					$team_member_name_array[0],
					$team_member_job_title_array[0],
					$team_member_phone_number_array[0],
					$team_member_email_array[0],
					$team_member_picture_url_array[0],
					'grey-underline')
				?>
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3">
				<?php
				make_team_member_html_card(
					$team_member_name_array[1],
					$team_member_job_title_array[1],
					$team_member_phone_number_array[1],
					$team_member_email_array[1],
					$team_member_picture_url_array[1],
					'grey-underline')
				?>
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3">
				<?php
				make_team_member_html_card(
					$team_member_name_array[2],
					$team_member_job_title_array[2],
					$team_member_phone_number_array[2],
					$team_member_email_array[2],
					$team_member_picture_url_array[2],
					'grey-underline')
				?>
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3">
				<?php
				make_team_member_html_card(
					$team_member_name_array[3],
					$team_member_job_title_array[3],
					$team_member_phone_number_array[3],
					$team_member_email_array[3],
					$team_member_picture_url_array[3],
					'grey-underline')
				?>
			</div>
			<?php
			break;
		default:
			break;
	}
}

/**
 * ######################## 2.14 Shared functions -  Make team member html card:
 *
 * @param $name != null
 * @param $job_title != null
 * @param $phone_number != null
 * @param $email != null
 * @param $picture_url != null
 * @param $underline_color != null
 */

function make_team_member_html_card($name, $job_title, $phone_number, $email, $picture_url, $underline_color) {
	?>
	<div class="team-member">
		<div class="profile-picture" style="background-image: url(<?php echo $picture_url; ?>)"></div>
		<div class="profile-details">
			<span class="profile-name"><?php echo $name; ?></span>
			<div class="profile-underline <?php echo $underline_color; ?>"></div>
			<span class="profile-job-position"><?php echo $job_title; ?></span>
			<span class="profile-phone-number"><?php echo $phone_number; ?></span>
			<a class="profile-email" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
		</div>
	</div>
	<?php
}

/**
 * ######################## 2.15 Shared functions -  contact form:
 */

function get_contact_form() {
	global $post;
	?>
	<div id="contact_form">
		<form id="contactform">
			<div class="col-md-6 contact-name">
				<input type="text" name="name" id="name" class="input-box" placeholder="<?php echo __('Your Name', 'threedee-expo'); ?>">
			</div>
			<div class="col-md-6 contact-email">
				<input type="text" name="email" id="email" class="input-box" placeholder="<?php echo __('Your Email', 'threedee-expo'); ?>">
			</div>
			<div class="col-lg-12 col-sm-12">
				<textarea name="message" id="message" class="textarea-box" placeholder="<?php echo __('Your Message', 'threedee-expo'); ?>"></textarea>
			</div>
			<input type="hidden" name="action" value="contactform_action" />
			<input type="hidden" name="post_id" value="<?php echo $post->ID; ?>"/>
			<input type="hidden" name="post_type" value="<?php echo $post->post_type;?>" />
			<?php echo wp_nonce_field('contactform_action', '_acf_nonce', true, false) ?>
			<input type="button" id="contactbutton" value="<?php echo __('Send Message', 'threedee-expo'); ?>" class="btn-primary red-btn send-message-button">
		</form>
	</div>
	<div id="contact-msg"></div>
	<?php
}

/**
 * ######################## 2.16 Shared functions - load contact form:
 */

function contactform_add_script() {
	wp_enqueue_script( 'contactform-script', get_template_directory_uri().'/js/contact.js', array('jquery') );
	wp_localize_script( 'contactform-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('wp_enqueue_scripts', 'contactform_add_script');

/**
 * ######################## 2.17 Shared functions - Ajax contact form:
 */

function ajax_contactform_action_callback() {
	/**
	 * Get the post type from hidden input (companies OR group_of_companies):
	 */
	$post_type = $_POST['post_type'];
	if ($post_type == 'companies') {
		/**
		 * Get the post id from hidden input
		 */
		$to = get_field('company_contact_email', intval($_POST['post_id']));
		if ($to == '') {
			$to = get_option('admin_email'); // Fallback
		}
	}
	elseif ($post_type == 'group_of_companies') {
		/**
		 * Get the post id from hidden input
		 */
		$to = get_field('group_of_companies_contact_email', intval($_POST['post_id']));
		if ($to == '') {
			$to = get_option('admin_email'); // Fallback
		}
	}
	else {
		/**
		 * fallback email address:
		 */
		$to = get_option('admin_email'); // Fallback
	}
	$error = '';
	$status = 'error';
	if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
		$error = 'All fields are required to enter.';
	} else {
		if (!wp_verify_nonce($_POST['_acf_nonce'], $_POST['action'])) {
			$error = 'Verification error, try again.';
		} else {
			$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);
			$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$subject = 'A message from your virtual expo contact form';
			$message = stripslashes($_POST['message']);
			$message .= PHP_EOL.PHP_EOL.'IP address: '.$_SERVER['REMOTE_ADDR'];
			$message .= PHP_EOL.'Sender\'s name: '.$name;
			$message .= PHP_EOL.'E-mail address: '.$email;
			$sendmsg = 'Thanks, for the message. We will respond as soon as possible.';
			$header = 'From: '.get_option('blogname').' <noreply@virtualexpo.fi>'.PHP_EOL;
			$header .= 'Reply-To: '.$email.PHP_EOL;
			if ( wp_mail($to, $subject, $message, $header) ) {
				$status = 'success';
				$error = $sendmsg;
			} else {
				$error = 'Some errors occurred.';
			}
		}
	}

	$resp = array('status' => $status, 'errmessage' => $error);
	header( "Content-Type: application/json" );
	echo json_encode($resp);
	die();
}
add_action( 'wp_ajax_contactform_action', 'ajax_contactform_action_callback' );
add_action( 'wp_ajax_nopriv_contactform_action', 'ajax_contactform_action_callback' );


/**
 * ######################## 3 Front page functions:
 */

/**
 * ######################## 3.1 Front page functions - Get random sketchfab (from companies) to front page showcase:
 */

function get_random_sketchfab_to_showcase() {
	/**
	 * 1st GET COMPANIES
	 */
	$args = array(
		'orderby'		    =>	'title',
		'order'			    =>	'ASC',
		'post_type'         =>  'companies',
		'post_status'       =>  'publish',
		'posts_per_page'    =>  -1
	);
	$companies = get_posts($args);
	/**
	 * Make an array for the sketchfab URLs
	 */
	$sketchfab_id_array = array();
	/**
	 * This array will hold the value of the company which corresponds to the sketchfab id (used in showcase text)
	 */
	$company_array = array();
	/**
	 * Loop through the companies and add sketchfab urls to the array:
	 */
	foreach ($companies as $company) {
		/**
		 * If there are rows in company_sketchfab_repeater:
		 */
		if ( have_rows('company_sketchfab_repeater', $company->ID) ) {
			/**
			 * Loop through the company_sketchfab_repeater field:
			 */
			while ( have_rows('company_sketchfab_repeater', $company->ID) ){
				the_row();
				array_push($sketchfab_id_array,substr( get_sub_field('company_sketchfab_url', $company->ID) , 29 ) );
				array_push($company_array, $company);
			}
		}
		/**
		 * NO rows in company_sketchfab_repeater:
		 */
		else {
			// do nothing
		}
	}
	/**
	 * Get counts of both sketchfab_id_array and company_array. They should be equal.
	 */
	$sketchfab_id_array_count = count($sketchfab_id_array);
	$company_array_count = count($company_array);
	$random_sketchfab_id = rand(0,$sketchfab_id_array_count-1);
	/**
	 * If user is using mobile -> DO NOT start sketchfab automatically:
	 */
	if (wp_is_mobile()) {
		$random_sketchfab_url = 'https://sketchfab.com/models/'.$sketchfab_id_array[$random_sketchfab_id].'/embed?scrollwheel=0&annotation_cycle=10';
	}
	/**
	 * If user is NOT using mobile -> start sketchfab automatically:
	 */
	else {
		$random_sketchfab_url = 'https://sketchfab.com/models/'.$sketchfab_id_array[$random_sketchfab_id].'/embed?autostart=1&scrollwheel=0&annotation_cycle=10';
		/**
		 * Display the showcase overlay only on DESKTOP:
		 */
		if ($sketchfab_id_array_count == $company_array_count){
			$showcase_company = $company_array[$random_sketchfab_id];
			$showcase_company_name = $showcase_company->post_title;
			$showcase_company_url = get_permalink($showcase_company->ID);
			?>
			<div class="showcase-overlay">
				<div class="showcase-text-area">
					<span class="showcase-static-title"><?php echo __('Showcase:','threedee-expo'); ?></span>
					<span class="showcase-company-title"><?php echo $showcase_company_name; ?></span>
				</div>
				<div class="showcase-buttons">
					<a href="<?php echo $showcase_company_url; ?>" class="button btn-large btn-primary" id="see-more-button"><?php echo __('See More', 'threedee-expo');?></a>
				</div>
			</div>
			<?php
		}
	}

	?>
	<iframe src="<?php echo $random_sketchfab_url; ?>" class="sketchfab-iframe" id="front-page-sketchfab" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
	<?php
}

/**
 * ######################## 3.2 Front page functions - Get Companies or Group of companies:
 * @param $post_type_indicator == 'company' || $post_type_indicator == 'group_of_companies'
 */

function get_companies_or_group_of_companies($post_type_indicator) {
	/**
	 * Arguments for get posts:
	 */
	$args = array(
		'orderby'		    =>	'title',
		'order'			    =>	'ASC',
		'post_type'         =>  $post_type_indicator,
		'post_status'       =>  'publish',
		'posts_per_page'    =>  -1
	);
	if ($post_type_indicator == 'companies') {
		$companies = get_posts($args);
		?>
		<div class="company-isotope">
			<?php
			foreach ($companies as $company) {
				$company_url = get_permalink($company->ID);
				$company_title = $company->post_title;
				$company_title_length = strlen($company_title);
				$company_logo_url = get_field('company_logo', $company->ID);
				?>
				<a href="<?php echo $company_url ?>" class="company-box col-xs-12 col-sm-6 col-md-4">
					<div class="item-card">
						<div class="item-card-thumbnail">
							<img src="<?php echo $company_logo_url; ?>" class="item-card-image">
						</div>
						<div class="item-card-title purple-bg">
							<?php
							if ($company_title_length <= 32) {
								?>
								<span class="item-title white-text"><?php echo $company_title; ?></span>
								<?php
							}
							else {
								?>
								<span class="item-title white-text" style="font-size:16px!important"><?php echo $company_title; ?></span>
								<?php
							}
							?>
						</div>
					</div>
				</a>
				<?php
			}
			?>
		</div>
		<?php
	}
	if ($post_type_indicator == 'group_of_companies') {
		$group_of_companies = get_posts($args);
		?>
		<div class="group-of-companies-isotope">
			<?php
			foreach ($group_of_companies as $group_of_company) {
				$group_of_companies_url = get_permalink($group_of_company->ID);
				$group_of_companies_title = $group_of_company->post_title;
				$group_of_companies_title_length = strlen($group_of_companies_title);
				$group_of_companies_logo_url = get_field('group_of_companies_logo', $group_of_company->ID);
				?>
				<a href="<?php echo $group_of_companies_url ?>" class="group-of-companies-box col-xs-12 col-sm-6 col-md-4">
					<div class="item-card">
						<div class="item-card-thumbnail">
							<img src="<?php echo $group_of_companies_logo_url; ?>" class="item-card-image">
						</div>
						<div class="item-card-title turquoise-bg">
							<?php
							if ($group_of_companies_title_length <= 32) {
								?>
								<span class="item-title white-text"><?php echo $group_of_companies_title; ?></span>
								<?php
							}
							else {
								?>
								<span class="item-title white-text" style="font-size:16px!important"><?php echo $group_of_companies_title; ?></span>
								<?php
							}
							?>
						</div>
					</div>
				</a>
				<?php
			}
			?>
		</div>
		<?php
	}
	else {
		// do nothing
	}
}

/**
 * ######################## 4 Group of Companies page:
 */

/**
 * ######################## 4.1 Group of Companies - Add companies meta box to admin side:
 */

add_action( 'add_meta_boxes', 'make_company_meta_box' );

function make_company_meta_box() {
	add_meta_box(
		'group_of_companies_meta_box',
		__('Companies', 'threedee-expo'),
		'companies_meta_box_callback',
		'group_of_companies'
	);
	add_meta_box(
		'group_of_companies_embed',
		__('Website Display', 'threedee-expo'),
		'embed_meta_box_callback',
		'group_of_companies',
		'side'
	);
}

function embed_meta_box_callback() {
	global $post;
	$url = get_permalink($post->ID);

	?>
	<div class="admin-website-display" style="height: 1200px;">
		<iframe src="<?php echo $url; ?>" class="admin-iframe-element" style="border: black solid 10px; width: 1250px; height:6000px ;transform: scale(0.2,0.2); transform-origin: top left;"></iframe>
	</div>

	<?php
}

/**
 * ######################## 4.2 Group of Companies - Load companies to the meta box:
 */

function companies_meta_box_callback( $post ) {
	wp_nonce_field( basename(__FILE__),'companies_nonce');
	$stored_meta = get_post_meta($post->ID, 'company_checkbox_meta', true);
	/**
	 * 1st GET COMPANIES
	 */
	$args = array(
		'orderby'		    =>	'title',
		'order'			    =>	'ASC',
		'post_type'         =>  'companies',
		'post_status'       =>  'publish',
		'posts_per_page'    =>  -1
	);
	$companies = get_posts($args);
	foreach ($companies as $company) {
		$company_id = $company->ID;
		$company_logo_url = get_field('company_logo', $company->ID);
		$company_title = $company->post_title;
		/**
		 * If there is meta data already available in $stored_meta:
		 */
		if (count($stored_meta)>0) {
			/**
			 * check if the company ID is in $stored_meta array:
			 */
			if ( in_array($company_id, (array)$stored_meta) ) {
				?>
				<a href="#" id="checkbox-link-<?php echo $company_id;?>" class="company-select-link">
					<div class="item-card">
						<i class="fa fa-check item-card-check-mark" id="check-mark-<?php echo $company_id; ?>"></i>
						<input class="company-checkbox" type="checkbox" name="company_checkbox_<?php echo $company_id; ?>" value="<?php echo $company_id; ?>" checked="checked">
						<div class="item-card-thumbnail">
							<img src="<?php echo $company_logo_url; ?>" class="item-card-image">
						</div>
						<div class="item-card-title white-bg">
							<span class="item-title"><?php echo $company_title; ?></span>
						</div>
					</div>
				</a>
				<?php
			}
			/**
			 * company ID is NOT in $stored_meta array:
			 */
			else {
				?>
				<a href="#" id="checkbox-link-<?php echo $company_id;?>" class="company-select-link">
					<div class="item-card">
						<i class="fa fa-check item-card-check-mark not-checked" id="check-mark-<?php echo $company_id; ?>"></i>
						<input class="company-checkbox" type="checkbox" name="company_checkbox_<?php echo $company_id; ?>" value="<?php echo $company_id; ?>">
						<div class="item-card-thumbnail">
							<img src="<?php echo $company_logo_url; ?>" class="item-card-image">
						</div>
						<div class="item-card-title white-bg">
							<span class="item-title"><?php echo $company_title; ?></span>
						</div>
					</div>
				</a>
				<?php
			}
		}
		/**
		 * There is NO meta data already available -> create all the companies in one list with no company checked:
		 */
		else {
			?>
			<a href="#" id="checkbox-link-<?php echo $company_id;?>" class="company-select-link">
				<div class="item-card">
					<i class="fa fa-check item-card-check-mark not-checked" id="check-mark-<?php echo $company_id; ?>"></i>
					<input class="company-checkbox" type="checkbox" name="company_checkbox_<?php echo $company_id; ?>" value="<?php echo $company_id; ?>">
					<div class="item-card-thumbnail">
						<img src="<?php echo $company_logo_url; ?>" class="item-card-image">
					</div>
					<div class="item-card-title white-bg">
						<span class="item-title"><?php echo $company_title; ?></span>
					</div>
				</div>
			</a>
			<?php
		}
		$checkbox_name = 'company_checkbox_'.$company_id;
		$link_variable = 'checkbox-link-'.$company_id;
		$check_mark = 'check-mark-'.$company_id;
		?>
		<script type="application/javascript">
			jQuery(document).ready(function($){
					$('#<?php echo $link_variable; ?>').click(
						function(event) {
							event.preventDefault();
							if ( $('[name="<?php echo $checkbox_name; ?>"]').is(':checked') ) {
								$('[name="<?php echo $checkbox_name; ?>"]').prop('checked', false);
								$('#<?php echo $check_mark; ?>').addClass('not-checked');
							}
							else {
								$('[name="<?php echo $checkbox_name; ?>"]').prop('checked', true);
								$('#<?php echo $check_mark; ?>').removeClass('not-checked');
							}
						}
					)
			});
		</script>
		<?php
	}
}

/**
 * ######################## 4.3 Group of Companies - Save meta box data to the post:
 */

function save_companies_meta_box_data($post_id) {
	if ( !isset( $_POST[ 'companies_nonce' ] ) || !wp_verify_nonce( $_POST[ 'companies_nonce' ], basename(__FILE__) ) ) {
		return $post_id;
	}
	if ( !current_user_can('edit_post', $post_id) ) {
		return $post_id;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	$meta_box_data = array();
	$args = array(
		'orderby'           =>	'title',
		'order'	            =>	'ASC',
		'post_type'         =>  'companies',
		'post_status'       =>  'publish',
		'posts_per_page'    =>  -1
	);
	$companies = get_posts($args);
	foreach ($companies as $company) {
		$company_id = 'company_checkbox_'.$company->ID;
		if (isset( $_POST[$company_id] ) ) {
			array_push($meta_box_data,$_POST[$company_id]);
		}
	}
	update_post_meta($post_id, 'company_checkbox_meta', $meta_box_data);
}

add_action('save_post','save_companies_meta_box_data',10,3);


/**
 * ######################## 4.4 Group of Companies - Get Companies that are linked to group of company:
 */

function get_companies_linked_to_group_of_company() {
	global $post;
	/**
	 * Check if there are companies linked to the post:
	 */
	if (get_post_meta($post->ID, 'company_checkbox_meta', true)) {
		/**
		 * Arguments for get posts:
		 */
		$args = array(
			'orderby'		    =>	'title',
			'order'			    =>	'ASC',
			'post_type'         =>  'companies',
			'post_status'       =>  'publish',
			'posts_per_page'    =>  -1
		);
		$companies = get_posts($args);
		$linked_companies_ids = get_post_meta($post->ID, 'company_checkbox_meta', true);
		?>
		<div class="company-isotope">
			<?php
			/**
			 * Go through all the posts:
			 */
			foreach ($companies as $company) {
				/**
				 * Go through all the linked id's
				 */
				foreach ($linked_companies_ids as $linked_company_id) {
					/**
					 * if linked company id == company id, then generate company card.
					 */
					if ($linked_company_id == $company->ID) {
						$company_url = get_permalink($company->ID);
						$company_title = $company->post_title;
						$company_logo_url = get_field('company_logo', $company->ID);
						$company_title_length = strlen($company_title);
						?>
						<a href="<?php echo $company_url ?>" class="company-box col-xs-12 col-sm-6 col-md-4">
							<div class="item-card">
								<div class="item-card-thumbnail">
									<img src="<?php echo $company_logo_url; ?>" class="item-card-image">
								</div>
								<div class="item-card-title white-bg">
									<?php
									if ($company_title_length <= 32) {
										?>
										<span class="item-title black-text"><?php echo $company_title; ?></span>
										<?php
									}
									else {
										?>
										<span class="item-title black-text" style="font-size:16px!important"><?php echo $company_title; ?></span>
										<?php
									}
									?>
								</div>
							</div>
						</a>
						<?php
					}
					else {
						// do nothing.
					}
				}
			}
			?>
		</div>
		<?php
	}
	/**
	 * If there are no linked companies
	 */
	else {
		// do nothing.
	}
}

/**
 * ######################## 5.1 Virtual Expo - Get header section other:
 */

function ve_get_header_section_other() {
	/**
	 * DEFAULT colors:
	 */
	$background_color = '#ffffff';
	$header_text_color = '#4e1185';
	$slogan_text_color = '#4e1185';
	if (get_field('header_background_color')) {
		$background_color = get_field('header_background_color');
	}

	if (get_field('header_text_color')) {
		$header_text_color = get_field('header_text_color');
	}
	if (get_field('slogan_text_color')) {
		$slogan_text_color = get_field('slogan_text_color');
	}
	if ( is_user_logged_in() ) {
		if ( wp_is_mobile() ){
			?>
			<div class="full-width header-section-mobile" style="background-color: <?php echo $background_color;?>">
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
					  <a class="navbar-brand" href="<?php echo site_url() ?>">
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
			<?php
		} else {
			?>
			<div class="full-width header-section logged-in-content" style="background-color: <?php echo $background_color;?>">
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
					  <a class="navbar-brand" href="<?php echo site_url() ?>">
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
			<?php
		}
	} else {
		?>
		<div class="full-width header-section" style="background-color: <?php echo $background_color;?>">
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
				  <a class="navbar-brand" href="<?php echo site_url() ?>">
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
		<?php
	}
	?>
	<script type="application/javascript">
		$(document).ready(function($) {
			$(".company-title-text").css({"color":"<?php echo $header_text_color;?>"});
			$(".company-slogan-text").css({"color":"<?php echo $slogan_text_color;?>"});
		});
	</script>
	<?php
}

/**
 * ######################## 5.2 Virtual Expo - Is sketchfab available?
 */

function ve_sketchfab_empty() {
	if ( is_singular( 'companies' ) ) {
		$field_name_repeater = 'company_sketchfab_repeater';
	}
	if ( is_singular( 'group_of_companies' ) ) {
		$field_name_repeater = 'group_of_companies_sketchfab_repeater';
	}
	if (have_rows($field_name_repeater) ) {
		return false;
	}
	else {
		return true;
	}
}

/**
 * ######################## 5.3 Virtual Expo - Get Sketchfab section:
 */

function ve_get_sketchfab_section() {
	if (is_page_template('page-templates/front-page.php')){
		if (is_user_logged_in() ) {
			if (wp_is_mobile() ) {
				?>
				<div class="full-width sketchfab-owl-carousel">
					<?php get_random_sketchfab_to_showcase(); ?>
				</div>
				<?php
			}
			else {
				?>
				<div class="full-width sketchfab-owl-carousel pad-down-first-div">
					<?php get_random_sketchfab_to_showcase(); ?>
				</div>
				<?php
			}
		}
		else {
			?>
			<div class="full-width sketchfab-owl-carousel pad-down-first-div">
				<?php get_random_sketchfab_to_showcase(); ?>
			</div>
			<?php
		}
	} else {
		if (is_user_logged_in() ) {
			if (wp_is_mobile() ) {
				?>
				<div class="full-width sketchfab-owl-carousel">
					<?php get_sketchfab_elements(); ?>
				</div>
				<?php
			} else {
				?>
				<div class="full-width sketchfab-owl-carousel pad-down-first-div">
					<?php get_sketchfab_elements(); ?>
				</div>
				<?php
			}
		} else {
			?>
			<div class="full-width sketchfab-owl-carousel pad-down-first-div">
				<?php get_sketchfab_elements(); ?>
			</div>
			<?php
		}
	}
}

/**
 * ######################## 5.4 Virtual Expo - Get Information Section:
 */

function ve_get_information_section(){
	if (is_page_template('page-templates/front-page.php')){
		if (!ve_information_section_is_empty()) {
		} else {
			?>
			<div class="full-width padded-top-bottom" id="front-page-information-section">
				<div class="container">
					<div class="row">
					
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center padded-bottom">
						<span class="section-title-text">
							<?php echo __('Information', 'threedee-expo') ?>
						</span>
						</div>
					
					</div> <!-- row -->
					
					<div class="row">
						
						<div class="col-sm-4 col-md-4 col-md-offset-2">
						<span class="subtitle-text purple-text grey-underline about-us-title">
							<?php echo __('About Us', 'threedee-expo') ?>
							<img class="leftside" src="<?php echo get_template_directory_uri().'/images/graphics_left.png'; ?>">	
						</span>
						<span>
							<?php get_about_us_text(); ?>
						</span>
						</div>
						<div class="col-sm-4 col-md-4">
						<span class="subtitle-text purple-text grey-underline mission-title">
							<?php echo __('Mission', 'threedee-expo') ?>
							<img class="rightside" src="<?php echo get_template_directory_uri().'/images/graphics_right.png'; ?>">
						</span>
						<span>
							<?php get_mission_text(); ?>
						</span>
						</div>


						</div> <!-- row -->
				</div> <!-- container -->
			</div> <!-- information section -->
			<?php
		}
	} else {
		if (!ve_information_section_is_empty()) {
			// do nothing, info section is empty
		} else {
			/**
			 * Default colors:
			 */
			$background_color = 'white';
			$text_color = '333333';
			$about_us_underline_color = '#abaeae';
			$our_business_underline_color = '#abaeae';
			$mission_underline_color = '#abaeae';
			if (get_field('information_background_color')) {
				$background_color = get_field('information_background_color');
			}
			if (get_field('information_text_color')) {
				$text_color = get_field('information_text_color');
			}
			if (get_field('information_about_us_underline_color')) {
				$about_us_underline_color = get_field('information_about_us_underline_color');
			}
			if (get_field('information_our_business_underline_color')) {
				$our_business_underline_color = get_field('information_our_business_underline_color');
			}
			if (get_field('information_mission_underline_color')) {
				$mission_underline_color = get_field('information_mission_underline_color');
			}
			?>
			<div class="full-width padded-top-bottom" id="information-section" style="background-color: <?php echo $background_color;?>; color: <?php echo $text_color; ?>">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center padded-bottom">
						<span class="section-title-text">
							<?php get_pre_information_title() ?>
							<?php echo __('Information', 'threedee-expo') ?>
						</span>
						</div>
						<div class="col-sm-6 col-md-4">
						<span class="subtitle-text grey-underline about-us-title" style="border-bottom: 2px solid <?php echo $about_us_underline_color; ?> ;">
							<?php echo __('About Us', 'threedee-expo') ?>
						</span>
							<?php get_about_us_text(); ?>
						</div>
						<div class="col-sm-6 col-md-4">
						<span class="subtitle-text grey-underline our-business-title" style="border-bottom: 2px solid <?php echo $our_business_underline_color; ?> ;">
							<?php echo __('Our Business', 'threedee-expo') ?>
						</span>
							<?php get_our_business_text(); ?>
						</div>
						<div class="col-sm-6 col-md-4">
						<span class="subtitle-text grey-underline mission-title" style="border-bottom: 2px solid <?php echo $mission_underline_color; ?> ;">
							<?php echo __('Mission', 'threedee-expo') ?>
						</span>
							<?php get_mission_text(); ?>
						</div>

						

					</div> <!-- row -->
				</div> <!-- container -->
				
				<img class="bottom" src="<?php echo get_template_directory_uri().'/images/graphics_middle.png'; ?>">
			</div> <!-- information-section -->
			<?php
		} // End of else
	}
}

/**
 * ######################## 5.5 Virtual Expo - Get companies section (group of companies / partnership page):
 */

function ve_get_linked_companies_section(){
	global $post;
	/**
	 * Default colors:
	 */
	$background_color = "black";
	$text_color = "white";
	if (get_field('companies_background_color')){
		$background_color = get_field('companies_background_color');
	}
	if (get_field('companies_text_color')){
		$text_color = get_field('companies_text_color');
	}
	if (get_post_meta($post->ID, 'company_checkbox_meta', true)) {
		?>
		<div class="full-width linked-companies padded-top-bottom grey-bg" style="background-color: <?php echo $background_color; ?>">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center padded-bottom black-text" style="color: <?php echo $text_color;?>">
						<span class="section-title-text" id="front-page-companies-title-text">
							<?php echo __('Companies', 'threedee-expo') ?>
						</span>
					</div>
					<div class="col-lg-12">
						<?php get_companies_linked_to_group_of_company(); ?>
					</div>
				</div> <!-- row -->
			</div> <!-- container -->
		</div> <!-- linked-companies -->
		<?php
	} else {
		// Do nothing, when there are no companies linked to group of company
	}
}

/**
 * ######################## 5.6 Virtual Expo - Get youtube section:
 */

function ve_get_youtube_section() {
	if (is_singular('companies')) {
		if (have_rows('company_youtube_repeater')){
			?>
			<div class="full-width youtube-section black-bg">
				<?php get_youtube_videos(); ?>
			</div>
			<?php
		}
	} elseif (is_singular('group_of_companies')) {
		if (have_rows('group_of_companies_youtube_repeater')) {
			?>
			<div class="full-width youtube-section black-bg">
				<?php get_youtube_videos(); ?>
			</div>
			<?php
		}
	}
}

/**
 * ######################## 5.7 Virtual Expo - Get team members:
 */

function ve_get_team_section() {
	$empty_flag = true;
	$background_color = "white";
	$text_color = "black";
	if (get_field('our_team_background_color')) {
		$background_color = get_field('our_team_background_color');
	}
	if (get_field('our_team_text_color')) {
		$text_color = get_field('our_team_text_color');
	}
	if (is_singular('companies')) {
		if (have_rows('company_team_member_repeater')){
			$empty_flag = false;
		}
	} elseif (is_singular('group_of_companies')) {
		if (have_rows('group_of_companies_team_member_repeater')) {
			$empty_flag = false;
		}
	}
	if (!$empty_flag) {
		?>
		<div class="full-width team-section padded-top-bottom white-bg" style="background-color: <?php echo $background_color;?>; color: <?php echo $text_color; ?>">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center padded-bottom">
						<span class="section-title-text" id="our-team-title">
							<?php echo __('Our Team', 'threedee-expo') ?>
						</span>
					</div>
					<?php get_team_members(); ?>
				</div> <!-- row -->
			</div> <!-- container -->
		</div> <!-- team-section -->
		<?php
	}
}

/**
 * ######################## 5.8 Virtual Expo - Get contact us section:
 */

function ve_get_contact_us_section() {
	$background_color = "#40bfc7";
	$text_color = "#ffffff";
	if (get_field('contact_background_color')) {
		$background_color = get_field('contact_background_color');
	}
	if (get_field('contact_text_color')) {
		$text_color = get_field('contact_text_color');
	}
	?>
	<div class="full-width contact-us-section padded-top-bottom dark-grey-bg" style="background-color: <?php echo $background_color;?>">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center padded-bottom">
				<span class="section-title-text white-text" id="contact-us-title" style="color: <?php echo $text_color; ?>">
					<?php echo __('Contact Us', 'threedee-expo') ?>
				</span>
				</div>
				<?php get_contact_form(); ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * ######################## 5.9 Virtual Expo - Get material section:
 */

function ve_get_material_section() {
	$background_color = "white";
	$text_color = "black";
	if (get_field('material_background_color')) {
		$background_color = get_field('material_background_color');
	}
	if (get_field('material_text_color')) {
		$text_color = get_field('material_text_color');
	}
	$empty_flag = true;
	if (is_singular('companies')) {
		if (get_field('company_pictures_and_pdf')){
			$empty_flag = false;
		}
	} elseif (is_singular('group_of_companies')) {
		if (get_field('group_of_companies_pictures_and_pdf')) {
			$empty_flag = false;
		}
	}
	if (!$empty_flag) {
		?>
		<div class="full-width material-section padded-top-bottom" style="background-color: <?php echo $background_color;?>">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center padded-bottom">
						<span class="section-title-text" id="material-title" style="color: <?php echo $text_color; ?>">
							<?php echo __('Material', 'threedee-expo') ?>
						</span>
					</div>
					<div class="col-lg-12">
						<div id="pictures-owl">
							<?php get_pictures_and_pdf(); ?>
						</div>
					</div>
				</div> <!-- row -->
			</div> <!-- container -->
		</div> <!-- material-section -->
		<?php
	}
}

/**
 * ######################## 5.10 Virtual Expo - Get 360 photo section:
 */

function ve_get_360_photo_section() {
	if (is_singular('companies')) {
		if (have_rows('company_threesixty_photos_repeater')){
			?>
			<div class="full-width threesixty-photos-section black-bg">
				<?php ve_get_360_photos(); ?>
			</div>
			<?php
		}
	} elseif (is_singular('group_of_companies')) {
		if (have_rows('group_of_companies_threesixty_photos_repeater')) {
			?>
			<div class="full-width threesixty-photos-section black-bg">
				<?php ve_get_360_photos(); ?>
			</div>
			<?php
		}
	}
}

/**
 * ######################## 5.10 Virtual Expo - Get 360 photos:
 */

function ve_get_360_photos() {
	$field_name_repeater = '';
	$photo_url_field = '';
	if ( is_singular( 'companies' ) ) {
		$field_name_repeater = 'company_threesixty_photos_repeater';
		$photo_url_field = 'company_threesixty_photo_url';
	}
	if ( is_singular( 'group_of_companies' ) ) {
		$field_name_repeater = 'group_of_companies_threesixty_photos_repeater';
		$photo_url_field = 'group_of_companies_threesixty_photo_url';
	}
	if (have_rows($field_name_repeater) ) {
		/**
		 * Go through all the data in company_youtube_repeater field:
		 */
		?>
		<div id="owl-threesixty-photos" class="owl-carousel owl-theme">
			<?php
			while (have_rows($field_name_repeater) ) {
				the_row();
				?>
				<div class="item">
					<blockquote data-mode="click2play" data-width="100%" data-height="500px" class="ricoh-theta-spherical-image" ><?php echo get_sub_field($photo_url_field); ?><a href="<?php echo get_sub_field($photo_url_field); ?>" target="_blank"></a></blockquote>
				</div>
				<?php
			}
			?>
		</div>
		<script async src="https://theta360.com/widgets.js" charset="utf-8"></script>
		<?php
	}
	/**
	 * If there are NO 360 photos:
	 */
	else {
		// Do nothing
	}
}

/**
 * ######################## 6.1 New Layout - Get logo to header section:
 */

function ve_get_logo() {
	?>
	<img class="logo-area" src="<?php echo get_template_directory_uri().'/images/logo_text.png'; ?>">
	<?php
}

/**
 * ######################## 6.2 New Layout - Get navigation to header section:
 */

function ve_get_header_navigation() {
?>
<ul class="nav navbar-nav">
	<li><a href="<?php echo home_url() ?>">Front page <span class="sr-only">(current)</span></a></li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Companies <span class="caret"></span></a>
		<ul class="dropdown-menu purple">
			<?php ve_get_company_navigation() ?>
		</ul>
	<li class="dropdown">
	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Partnership <span class="caret"></span></a>
	  <ul class="dropdown-menu turquoise">
		<?php ve_get_group_of_companies_navigation() ?>
	  </ul>
	</li>
</ul>
<?php
}

/**
 * ######################## 6.3 New Layout - Generate sub-navigation section to companies section:
 */

function ve_get_company_navigation() {

	/**
	 * Arguments for get posts:
	 */
	
	$args = array(
		'orderby'			=>	'title',
		'order'				=>	'ASC',
		'post_type'			=>	'companies',
		'post_status'		=>	'publish',
		'posts_per_page'	=>	-1
		);
	$companies = get_posts( $args );

	foreach ( $companies as $company ) {
		$company_url = get_permalink($company->ID);
		$company_title = $company->post_title;
		?>
		<li>
			<a class="turquoise-hover" href="<?php echo $company_url; ?>"><?php echo $company_title ?></a>
		</li>
	<?php
	}
}

/**
 * ######################## 6.4 New Layout - Generate sub-navigation section to group of companies (partnership) section:
 */

function ve_get_group_of_companies_navigation() {

	/**
	 * Arguments for get posts:
	 */
	
	$args = array(
		'orderby'			=>	'title',
		'order'				=>	'ASC',
		'post_type'			=>	'group_of_companies',
		'post_status'		=>	'publish',
		'posts_per_page'	=>	-1
		);
	$companies = get_posts( $args );

	foreach ( $companies as $company ) {
		$company_url = get_permalink($company->ID);
		$company_title = $company->post_title;
		?>
		<li>
			<a class="purple-hover" href="<?php echo $company_url; ?>"><?php echo $company_title ?></a>
		</li>
	<?php
	}
}

/**
 * ######################## 6.5 New Layout - company or group-of-companies title in front of the information section title
 * >> Company = purple text
 * >> Group of companies = turquoise text
 */

function get_pre_information_title(){
	if ( get_post_type() == 'companies' ) {	/* Companies = purple text */
		?>
		<span class="purple-text"><?php echo get_the_title() ?></span> / 
		<?php
	}
	elseif ( get_post_type() == "group_of_companies") { /* Group_of_companies = turquoise text */
		?>
		<span class="turquoise-text"><?php echo get_the_title() ?></span> /
		<?php
	}
	else {} /* Do nothing */
}