<?php
/*
Plugin Name: Rickroll
Plugin URI: http://halelf.org/plugins/rickroll/
Description: Rickroll Your Embeded Videos
Author: Mika 'Ipstenu' Epstein
Version: 2.1
Author URI: http://halfelf.org

Copyright 2012-16 Mika Epstein (email: ipstenu@halfelf.org)

This file is part of Rickroll, a plugin for WordPress.

Rickroll is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

Rickroll is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WordPress.  If not, see <http://www.gnu.org/licenses/>.

*/

add_filter('embed_oembed_html','ippy_rickroll',10,3);

function ippy_rickroll($html, $url, $args) {

	$default = '<iframe width="420" height="315" src="http://www.youtube.com/embed/oHg5SJYRHA0?fs=1&amp;feature=oembed&amp;showinfo=0" frameborder="0" allowfullscreen=""></iframe>';
	
	// Youtube
	if ( strstr($url, 'youtube.com') ) {
	    $url_string = parse_url($url, PHP_URL_QUERY);
	    parse_str($url_string, $id);
	    $html = str_replace( $id['v'], 'oHg5SJYRHA0', $html);
	}
	
	// Vimeo
	elseif ( strstr($url, 'vimeo.com' ) ) {
		$pattern = '/video\/(\d+)\"/i';
		$html = preg_replace( $pattern , 'video/2619976"', $html);
	}
	
	// Leave these alone
	elseif ( strstr($url, 'twitter.com' ) || strstr($url, 'scribd.com' ) || strstr($url, 'photobucket.com' ) || strstr($url, 'polldaddy.com' ) || strstr($url, 'smugmug.com' ) ) {
		$html = $html;
	}
	
	// Everyone else
	else { $html = $default; }
	
	return $html;
}

// donate link on manage plugin page

add_filter('plugin_row_meta', 'ippy_rickroll_donate_link', 10, 2);
function ippy_scc_donate_link($links, $file) {
    if ($file == plugin_basename(__FILE__)) {
        $donate_link = '<a href="https://store.halfelf.org/donate/">Donate</a>';
        $links[] = $donate_link;
    }
    return $links;
}