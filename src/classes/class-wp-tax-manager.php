<?php
/**
 * Easy Referral for WooCommerce - WordPress Tax
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Thanks to IT
 */

namespace ThanksToIT\ERWC\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'ThanksToIT\ERWC\WordPress\WP_Tax_Manager' ) ) {

	class WP_Tax_Manager {

		/**
		 * create_terms.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param array $args
		 */
		function create_terms( $args = array() ) {
			$args = wp_parse_args( $args, array(
				'tax_id'          => '',
				'terms'           => array(),
				'plugin_filepath' => '',
				'option_name'     => $args . '_' . 'terms',
				'only_once'       => true
			) );

			$tax_id = $args['tax_id'];
			register_taxonomy( $tax_id, '', array() );
			$terms       = $args['terms'];
			$option_name = $args['option_name'];
			if ( count( get_option( $option_name, array() ) > 0 ) ) {
				return;
			}
			$terms_ids = array();
			foreach ( $terms as $term ) {
				$response = $this->add_term( $term, $tax_id );
				if ( ! is_wp_error( $response ) ) {
					$terms_ids[] = $response['term_id'];
				}
			}

			if ( $args['only_once'] ) {
				update_option( $option_name, $terms_ids );
			}
		}

		/**
		 * add_term.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param $term
		 * @param $tax_id
		 *
		 * @return array|\WP_Error
		 */
		function add_term( $term, $tax_id ) {
			return wp_insert_term(
				$term['label'],
				$tax_id,
				array(
					'slug'        => $term['slug'],
					'description' => isset ( $pos['description'] ) ? $term['description'] : ''
				)
			);
		}

	}
}