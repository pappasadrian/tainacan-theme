<?php

/**
 * Functions that register the options for the customizer
 * related to the color scheme
 * 
 */
if ( !function_exists('tainacan_interface_customize_register_colors') ) {

	function tainacan_interface_customize_register_colors( $wp_customize ) {

		$color_scheme = tainacan_get_color_scheme();
	
		/**
		 * Remove the core header textcolor control, as it shares the main text color.
		 */
		$wp_customize->remove_control( 'header_textcolor' );

		/**
		 * Add color scheme setting and control.
		 */
		$wp_customize->add_setting( 'tainacan_color_scheme', array(
			'type'       		=> 'theme_mod',
			'default'           => 'default',
			'sanitize_callback' => 'tainacan_sanitize_color_scheme',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'tainacan_color_scheme', array(
			'label'    => __( 'Choose a Color Scheme', 'tainacan-interface' ),
			'section'  => 'colors',
			'type'     => 'select',
			'choices'  => tainacan_get_color_scheme_choices(),
			'priority' => 1,
		) );

		/**
		 * Add link color setting and control.
		 */
		$wp_customize->add_setting( 'tainacan_link_color', array(
			'type'       		=> 'theme_mod',
			'default'           => $color_scheme[2],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tainacan_link_color', array(
			'label'       => __( 'Or pick any color', 'tainacan-interface' ),
			'section'     => 'colors',
		) ) );

		$wp_customize->add_setting( 'tainacan_tooltip_color', array(
			'type'       		=> 'theme_mod',
			'default'           => $color_scheme[3],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tainacan_tooltip_color', array(
			'label'       => __( 'Tooltip Color', 'tainacan-interface' ),
			'section'     => 'colors',
		) ) );

	}
	add_action( 'customize_register', 'tainacan_interface_customize_register_colors', 11 );
}


/**
 * Registers color schemes for Tainacan Interface theme.
 *
 * Can be filtered with {@see 'tainacan_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Main Background Color.
 * 2. Page Background Color.
 * 3. Link Color.
 * 4. Tooltip.
 *
 * @since Tainacan Interface theme
 *
 * @return array An associative array of color scheme options.
 */
function tainacan_get_color_schemes() {
	/**
	 * Filter the color schemes registered for use with Tainacan Interface theme.
	 *
	 * The default schemes include 'default', 'dark', 'gray', 'red', and 'yellow'.
	 *
	 * @since Tainacan Interface theme
	 *
	 * @param array $schemes {
	 *     Associative array of color schemes data.
	 *
	 *     @type array $slug {
	 *         Associative array of information for setting up the color scheme.
	 *
	 *         @type string $label  Color scheme label.
	 *         @type array  $colors HEX codes for default colors prepended with a hash symbol ('#').
	 *                              Colors are defined in the following order: Main background, page
	 *                              background, link, main text, secondary text.
	 *     }
	 * }
	 */
	return apply_filters( 'tainacan_color_schemes', array(
		'default' => array(
			'label'  => __( 'Default', 'tainacan-interface' ),
			'colors' => array(
				'#1a1a1a', //background
				'#ffffff', //background page
				'#298596', //link
				'#e6f6f8', //tooltip
			),
		),
		'carmine' => array(
			'label'  => __( 'Carmine', 'tainacan-interface' ),
			'colors' => array(
				'#262626', //background
				'#ffffff', //background page
				'#8c442c', //link
				'#e6d3cd', //tooltip
			),
		),
		'cherry' => array(
			'label'  => __( 'Cherry', 'tainacan-interface' ),
			'colors' => array(
				'#616a73', //background
				'#ffffff', //background page
				'#A12B42', //link
				'#e9cbd1', //tooltip
			),
		),
		'mustard' => array(
			'label'  => __( 'Mustard', 'tainacan-interface' ),
			'colors' => array(
				'#ffffff', //background
				'#ffffff', //background page
				'#754E24', //link
				'#f0e1cf', //tooltip
			),
		),
		'mintgreen' => array(
			'label'  => __( 'Mint Green', 'tainacan-interface' ),
			'colors' => array(
				'#ffffff', //background
				'#ffffff', //background page
				'#255F56', //link
				'#d4efe9', //tooltip
			),
		),
		'darkturquoise' => array(
			'label'  => __( 'Dark Turquoise', 'tainacan-interface' ),
			'colors' => array(
				'#ffffff', //background
				'#ffffff', //background page
				'#205E6F', //link
				'#cbe0e5', //tooltip
			),
		),
		'turquoise' => array(
			'label'  => __( 'Turquoise', 'tainacan-interface' ),
			'colors' => array(
				'#ffffff', //background
				'#ffffff', //background page
				'#185F6D', //link
				'#cdecef', //tooltip
			),
		),
		'blueheavenly' => array(
			'label'  => __( 'Blue Heavenly', 'tainacan-interface' ),
			'colors' => array(
				'#ffffff', //background
				'#ffffff', //background page
				'#1D5C86', //link
				'#d3e6f2', //tooltip
			),
		),
		'purple' => array(
			'label'  => __( 'Purple', 'tainacan-interface' ),
			'colors' => array(
				'#ffffff', //background
				'#ffffff', //background page
				'#4751a3', //link
				'#d1d4e7', //tooltip
			),
		),
		'violet' => array(
			'label'  => __( 'Violet', 'tainacan-interface' ),
			'colors' => array(
				'#ffffff', //background
				'#ffffff', //background page
				'#955ba5', //link
				'#e4d7e8', //tooltip
			),
		),
	) );
}

