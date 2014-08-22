<?php
/**
 * Plugin Name: WP API ACF options
 * Description: Extending the WP JSON REST API to handle data administered using Advanced Custom Fields options data
 * Author: Björn Folbert for First Flight Communication
 * Author URI: http://firstflight.se
 * Version: 1.0
 */

/*  Copyright 2014  First Flight Communication  (email : bjorn@firstflight.se)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * [wp_api_acf_options_api_init description]
 * @return [type] [description]
 */
function wp_api_acf_options_api_init() {

  global $wp_api_acf_options;

  $wp_api_acf_options = new WP_API_AcfOptions();
  add_filter( 'json_endpoints', array( $wp_api_acf_options, 'register_routes' ) );

}
add_action( 'wp_json_server_before_serve', 'wp_api_acf_options_api_init' );

/**
 *
 */
class WP_API_AcfOptions {

  /**
   * @param $routes
   * @return mixed
   */
  public function register_routes( $routes ) {

      $routes['/acf/options'] = array(
        array( array( $this, 'get_options'), WP_JSON_Server::READABLE )
      );

      return $routes;

    }

    /**
     * Outputs a json string with all the data handled by option pages for ACF.
     * Note that ACF provides no way of getting data for a specific options page
     * and thus we have to fetch and return all the data.
     * @return [type] [description]
     */
    public function get_options() {

      header('Content-type: application/json');
      echo json_encode(get_fields('option'));
      die();

    }

}