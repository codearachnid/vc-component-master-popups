<?php
/**
 *
 * @link              https://codearachnid.pro
 * @since             1.0.0
 * @package           Vc_Component_Master_Popups
 *
 * @wordpress-plugin
 * Plugin Name:       Master Popups for WPBakery
 * Plugin URI:        https://codearachnid.pro
 * Description:       Integrate Master Popups into WPBakery page builder elements. Fully integrates Popup and Inline shortcode options.
 * Version:           1.0.0
 * Author:            codearachnid @codearachnid
 * Author URI:        https://codearachnid.pro
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       vc-component-master-popups
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'VC_COMPONENT_MASTER_POPUPS_VERSION', '1.0.0' );

/**
 * Adds new shortcode "Master_Popups_say_hello" and registers it to
 * the Visual Composer plugin
 *
 */
if ( ! class_exists( 'Master_Popups_VC_Element' ) ) {

	class Master_Popups_VC_Element {

		/**
		 * Main constructor
		 */
		public function __construct() {

			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'mpp_popup', __CLASS__ . '::popup' );
				vc_lean_map( 'mpp_inline', __CLASS__ . '::inline' );
			}

		}
		
		private static function get_master_popups(){
			$popups = get_posts(array(
				'post_type' => 'master-popups',
				'meta_key' => 'mpp_status',
				'meta_value' => 'on'
			));
			$select_popups = [ 'Select a popup' => '' ];
			foreach($popups as $popup){
				$select_popups[ $popup->post_title ] = $popup->ID ;
			}
			return $select_popups;
		}

		public static function popup() {
			$select_popups = self::get_master_popups();
			return array(
				'name'        => esc_html__( 'Master Popups', 'locale' ),
				'description' => esc_html__( 'Embed a Master Popup button or trigger.', 'locale' ),
				'base'        => 'mpp_popup_vc_element',
				'params'      => array(
					array(
						'type' => 'dropdown',
						'heading' => __( 'Active Popups',  "my-text-domain" ),
						'param_name' => 'id',
						'value' => $select_popups,
						'description' => __( "Enter description.", "my-text-domain" )
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Button Text', 'locale' ),
						'param_name' => 'content',
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Button Type',  "my-text-domain" ),
						'param_name' => 'tag',
						'value' => [
							'SPAN' => 'span',
							'A' => 'a',
							'DIV' => 'div',
							'Button' => 'button',
						],
						'description' => __( "Enter description.", "my-text-domain" )
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Button Class', 'locale' ),
						'param_name' => 'class',
					),
				),
			);
		}

		public static function inline() {
			$select_popups = self::get_master_popups();
			return array(
				'name'        => esc_html__( 'Master Popups Inline', 'locale' ),
				'description' => esc_html__( 'Embed a Master Popup inline the content.', 'locale' ),
				'base'        => 'mpp_popup_vc_element',
				'params'      => array(
					array(
						'type' => 'dropdown',
						'heading' => __( 'Active Popups',  "my-text-domain" ),
						'param_name' => 'id',
						'value' => $select_popups,
						'description' => __( "Enter description.", "my-text-domain" )
					),
				),
			);
		}

	}

}
new Master_Popups_VC_Element;