/**
 * Binds the JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 *
 * @since Tainacan Interface theme
 */
function tainacan_customize_control_js() {
	wp_enqueue_script( 'tainacan-color-scheme-control', get_template_directory_uri() . '/assets/js/color-scheme-control.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), TAINACAN_INTERFACE_VERSION , true );
	wp_localize_script( 'tainacan-color-scheme-control', 'TainacanColorScheme', tainacan_get_color_schemes() );
}
add_action( 'customize_controls_enqueue_scripts', 'tainacan_customize_control_js' );


if ( ! function_exists( 'tainacan_get_color_scheme' ) ) :
	/**
	 * Retrieves the current Tainacan Interface theme color scheme.
	 *
	 * Create your own tainacan_get_color_scheme() function to override in a child theme.
	 *
	 * @since Tainacan Interface theme
	 *
	 * @return array An associative array of either the current or default color scheme HEX values.
	 */
	function tainacan_get_color_scheme() {
		$color_scheme_option = get_theme_mod( 'tainacan_color_scheme', 'default' );
		$link_color = get_theme_mod( 'tainacan_link_color', 'default' ); // sanitized upon save
		$tooltip_color = get_theme_mod( 'tainacan_tooltip_color', 'default' ); // sanitized upon save
		$color_schemes       = tainacan_get_color_schemes();

		if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
			$return = $color_schemes[ $color_scheme_option ]['colors'];
		}

		$return = $color_schemes['default']['colors'];
		$return[2] = $link_color; // override link color with the one from color picker
		$return[3] = $tooltip_color;
		return $return;

	}
endif; // tainacan_get_color_scheme



if ( ! function_exists( 'tainacan_get_color_scheme_choices' ) ) :
	/**
	 * Retrieves an array of color scheme choices registered for Tainacan Interface theme.
	 *
	 * Create your own tainacan_get_color_scheme_choices() function to override
	 * in a child theme.
	 *
	 * @since Tainacan Interface theme
	 *
	 * @return array Array of color schemes.
	 */
	function tainacan_get_color_scheme_choices() {
		$color_schemes                = tainacan_get_color_schemes();
		$color_scheme_control_options = array();

		foreach ( $color_schemes as $color_scheme => $value ) {
			$color_scheme_control_options[ $color_scheme ] = $value['label'];
		}

		return $color_scheme_control_options;
	}
endif; // tainacan_get_color_scheme_choices


