<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/*
fix1653353895-cartao-cpt-inc.php
*/



add_action( 'init', 'fix1653353895' );
function fix1653353895() {

        $labels = array(
                "name" => "Cartão",
                "singular_name" => "Cartão",
        );

        $args = array(
                "label" => "Cartão",
                "labels" => $labels,
                "description" => "",
                "public" => true,
                "publicly_queryable" => true,
                "show_ui" => true,
                "delete_with_user" => false,
                "show_in_rest" => false,
                "rest_base" => "",
                "rest_controller_class" => "WP_REST_Posts_Controller",
                // "has_archive" => false,
                "has_archive" => true,
                // "show_in_menu" => false,
                "show_in_menu" => true,
                // "show_in_nav_menus" => false,
                "show_in_nav_menus" => true,
                // "exclude_from_search" => true,
                "exclude_from_search" => false,
                "capability_type" => "post",
                "map_meta_cap" => true,
                "hierarchical" => false,
                "rewrite" => array( "slug" => "cartao", "with_front" => true ),
                "query_var" => true,
                // "supports" => array( "title", "editor","thumbnail" ),
                // "supports" => array( "title", "editor" ),
                "supports" => array( "title" ),
        );
        register_post_type( "cartao", $args );
}
