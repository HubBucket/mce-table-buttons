<?php
/**
 Plugin Name: MCE Table Buttons
 Plugin URI: http://www.cmurrayconsulting.com/software/wordpress-mce-table-buttons/
 Description: Add <strong>buttons for table editing</strong> to the WordPress WYSIWYG editor with this very <strong>light weight</strong> plug-in.    
 Version: 1.0.2
 Author: Jacob M Goldman (C. Murray Consulting)
 Author URI: http://www.cmurrayconsulting.com

    Plugin: Copyright 2009 C. Murray Consulting  (email : jake@cmurrayconsulting.com)

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
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action("admin_init","mce_table_buttons_setup");

function mce_table_buttons_setup() 
{
	if ( get_user_option('rich_editing') == 'true' ) 
	{
		add_filter( 'mce_external_plugins', 'add_mce_table_plugin' );
		add_filter( 'mce_buttons_3', 'mce_table_buttons' );
	}
}

function add_mce_table_plugin( $plugin_array ) 
{
   $plugin_array['table'] = WP_PLUGIN_URL . '/' . basename( dirname(__FILE__) ) .'/mce-table/editor_plugin.js';
   return $plugin_array;
}

function mce_table_buttons($buttons) 
{
   array_push( $buttons, "tablecontrols" );
   return $buttons;
}

// fix for improper save your changes requests

add_action( 'content_save_pre', 'mce_table_ender', 100 );

function mce_table_ender( $content )
{
	if ( substr( $content, -8 ) == '</table>' )
		$content = $content . "\n<br />";
		
	return $content;
}