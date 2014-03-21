<?php
/*
Plugin Name: WordPress Template Selector
Version: 1.0
Plugin URI: 
Description: Select a specific theme & template for your page, post or custom post type
Author: Timothy Wood @codearachnid
Author URI: http://www.imaginesimplicity.com/
Text Domain: wp-theme-select
Domain Path: /lang/
License: GPL v3

WordPress Template Selector
Copyright (C) 2014, Timothy Wood - tim@imaginesimplicity.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
/**
 * @package Main
 */

if ( !defined( 'ABSPATH' ) )
	// header( 'HTTP/1.0 403 Forbidden' );
	die( '-1' );

add_action( 'plugins_loaded', 'wts_plugins_loaded' );
function wts_plugins_loaded(){
	add_action( 'admin_enqueue_scripts', 'wts_admin_enqueue_scripts' );
	$settings = include 'class/settings.php';
	$columns = include 'class/columns.php';
	
}

function wts_admin_enqueue_scripts(){
	$plugin_data = get_plugin_data( __FILE__ );
	wp_enqueue_style( WTS_Settings::$column_key . '-style', plugins_url( WTS_Settings::$column_key . '.css' , __FILE__ ), array(), $plugin_data['Version'] );
	wp_enqueue_script( WTS_Settings::$column_key . '-script', plugins_url( WTS_Settings::$column_key . '.js' , __FILE__ ), array( 'jquery' ), $plugin_data['Version'], true );
}