if ( ! function_exists( 'tainacan_sanitize_color_scheme' ) ) :
	/**
	 * Handles sanitization for Tainacan Interface theme color schemes.
	 *
	 * Create your own tainacan_sanitize_color_scheme() function to override
	 * in a child theme.
	 *
	 * @since Tainacan Interface theme
	 *
	 * @param string $value Color scheme name value.
	 * @return string Color scheme name.
	 */
	function tainacan_sanitize_color_scheme( $value ) {
		$color_schemes = tainacan_get_color_scheme_choices();

		if ( ! array_key_exists( $value, $color_schemes ) ) {
			return 'default';
		}

		return $value;
	}
endif; // tainacan_sanitize_color_scheme



/**
 * Enqueues front-end CSS for color scheme.
 *
 * @since Tainacan Interface theme
 *
 * @see wp_add_inline_style()
 */
function tainacan_color_scheme_css() {

	$color_scheme = tainacan_get_color_scheme();

	// Convert main text hex color to rgba.
	$color_textcolor_rgb = tainacan_hex2rgb( $color_scheme[2] );

	// If the rgba values are empty return early.
	if ( empty( $color_textcolor_rgb ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$colors = array(
		'background_color'      => $color_scheme[0],
		'page_background_color' => $color_scheme[1],
		'tainacan_link_color'            => $color_scheme[2],
		'tainacan_tooltip_color'            => $color_scheme[3],
		'backtransparent'			=> vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.3)', $color_textcolor_rgb ),
	);

	$color_scheme_css = tainacan_get_color_scheme_css( $colors );

	echo '<style type="text/css" id="custom-theme-css">' .
	$color_scheme_css . '</style>';
}
add_action( 'wp_head', 'tainacan_color_scheme_css' );

/**
 * Returns CSS for the color schemes.
 *
 * @since Tainacan Interface theme
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function tainacan_get_color_scheme_css( $colors ) {
	$colors = wp_parse_args( $colors, array(
		'background_color'      => '',
		'page_background_color' => '',
		'tainacan_link_color'            => '',
		'tainacan_tooltip_color'            => '',
		'backtransparent'           => '',
	) );

	$filter = ( has_filter( 'tainacan-customize-css-class' ) ) ? apply_filters( 'tainacan-customize-css-class', $colors ) : '';
	return <<<CSS
	/* Color Scheme */
	
	.has-default-color { 
		color: {$colors['tainacan_link_color']} !important;
	}
	.has-default-background-color {
		background-color: {$colors['tainacan_link_color']} !important;
	}

	body a,
	body a:hover, 
	.tainacan-title-page ul li a:hover, 
	.tainacan-list-post .blog-content h3 ,
	.tainacan-list-post .blog-content h3 a:hover,
	#comments .list-comments .media .media-body .comment-reply-link,
	#comments .list-comments .media .media-body .comment-edit-link {
		color: {$colors['tainacan_link_color']};
	}
	.tainacan-list-post .blog-content h4 {
		background-color: {$colors['tainacan_tooltip_color']} !important;
	}
	.tainacan-title-page ul li, 
	.tainacan-title-page ul li a,
	.tainacan-title-page ul li h1,
	#menubelowHeader .menu-item a::after,
	.menu-shadow button[data-toggle='dropdown']::after{
		color: {$colors['tainacan_link_color']} !important;
	}
	.tainacan-single-post #comments,
	.tainacan-title-page,
	.tainacan-list-post .blog-post .blog-content .blog-read,
	.tainacan-list-post .blog-post .blog-content .blog-read:hover,
	.tainacan-content .wp-block-button:not(.is-style-outline) a,
	.tainacan-content .wp-block-button:not(.is-style-outline) a:hover {
		border-color: {$colors['tainacan_link_color']} !important;
	}
	.tainacan-list-post .blog-post .blog-content .blog-read,
	.tainacan-list-post .blog-post .blog-content .blog-read:hover,
	.tainacan-content .wp-block-button:not(.is-style-outline):not(.has-background) a,
	.tainacan-content .wp-block-button:not(.is-style-outline):not(.has-background) a:hover {
		background-color: {$colors['tainacan_link_color']};
	}
	.tainacan-content .wp-block-button.is-style-outline a:not(.has-text-color),
	.tainacan-content .wp-block-button.is-style-outline a:hover:not(.has-text-color) {
		color: {$colors['tainacan_link_color']} !important;
	}

	.tainacan-content .wp-block-tainacan-carousel-items-list .swiper-button-prev svg, 
	.tainacan-content .wp-block-tainacan-carousel-items-list .swiper-button-next svg,
	.tainacan-content .wp-block-tainacan-carousel-collections-list .swiper-button-prev svg, 
	.tainacan-content .wp-block-tainacan-carousel-collections-list .swiper-button-next svg,
	.tainacan-content .wp-block-tainacan-carousel-terms-list .swiper-button-prev svg, 
	.tainacan-content .wp-block-tainacan-carousel-terms-list .swiper-button-next svg {
		fill: {$colors['tainacan_link_color']} !important;
	}
	.tainacan-content .wp-block-tainacan-facets-list .show-more-button {
		background-color: {$colors['tainacan_link_color']} !important;
	}
	.wp-block-tainacan-facets-list ul.facets-list.facets-layout-cloud li.facet-list-item:hover a,
	.wp-block-tainacan-facets-list ul.facets-list-edit.facets-layout-cloud li.facet-list-item:hover a {
		color: {$colors['tainacan_link_color']} !important;
	}

	.tainacan-single-post .single-item-collection--attachments-next,
	.tainacan-single-post .single-item-collection--attachments-prev {
		color: {$colors['tainacan_link_color']} !important;
	}

	.tainacan-single-post .single-item-collection .single-item-collection--gallery-items .slick-current img {
		border-bottom: 4px solid {$colors['tainacan_link_color']} !important;
	}

	.tainacan-single-post .single-item-collection .tainacan-item-file-download {
		background-color: {$colors['tainacan_link_color']} !important;
	}

	.tainacan-single-post .title-content-items {
		color: {$colors['tainacan_link_color']} !important;
	}

	/* Header Menu */
	nav .dropdown-menu .dropdown-item:hover {
		background-color: {$colors['backtransparent']};
	}
	nav.menu-belowheader #menubelowHeader > ul > li.menu-item a:hover::before {
		background-color: {$colors['tainacan_link_color']};
	}
	nav.menu-belowheader #menubelowHeader ul > li.current_page_item > a, 
	nav.menu-belowheader #menubelowHeader ul > li.current-menu-item > a {
		border-color: {$colors['tainacan_link_color']} !important;
	}
	nav.menu-belowheader #menubelowHeader ul.show > li.current_page_item > a, 
	nav.menu-belowheader #menubelowHeader ul.show > li.current-menu-item > a {
		border-color: {$colors['tainacan_link_color']};
		background-color: {$colors['backtransparent']};
	}

	.tainacan-single-post #comments .title-leave,
	.tainacan-single-post article .title-content-items{
		color: {$colors['tainacan_link_color']} !important;
	}
	footer hr.bg-scooter {
		background-color: {$colors['tainacan_link_color']} !important;
	}

	/* Colored version of footer */
	footer.tainacan-footer-colored {
		background-color: {$colors['tainacan_link_color']} !important;
	}
	footer.tainacan-footer-colored  hr.bg-scooter {
		background-color: {$colors['tainacan_tooltip_color']} !important;
	}
	footer.tainacan-footer-colored a,
	footer.tainacan-footer-colored .tainacan-footer-widgets-area .tainacan-side ul li a,
	footer.tainacan-footer-colored .tainacan-footer-widgets-area .tainacan-side ol li a,
	footer.tainacan-footer-colored .tainacan-side .textwidget,
	footer.tainacan-footer-colored .tainacan-side .recentcomments,
	footer.tainacan-footer-colored .tainacan-side .calendar_wrap,
	footer.tainacan-footer-colored .tainacan-side ul li,
	footer.tainacan-footer-colored .tainacan-side div li,
	footer.tainacan-footer-colored .tainacan-side div,
	footer.tainacan-footer-colored .tainacan-side ul,
	footer.tainacan-footer-colored .tainacan-side li,
	footer.tainacan-footer-colored .tainacan-footer-info .tainacan-powered {
		color: {$colors['tainacan_tooltip_color']} !important;
	}
    @media screen and (max-width: 991.98px) {
		footer.tainacan-footer-colored .tainacan-side {
			border-top-color: {$colors['tainacan_tooltip_color']} !important;
		}
	}

	/* Blockquote */
	.wp-block-quote:not(.is-large):not(.is-style-large) {
		border-left-color: {$colors['tainacan_link_color']} !important;
	}

	/* Separator */ 
    .wp-block-separator:not(.has-background-color) {
		border-color: {$colors['tainacan_link_color']} !important;
	}
	.wp-block-separator.is-style-dots:not(.has-background-color)::before {
		color: {$colors['tainacan_link_color']} !important;
	}

	/* Pullquote */
    .wp-block-pullquote blockquote:not(.has-text-color) p {
		color: {$colors['tainacan_link_color']} !important;
	}
	.wp-block-pullquote:not(.is-style-solid-color)  {
		border-color: {$colors['tainacan_link_color']} !important;
	}

	/* Code */
    .wp-block-code code {
		color: {$colors['tainacan_link_color']} !important;
	}

	/* Extra title group class, that can be added for styling special headings */
	.wp-block-group.tainacan-group-heading h1:not(.has-text-color),
	.wp-block-group.tainacan-group-heading h2:not(.has-text-color),
	.wp-block-group.tainacan-group-heading h3:not(.has-text-color),
	.wp-block-group.tainacan-group-heading h4:not(.has-text-color) {
		color: {$colors['tainacan_link_color']} !important;
	}
	.wp-block-group.tainacan-group-heading hr.wp-block-separator {
		background-color: {$colors['tainacan_link_color']};
		border-color: {$colors['tainacan_link_color']};
	}

	/**
	* Tainacan Taxonomy Archive Page
	*/
	.page-header-taxonomy > .container-fluid > .page-header-content > .page-header-content-meta > .page-header-content-title {
		border-color: {$colors['tainacan_link_color']} !important;
	}
	.page-header-taxonomy > .container-fluid > .page-header-content > .page-header-content-meta > .page-header-content-title .page-header-title {
		color: {$colors['tainacan_link_color']};
	}

	/**
	* Tainacan Collections
	*/
	.tainacan-collection-list--simple-search .dropdown #dropdownMenuSorting::after, 
	.tainacan-collection-list--simple-search .dropdown #dropdownMenuViewMode::after {
		color: {$colors['tainacan_link_color']};
	}

	.tainacan-collection-list--simple-search .dropdown .dropdown-menu a:hover {
		background-color: {$colors['backtransparent']};
	}

	/**
	* Plugin Tainacan
	*/
	/* Selected Item background ------------------------------------------- */
	.table-container .table-wrapper table.tainacan-table tbody tr.selected-row,
	.table-container .table-wrapper table.tainacan-table tbody tr.selected-row .checkbox-cell .checkbox, 
	.table-container .table-wrapper table.tainacan-table tbody tr.selected-row .actions-cell .actions-container
	.tainacan-cards-container .selected-card .metadata-title,
	.tainacan-records-container .selected-record .metadata-title,
	.tainacan-grid-container .selected-grid-item.
	.tainacan-masonry-container .selected-masonry-item {
		background-color: {$colors['tainacan_link_color']};
	}
	.toast.is-secondary {
        background-color: {$colors['tainacan_link_color']};
	}
	/* // - Selected Item Title ------------------------------------------- */
	.table-container .table-wrapper table.tainacan-table tbody tr.selected-row has-text-secondary,
	.table-container .table-wrapper table.tainacan-table tbody tr.selected-row p,
	.tainacan-cards-container .selected-card .metadata-title p,
	.tainacan-records-container .selected-record .metadata-title p{
		color: {$colors['tainacan_link_color']} !important;
	}
	/* // - Selected Item Checkbox ------------------------------------------- */
	.table-container .table-wrapper table.tainacan-table tbody tr.selected-row checkbox-cell .b-checkbox.checkbox input[type="checkbox"]:checked + .check,
	.tainacan-cards-container .selected-card .card-checkbox .b-checkbox.checkbox input[type="checkbox"]:checked + .check,
	.tainacan-grid-container .selected-grid-item .grid-item-checkbox .b-checkbox.checkbox input[type="checkbox"]:checked + .check,
	.tainacan-masonry-container .selected-masonry-item .masonry-item-checkbox .b-checkbox.checkbox input[type="checkbox"]:checked + .check,
	.tainacan-records-container .selected-record .record-checkbox .b-checkbox.checkbox input[type="checkbox"]:checked + .check  {
		background-color: transparent;
		background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3Cpath style='fill:rgb(255,255,255)' d='M 0.04038059,0.6267767 0.14644661,0.52071068 0.42928932,0.80355339 0.3232233,0.90961941 z M 0.21715729,0.80355339 0.85355339,0.16715729 0.95961941,0.2732233 0.3232233,0.90961941 z'%3E%3C/path%3E%3C/svg%3E");
		border-color: {$colors['tainacan_link_color']} !important;
	}
	.tainacan-slide-main-view .slide-control-arrow .icon .tainacan-icon::before {
		color: {$colors['tainacan_link_color']};
	}
	.tainacan-slides-list #tainacan-slide-container .tainacan-slide-item.active-item img,
	.tainacan-slides-list #tainacan-slide-container .swiper-slide.swiper-slide-active img {
		border-bottom: 4px solid {$colors['tainacan_link_color']};
	}
	/** Abas no modal de termos */
	.tainacan-modal-content .tabs li.is-active a {
		border-bottom-color: {$colors['tainacan_link_color']};
	}
	/* Setinhas no mesmo modal */
	.tainacan-finder-columns-container a .tainacan-icon {
		color: {$colors['tainacan_link_color']};
	}

	/* Dropdown Arrow */
	.theme-items-list .dropdown .dropdown-trigger .button .icon, 
	.theme-items-list .autocomplete .dropdown-trigger .button .icon {
		color: {$colors['tainacan_link_color']};
	}

	/* Dropdown Active Item (for normal dropdown, autocomplete, taginput, etc... */
	.theme-items-list .dropdown .dropdown-menu .dropdown-content .dropdown-item.is-active, 
	.theme-items-list .dropdown .dropdown-menu .dropdown-content .has-link a.is-active, 
	.theme-items-list .dropdown .dropdown-menu .has-link .dropdown-content a.is-active, 
	.theme-items-list .autocomplete .dropdown-menu .dropdown-content .dropdown-item.is-active, 
	.theme-items-list .autocomplete .dropdown .dropdown-menu .dropdown-content .has-link a.is-active, 
	.theme-items-list .dropdown .autocomplete .dropdown-menu .dropdown-content .has-link a.is-active, 
	.theme-items-list .autocomplete .dropdown .dropdown-menu .has-link .dropdown-content a.is-active, 
	.theme-items-list .dropdown .autocomplete .dropdown-menu .has-link .dropdown-content a.is-active {
		background-color: {$colors['backtransparent']};
	}

	/* Document download button */
	.tainacan-single-post article .tainacan-content.single-item-collection .single-item-collection--document .tainacan-item-file-download {
		background-color: {$colors['tainacan_link_color']} !important;
	}

	/* Select Arrow */
	.theme-items-list .select:not(.is-loading)::after,
	.tainacan-modal-content .select:not(.is-loading)::after,
	button.link-style, 
	button.link-style:focus,
	button.link-style:hover {
		color: {$colors['tainacan_link_color']} !important;
	}

	/* Buefy's Numberinput */
	.theme-items-list .b-numberinput button .mdi::before,
	.tainacan-modal-content .b-numberinput button .mdi::before {
		color: {$colors['tainacan_link_color']} !important;
	}

	/* Anchor tag, links, buttons styled as links */
	.theme-items-list a, .theme-items-list a:hover,
	.tainacan-modal-content a, .tainacan-modal-content a:hover,
	.theme-items-list button.link-style, .theme-items-list button.link-style:hover,
	.tainacan-modal-content button.link-style, .tainacan-modal-content button.link-style:hover   {
		color: {$colors['tainacan_link_color']} !important;
	}

	/* Tooltip */
	.tooltip .tooltip-inner {
		background-color: {$colors['tainacan_tooltip_color']} !important;
	}
	.tooltip .tooltip-arrow {
		border-color: {$colors['tainacan_tooltip_color']} !important;
	}

	/* Colored text */
	.theme-items-list .has-text-secondary,
	.tainacan-modal-content .has-text-secondary {
		color: {$colors['tainacan_link_color']} !important;
	}

	/* Pagination icons and links */
	.theme-items-list .pagination-area .pagination .pagination-link, 
	.theme-items-list .pagination-area .pagination .pagination-previous, 
	.theme-items-list .pagination-area .pagination .pagination-next {
		color: {$colors['tainacan_link_color']} !important;
	}

	/* Datepicker */
	.theme-items-list .filter-item-forms .datepicker .datepicker-header a>span>i:before,
	.tainacan-modal-content .filter-item-forms .datepicker .datepicker-header a>span>i:before {
		color: {$colors['tainacan_link_color']} !important;
	} 
	.theme-items-list .filter-item-forms .datepicker .datepicker-table .datepicker-cell.is-selected,
	.theme-items-list .filter-item-forms .datepicker .datepicker-table .datepicker-cell.is-selected:hover,
	.tainacan-modal-content .filter-item-forms .datepicker .datepicker-table .datepicker-cell.is-selected,
	.tainacan-modal-content .filter-item-forms .datepicker .datepicker-table .datepicker-cell.is-selected:hover {
		background-color: {$colors['tainacan_link_color']} !important;
	}
	.theme-items-list .filter-item-forms .datepicker .datepicker-table .datepicker-cell.is-today,
	.theme-items-list .filter-item-forms .datepicker .datepicker-table .datepicker-cell.is-today:hover,
	.tainacan-modal-content .filter-item-forms .datepicker .datepicker-table .datepicker-cell.is-today,
	.tainacan-modal-content .filter-item-forms .datepicker .datepicker-table .datepicker-cell.is-today:hover {
		background-color: {$colors['tainacan_tooltip_color']} !important;
	}

	/* Outline Button */
	.theme-items-list .button.is-outlined,
	.tainacan-modal-content .button.is-outlined,
	.theme-items-list .button.is-outlined:hover,
	.tainacan-modal-content .button.is-outlined:hover {
		color: {$colors['tainacan_link_color']} !important;
	}

	/* Colored Button */
	.theme-items-list .button.is-secondary,
	.theme-items-list .button.is-secondary:hover, 
	.theme-items-list .button.is-secondary:focus {
		background: {$colors['tainacan_link_color']} !important;
	}

	/* Checkbox modal on finder columns */
	.tainacan-modal-content  .tainacan-li-checkbox-last-active,
	.tainacan-modal-content  .tainacan-li-checkbox-parent-active,
	.tainacan-modal-content  .tainacan-show-more:hover {
		background-color: {$colors['backtransparent']} !important;
	}

	/* Checkbox modal title and arrow*/
	.tainacan-modal-content h2,
	.tainacan-modal-content h3,
	.tainacan-modal-content .tainacan-icon-arrowright {
		color: {$colors['tainacan_link_color']} !important;
	}

	/* Advanced search criteria title */ 
	.advanced-search-criteria-title h1,
	.advanced-search-criteria-title h2 {
		color: {$colors['tainacan_link_color']} !important;
	} 

	/* Advanced search results title */ 
	.advanced-search-results-title h1 { 
		color: {$colors['tainacan_link_color']} !important; 
	}
	.advanced-search-results-title hr { 
		background-color: {$colors['backtransparent']} !important; 
	}

	/* Line above section titles */
	.tainacan-modal-title hr,
	.advanced-search-criteria-title hr {
		background-color: {$colors['tainacan_link_color']} !important;
	}

	/* Filter menu compress button */
	#filter-menu-compress-button,
	#filter-menu-compress-button-mobile {
		background-color: {$colors['backtransparent']} !important;
		color: {$colors['tainacan_link_color']} !important;
	}

	#filters-mobile-modal .modal-close::before,
	#filters-mobile-modal .modal-close::after {
		background-color: {$colors['tainacan_link_color']} !important;
	}

	.slide-control-arrow .icon .tainacan-icon::before {
		color: {$colors['tainacan_link_color']};
	}
	.metadata-menu .metadata-menu-header hr {
		background-color: {$colors['backtransparent']};
	}

	.slide-title-area .play-button .icon,
	.slide-title-area .play-button:hover .icon {
		border: 3px solid {$colors['tainacan_link_color']};
	}

	#return-to-top {
		background-color: {$colors['tainacan_link_color']};
	}

	.tainacan-media-component {
		--swiper-navigation-color: {$colors['tainacan_link_color']};
	}

	{$filter}
	
