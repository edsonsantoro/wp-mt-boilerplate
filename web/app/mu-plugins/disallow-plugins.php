<?php
/*
Plugin Name:  Disallow Plugins
Plugin URI:   https://santoro.studio
Description:  Remove access from sub-users to main menu items with the subpages /submenus. Also blocks their URLs
Version:      1.0.0
Author:       Santoro
Author URI:   https://santoro.studio
License:      MIT License
*/

// If not the base site, add action to remove admin menu items
if ( home_url() !== 'https://app.nojapao.net' || ! is_admin() ) {
    add_action( 'admin_menu', 'remove_admin_menu_items', 999 );
}

// Remove admin menu items
function remove_admin_menu_items() {
    remove_menu_page('plugins.php');
    remove_submenu_page('plugins.php','plugin-install.php' );
    remove_submenu_page('themes.php','theme-editor.php' );

}

// Redirect users that try to access certain pages by url
if ( home_url() !== 'https://app.nojapao.net' 
    && strpos($_SERVER['REQUEST_URI'], 'wp-admin/plugin') > 0
    || strpos($_SERVER['REQUEST_URI'], 'wp-admin/theme-editor.php') > 0
    ) {
    $home_url = home_url();
    header('Location: '.$home_url );
}
