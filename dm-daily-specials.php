<?php
/*
Plugin Name: Daily Specials
Plugin URI: http://rattlesnakemarket.com/
Description: Check out these daily specials
Version: 0.1.0
Author: Bradford Knowlton
Author URI: http://bradknowlton.com
*/

add_action( 'init', 'register_cpt_special' );
function register_cpt_special() {
    $labels = array( 
        'name' => _x( 'Specials', 'special' ),
        'singular_name' => _x( 'Special', 'special' ),
        'add_new' => _x( 'Add New', 'special' ),
        'add_new_item' => _x( 'Add New Special', 'special' ),
        'edit_item' => _x( 'Edit Special', 'special' ),
        'new_item' => _x( 'New Special', 'special' ),
        'view_item' => _x( 'View Special', 'special' ),
        'search_items' => _x( 'Search Specials', 'special' ),
        'not_found' => _x( 'No specials found', 'special' ),
        'not_found_in_trash' => _x( 'No specials found in Trash', 'special' ),
        'parent_item_colon' => _x( 'Parent Special:', 'special' ),
        'menu_name' => _x( 'Specials', 'special' ),
    );
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title',), //  'editor', 'thumbnail'
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        
        'menu_icon' => 'dashicons-carrot',
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => false,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );
    register_post_type( 'specials', $args );
}

function daily_specials( $atts ){


$output .= '
<div class="wrap clearfix specials">';
                
$today = getdate();
$today_args = array(
    'year' => $today['year'],
    'monthnum' => $today['mon'],
    'day' => $today['mday'],
    'post_type' => 'specials' 
    // possibly further query arguments
);

$today_query = new WP_Query( $today_args );

if ( $today_query->have_posts() ) {

while ( $today_query->have_posts() ) :
    $today_query->the_post();
    // echo something
    
    $output .= ' 
    	<div class="wpb_column vc_column_container col-sm-4" style="min-height: 185px;">
        <div style="padding-left:0px !important;padding-right:0px !important;" class="vc_column-inner">
            <div style="position: relative;z-index: 1;" class="wpb_wrapper">

    <div class="md-text-container  md-align-center wpb_wrapper wpb_md_text_wrapper ui-md_text">
        <div class="md-text gizmo-container">
			<div class="md-text-title -title ">'.get_the_title().'</div>
                   <div class="md-text-content  "><p></p><p style="text-align: center; opacity: 0.7;">'.get_field( 'special_line_1' ).'</p><p style="text-align: center; opacity: 0.7;">'.get_field( 'special_line_2').'</p><p data-mce-placeholder="1" data-wp-more-text="" data-wp-more="more" title="Read more..." style="text-align: center;" class="wp-more-tag mce-wp-more"><span style="color: #c4b37c;"><strong>'.get_field( 'special_price').'</strong></span></p></div>
	    </div>
    </div>
    
     </div>
        </div>
    </div>
';
    
    
endwhile;

     
} else {
	// no posts found
	
$output .= ' 
    	<div class="wpb_column vc_column_container col-sm-12" style="min-height: 150px;">
        <div style="padding-left:0px !important;padding-right:0px !important;" class="vc_column-inner">
            <div style="position: relative;z-index: 1;" class="wpb_wrapper">

    <div class="md-text-container  md-align-center wpb_wrapper wpb_md_text_wrapper ui-md_text">
        <div class="md-text gizmo-container">
			<div class="md-text-title -title ">No Specials Posted Yet</div>
	    </div>
    </div>
    
     </div>
        </div>
    </div>
';
	
	
}       

wp_reset_postdata();
    
$output .= '
               
    
    

    </div>
    
     <style scoped="">

        /* Solid Style*/
                    .specials .md-text-title {
                color: rgb(255, 255, 255);
            }
        
    .specials{
        text-align:     center;

    }
    .specials .md-text-title{
            font-size:      20px;
            line-height:    20px;
            letter-spacing: 0px;
            margin-bottom: 12px;
            transition: all .3s cubic-bezier(0.215, 0.61, 0.355, 1) ;
                        font-family:    Playfair Display;
            font-style:     bold;
            font-weight:    700;
                    }
    .specials .md-text-title:not(.title-slider):hover{
        letter-spacing:  0px;
    }
    .specials .md-text-title-separator{
            margin-bottom:10px ;
            width: 110px;
            border-top: 5px solid rgb(0, 255, 153);
                    margin-left: auto;
            margin-right: auto;
                }

    .specials .md-text-content{
     margin-bottom: 24px;
    }

    .specials .md-text-content p{
            color:          rgb(255, 255, 255);
            font-size:      16px;
            line-height:    25px;
                    font-family:    Roboto;
            font-style:     regular;
            font-weight:    400;
            }

                .specials .md-text-content p{
            margin: 0  auto;
        }
        

    </style>
';

return $output;

}
add_shortcode( 'daily-specials', 'daily_specials' );
