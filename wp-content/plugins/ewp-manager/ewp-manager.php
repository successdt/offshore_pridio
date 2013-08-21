<?php
/*
Plugin Name: EWP manager
Plugin URI: http://ecomwebpro.com
Description: Manage contact for wordpress
Version: 1.0.0
Author: EWP company
Author URI: http://ecomwebpro.com
License: GPL2
*/
global $ewp_db_version;
$ewp_db_version = '1.0.0';

function ewp_install() {
    global $wpdb;
    global $ewp_db_version;
    
    $table_name = $wpdb->prefix . "ewp_contact";
    
    $sql = "CREATE TABLE $table_name (
    	id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        	name VARCHAR(100),
        	email VARCHAR(100)
        );";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    
    add_option("ewp_db_version", $ewp_db_version);
}
register_activation_hook( __FILE__, 'ewp_install' );

function ewp_update_db_check() {
    global $ewp_db_version;
    if (get_site_option( 'ewp_db_version' ) != $ewp_db_version) {
        ewp_install();
    }
}

add_action( 'plugins_loaded', 'ewp_update_db_check' );


/**
 * listen for post form and save to DB
 * @author duythanhdao@live.com
 */
function saveContact(){
	global $wpdb;
    $table_name = $wpdb->prefix . "ewp_contact";
    if(isset($_POST['email']) && $_POST['email'] && isset($_POST['name']) && $_POST['name']){
        $email = $_POST['email'];
        $name = $_POST['name'];
        $query = "DELETE FROM $table_name WHERE email LIKE '" . $email . "'";
        $wpdb->query($query);

        $query = "INSERT INTO $table_name(name, email) VALUES('" . $name . "', '" . $email . "')";
    	$wpdb->query($query);
    }
}
add_action('init', 'saveContact');

/**
 * add to admin menu
 */
function ewp_manager_admin() {
    add_menu_page( 'Quản lý khách hàng', 'Khách hàng', 'manage_options', 'ewp-manager/contact-manager.php', '', plugins_url('ewp-manager/images/manager-icon.png' ), 6 );
}
add_action('admin_menu', 'ewp_manager_admin');
?>