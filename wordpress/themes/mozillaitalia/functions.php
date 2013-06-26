<?php 

    add_action( 'init', 'register_my_menus' );

    function register_my_menus() {
    	register_nav_menus(
    		array(
    		'principale' => __( 'Menu di navigazione', '' )
    		)
    	);
    }

    function mi_add_dropdown_class($classes, $item) {
        global $wpdb;
        $has_children = $wpdb->get_var("
                SELECT COUNT(meta_id)
                FROM wp_postmeta
                WHERE meta_key='_menu_item_menu_item_parent'
                AND meta_value='".$item->ID."'
            ");
        // add the class dropdown to the current list
        if ($has_children > 0) array_push($classes,'dropdown');
        return $classes;
    }
     
    add_filter( 'nav_menu_css_class', 'mi_add_dropdown_class', 10, 2);

    add_theme_support( 'post-thumbnails' ); 

?>