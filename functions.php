<?php
  function amfp_add_admin_scripts() 
      {
       // wp_register_style('amfp_admin_css', plugin_dir_url(__FILE__ ).'assets/admin_css.css');
         wp_enqueue_style( 'amfp_admin_css', plugin_dir_url(__FILE__ ).'assets/css/admin_css.css');
      }
    
    function amfp_add_scripts() 
      {
        //wp_enqueue_scripts('amfp_js', plugin_dir_url(__FILE__ ).'assets/js/js.js');
         wp_enqueue_style( 'amfp_css', plugin_dir_url(__FILE__ ).'assets/css/css.css');
      }
        
      
 add_action('admin_enqueue_scripts', "amfp_add_admin_scripts");
 add_action( 'wp_enqueue_scripts', 'amfp_add_scripts' );