CSS;
}


/**
 * Outputs an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 *
 * @since Tainacan Interface theme
 */
function tainacan_color_scheme_css_template() {
	$colors = array(
		'background_color'      => '{{ data.background_color }}',
		'page_background_color' => '{{ data.page_background_color }}',
		'tainacan_link_color'            => '{{ data.tainacan_link_color }}',
		'tainacan_tooltip_color'            => '{{ data.tainacan_tooltip_color }}',
		'backtransparent'		=> '{{ data.backtransparent }}',
	);
	?>
	<script type="text/html" id="tmpl-tainacan-color-scheme">
		<?php echo tainacan_get_color_scheme_css( $colors ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'tainacan_color_scheme_css_template' );

/**
 * Enqueues front-end CSS for the link color.
 *
 * @since Tainacan Interface theme
 *
 * @see wp_add_inline_style()
 */
function tainacan_link_color_css() {
	$color_scheme    = tainacan_get_color_scheme();
	$default_color   = $color_scheme[2];
	$link_color = get_theme_mod( 'tainacan_link_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $link_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Link Color */
		body a, 
		.tainacan-title-page ul li, 
		.tainacan-title-page ul li a,
		.tainacan-title-page ul li a:hover, 
		.tainacan-list-post .blog-content h3 {
			color: %1$s !important;
		}
	';

	wp_add_inline_style( 'tainacan-style', sprintf( $css, $link_color ) );
}
add_action( 'wp_enqueue_scripts', 'tainacan_link_color_css', 11 );

/**
 * Enqueues front-end CSS for the main text color.
 *
 * @since Tainacan Interface theme
 *
 * @see wp_add_inline_style()
 */
function tainacan_tooltip_color_css() {
	$color_scheme    = tainacan_get_color_scheme();
	$default_color   = $color_scheme[3];
	$tooltip_color = get_theme_mod( 'tainacan_tooltip_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $tooltip_color === $default_color ) {
		return;
	}

	// Convert main text hex color to rgba.
	$tooltip_color_rgb = tainacan_hex2rgb( $tooltip_color );

	// If the rgba values are empty return early.
	if ( empty( $tooltip_color_rgb ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$border_color = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.2)', $tooltip_color_rgb );

	$css = '
		/* Custom Main Text Color */
		.tainacan-list-post .blog-post .blog-content .blog-read {
			color: %1$s !important;
		}
	';

	wp_add_inline_style( 'tainacan-style', sprintf( $css, $tooltip_color, $border_color ) );
}
add_action( 'wp_enqueue_scripts', 'tainacan_tooltip_color_css', 11 );