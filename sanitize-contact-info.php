<?php
/*
Plugin Name: Contact Info Sanitizer
Plugin URI: https://github.com/cstrouse/sanitize-contact-info
Description: Removes email addresses, phone numbers, and website URLs from comments left by readers.
Author: Casey Strouse
Version: 1.0
Author URI: http://caseystrouse.com
*/

function sanitize_contact_info() {
	global $commentdata;
	
	// Replace phone numbers in the format NPA NXX XXXX
	// TODO: Add more robust telephone regex
	$commentdata['comment_content'] = preg_replace('/\d{3} \d{3} \d{4}/', '', $commentdata['comment_content']);
	
	// Replace email addresses
	$email_regexp = "[_A-Za-z0-9-]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,3})";
	$commentdata['comment_content'] = ereg_replace($email_regexp, '', $commentdata['comment_content']);
	
	// Replace website URLs
	$url_regexp = "(https?://)?(www\.)?([a-zA-z0-9\.])*[a-zA-Z0-9]*\.[a-z]{2,3}";
	$commentdata['comment_content'] = ereg_replace($url_regexp, '', $commentdata['comment_content']);
	
	return $commentdata['comment_content'];
}
add_filter('pre_comment_content', 'sanitize_contact_info');

?>