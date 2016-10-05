<?php
/*
 Plugin Name: BEA Template Vars
 Version: 0.0.1
 Plugin URI: http://www.beapi.fr
 Description: Easily pass vars through a template and reuse them.
 Author: BE API Technical team
 Author URI: http://www.beapi.fr
 Domain Path: languages
 Text Domain: bea-template-vars
 
 ----
 
 Copyright 2016 BE API Technical team (human@beapi.fr)
 
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 
 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

class Bea_Template_Part_Var {
	/**
	 * @var Bea_Template_Part_Var
	 * @author Maxime Culea
	 */
	public static $instance;

	/**
	 * Vars to store
	 *
	 * @var array
	 * @author Maxime Culea
	 */
	private $vars = array();

	/**
	 * Private
	 */
	private function __construct() {}

	/**
	 * @return Bea_Template_Part_Var
	 * @author Nicolas Juen
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new Bea_Template_Part_Var();
		}

		return self::$instance;
	}

	/**
	 * @param        $slug
	 * @param        $key
	 * @param string $value
	 *
	 * @return bool
	 */
	public function add_var( $slug, $key, $value = '' ) {
		$this->vars[ $slug ][ $key ] = $value;

		return true;
	}

	/**
	 * @param string $slug
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get_var( $slug = '', $key = '' ) {
		return isset( $this->vars[ $slug ][ $key ] ) ? $this->vars[ $slug ][ $key ] : null;
	}

	/**
	 * @param string $slug
	 *
	 * @return mixed
	 */
	public function get_vars( $slug = '' ) {
		return isset( $this->vars[ $slug ] ) ? $this->vars[ $slug ] : null;
	}
}

/**
 * @param        $slug
 * @param        $key
 * @param string $value
 *
 * @use Bea_Template_Part_Var
 */
function bea_add_template_var( $slug, $key, $value = '' ) {
	Bea_Template_Part_Var::get_instance()->add_var( $slug, $key, $value );
}

/**
 * Add vars to a template
 *
 * @author Maxime Culea
 *
 * @param       $slug
 * @param array $data : associative array of key => value
 */
function bea_add_template_vars( $slug, array $data ) {
	if ( empty( $data ) ) {
		return;
	}
	if ( count( $data ) == 1 ) {
		Bea_Template_Part_Var::get_instance()->add_var( $slug, $data['key'], $data['value'] );
	}
	foreach ( $data as $key => $value ) {
		Bea_Template_Part_Var::get_instance()->add_var( $slug, $key, $value );
	}
}

/**
 * @param $slug
 * @param $key
 *
 * @use Bea_Template_Part_Var
 *
 * @return string
 */
function bea_get_template_var( $slug, $key ) {
	return Bea_Template_Part_Var::get_instance()->get_var( $slug, $key );
}

/**
 * Get the templates vars
 *
 * @author Maxime Culea
 *
 * @param $slug
 * @param $key_or_keys : single key or array of keys
 *
 * @use    Bea_Template_Part_Var
 *
 * @return array
 */
function bea_get_template_vars( $slug, $key_or_keys ) {
	if ( empty( $key_or_keys ) ) {
		return array();
	}
	if ( ! is_array( $key_or_keys ) ) {
		return array( $key_or_keys => Bea_Template_Part_Var::get_instance()->get_var( $slug, $key_or_keys ) );
	}
	$values = [];
	foreach ( $key_or_keys as $key ) {
		$values[ $key ] = Bea_Template_Part_Var::get_instance()->get_var( $slug, $key );
	}

	return $values;
}
