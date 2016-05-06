<?php

/**
 * Plugin Name: Custom CSS by PressBro
 * Plugin URI: https://pressbro.com/plugins/custom-css
 * Description: This plugin allows you to easily write custom CSS to edit the look and feel of your site. 
 * Version: 1.1.0
 * Author: PressBro
 * Author URI: https://pressbro.com
 * License: GPLv2 or later
 */

/**
 * Define some things
 */
$pb_upload_dir = wp_upload_dir();

/**
 * If we're in admin ... 
 */
if(is_admin()): 

	/**
	 * We store the code in a file at wp-content/uploads/pressbro/custom-css/style.css and 
	 * if the file does not exist, or the folder, create it and fill the file with nothing.
	 */
	if(!file_exists($pb_upload_dir['basedir'] . '/pressbro/custom-css/style.css')) {

		$create_folder = @wp_mkdir_p($pb_upload_dir['basedir'] . '/pressbro/custom-css');
		$write_file = @file_put_contents($pb_upload_dir['basedir'] . '/pressbro/custom-css/style.css', '');
		
		if(!$create_folder || !$write_file) {

			// only show the notice on the plugin page
			if($pagenow === 'themes.php' && !empty($_GET['page']) && $_GET['page'] === 'pressbro-custom-css') {

				add_action('admin_notices', 'pb_no_permission_notice');

			}

		}

	}

	/**
	 * No write permissions error
	 */
	function pb_no_permission_notice() {

		$notice = '<div class="error">';
		$notice .= '<p>' . _e('Could not create the <code>pressbro/custom-css</code> directory in the uploads directory. Make sure you set the right permissions or the plugin will not work.', 'pressbro-custom-css') . '</p>';
		$notice .= '</div>';

	}

	/**
	 * Register menu entry under Appearance
	 */
	function pb_custom_css_menu_entry() {

		add_theme_page('Custom CSS', 'Custom CSS', 'manage_options', 'pressbro-custom-css', 'pb_custom_css_admin_page');

	}

	add_action('admin_menu', 'pb_custom_css_menu_entry');

	/**
	 * Load our styles and scripts
	 */
	function pb_custom_css_scripts($hook) {

		if($hook === 'appearance_page_pressbro-custom-css') {

			wp_register_style('pressbro-custom-css-style', plugin_dir_url(__FILE__) . 'css/style.css');
			wp_register_script('pressbro-custom-css-ace', plugin_dir_url(__FILE__) . 'js/ace/ace.js', array(), false, true);
			wp_register_script('pressbro-custom-css-js', plugin_dir_url(__FILE__) . 'js/pressbro-custom-css.js', array(), false, true);

			wp_enqueue_style('pressbro-custom-css-style');
			wp_enqueue_script('pressbro-custom-css-ace');
			wp_enqueue_script('pressbro-custom-css-js');

		}

	}

	add_action('admin_enqueue_scripts', 'pb_custom_css_scripts');

	/**
	 * Editing page
	 */
	function pb_custom_css_admin_page() {

		$html = '<div class="wrap">';
		$html .= '<h1>' . __('Custom CSS', 'pressbro-custom-css');
		$html .= '<a href="javascript:;" id="pb-custom-css-update" class="hide-if-no-js page-title-action">' . __('Update', 'pressbro-custom-css') . '</a>';
		$html .= '<span class="pb-custom-css-font-size-wrap"><a href="javascript:;" id="pb-custom-css-bigger-font-size" class="pb-custom-css-font-size-btn">' . __('<i class="fa fa-plus-circle"></i>', 'pressbro-custom-css') . '</a>';
		$html .= '<a href="javascript:;" id="pb-custom-css-smaller-font-size" class="pb-custom-css-font-size-btn">' . __('<i class="fa fa-minus-circle"></i>', 'pressbro-custom-css') . '</a></span>';
		$html .= '<span class="pressbro-custom-css-update-status"></span>';
		$html .= '</h1>';
		$html .= '<div id="pressbro-custom-css-columns">';
		$html .= '<div id="pressbro-custom-css-editor"></div>';
		$html .= '<div id="pressbro-custom-css-sidebar">';
		$html .= '<p>';
		$html .= '<strong>' . __('Hint:', 'pressbro-custom-css') . '</strong> ' . __('Press ctrl/cmd+s to save.', 'pressbro-custom-css');
		$html .= '<br><br>';
		$html .= '<strong>' . __('Note:', 'pressbro-custom-css') . '</strong> ' . __('If you are using a caching plugin, you may need to clear your cache for changes to have effect.', 'pressbro-custom-css');
		$html .= '</p>';
		$html .= '<div class="credit">Custom CSS <em>' . __('by', 'pressbro-custom-css') . '</em> <a href="https://pressbro.com">PressBro</a></div>';	
		$html .= '</div>';
		$html .= '<div class="pressbro-custom-css-clearfix"></div>';
		$html .= '</div>';
		$html .= '</div>';

		echo $html;

	}

	/**
	 * Get code (a wrapper for `pb_custom_css_get_contents()` for AJAX calls)
	 */
	function pb_custom_css_get_code() {

		if(is_user_logged_in()) {

			$contents = pb_custom_css_get_contents();

			echo $contents;

		}

		wp_die();

	}

	add_action('wp_ajax_pb_custom_css_get', 'pb_custom_css_get_code');

	/**
	 * Update code
	 */
	function pb_custom_css_update_code() {

		global $pb_upload_dir;

		if(is_user_logged_in()) {

			// We're only writing to a non-executing .css file
			// Also, let's not forget that only the administrator has access to this plugin.
			$contents = esc_html($_POST['pb_custom_css_contents']);

			// If the content is empty, fill it with a space so the file actually would get written
			if($contents == '') {

				$contents = ' ';

			}

			// Write to file
			$write_file = @file_put_contents($pb_upload_dir['basedir'] . '/pressbro/custom-css/style.css', $contents);

			if($write_file) {

				echo':)';

			} else {

				echo':(';

			}

			wp_die();

		} else {

			echo 'forbidden';

		}

	}

	add_action('wp_ajax_pb_custom_css_update', 'pb_custom_css_update_code');

endif;

/**
 * Get contents
 */
function pb_custom_css_get_contents() {

	global $pb_upload_dir;

	if(file_exists($pb_upload_dir['basedir'] . '/pressbro/custom-css/style.css')) {

		return file_get_contents($pb_upload_dir['basedir'] . '/pressbro/custom-css/style.css');

	}

	return false;

}

/**
 * Append code to <head></head>
 */
function pb_custom_css_append() {

	// Get the contents
	$css = pb_custom_css_get_contents();

	if($css) {

		$append = '<style type="text/css" id="pressbro-custom-css">';
		$append .= esc_html($css);
		$append .= '</style>';

		echo $append;

	}

}

add_action('wp_head', 'pb_custom_css_append');