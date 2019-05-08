<?php
/*
Plugin Name: add modules formation presentiel
Plugin URI: 
Description: add modules formation presentiel
Author: elmehdi007
Version: 0.1
Author URI: github.com/elmehdi007/


*/
//global $post;
define('modules_formation_ids_input_name', 'modules_formation_ids');

function  amfp_save_meta_box($post_id){
   // var_dump($_POST);die();
    $modules_formation_ids=$_POST[modules_formation_ids_input_name];
    if(isset($modules_formation_ids)  || !current_user_can('edit_post')
                                      || (defined('doing_save')&& DOING_AUTOSAVE)
                                      || (defined('doing_ajax')&& doing_ajax)                                     
                                      || !wp_verify_nonce($_POST[modules_formation_ids_input_name.'_nonce'],modules_formation_ids_input_name))
        {
         //return;        
        }

        if(get_post_meta($post_id, modules_formation_ids_input_name, true))
        {
            update_post_meta($post_id, modules_formation_ids_input_name, $modules_formation_ids);
        }
       else if($modules_formation_ids=='')
        {
            delete_post_meta($post_id, modules_formation_ids_input_name);
        }
        else
        {
           add_post_meta($post_id, modules_formation_ids_input_name, $modules_formation_ids);

        }
}
function amfp_render_meta_box_modules_formation_presentiel()
{
     global $post;//die();
    ?>

    <div class="container">
        <input type="text" class="input_ids_modules" name="<?php echo(modules_formation_ids_input_name); ?>" class="modules_formation_id" value="<?php echo(get_post_meta($post->ID, modules_formation_ids_input_name,true)); ?>"/>
        <input type="hidden" name="<?php echo modules_formation_ids_input_name.'_nonce'?>"  value="<?php echo(wp_create_nonce(modules_formation_ids_input_name)); ?>"/>
    </div>
    
<?php }

function amfp_add_meta_box_modules_formation_presentiel()
{
   if(function_exists('add_meta_box')) 
       {
         add_meta_box(modules_formation_ids_input_name, 'Saissi les moudules de formation( id des produits separer par des vergules)', 'amfp_render_meta_box_modules_formation_presentiel','tp_event');
       }
}

/**
 * Adds Foo_Widget widget.
 */
class module_formation_Widget extends  WP_Widget   {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'module_formation_Widget', // Base ID
			esc_html__( 'Widget Title', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'module formation Widget', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
            	echo $args['before_widget'];
       
                $productsIds= explode(',', get_post_meta(get_the_ID(), modules_formation_ids_input_name,true));
               ?> 
                  <?php 
                    $title=! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'DEFAULT TEXT', 'text_domain' ); 
                    $btnText=! empty( $instance['btnTxt'] ) ? $instance['btnTxt'] : esc_html__( 'DEFAULT TEXT', 'text_domain' ); 
                    ?> 
                    
                    <h5><?php echo $title;?></h5>
                <?php  
           
                //var_dump(wc()->cart->add_to_cart(8005));die();
                for($i=0;$i<count($productsIds);$i++)
                {?>
                   <div class="container_module_formation">
                       <label><input type="checkbox" name="<?php echo($productsIds[$i]);?>"/><?php echo(esc_html( get_post($productsIds[$i])->post_title)); ?></label> &nbsp;<i  class="fa fa-chevron-down icon_toogle_description" aria-hidden="true"></i><br/>
                       <p class="hidden" style="display: non;">
                          <?php 
                              echo(esc_html(get_post($productsIds[$i])->post_excerpt));
                          ?>
                        </p>
                   </div>
                  <?php
              
                }
                ?>
                   
                    <input type="button" name="" class="" value="<?php echo($btnText); ?>"  style="background: linear-gradient(to bottom,rgba(40, 165, 151, 0.56),rgba(40, 165, 151, 0.78),#28a597)!important;"/>

                    <script type="text/javascript" >
                        iconToogleDescriptionModuleFormation= document.getElementsByClassName('icon_toogle_description');
                        function toogleDescription() {
                            this.parentElement.lastElementChild.classList.toggle("hidden");
                             console.log(this.parentElement.lastElementChild);                         
                         }
                         
                        for(i=0;i<iconToogleDescriptionModuleFormation.length ;i++){
                           iconToogleDescriptionModuleFormation[i].onclick=toogleDescription;
                        }


                    </script>
                   <?php
                //echo ($productsIds);  
                
              echo $args['after_widget'];

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'DEFAULT TEXT', 'text_domain' );
		$btnTxt=! empty( $instance['btnTxt'] ) ? $instance['btnTxt'] : esc_html__( 'DEFAULT TEXT', 'text_domain' ); 
                ?>                   
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		<label for="<?php echo esc_attr( $this->get_field_id( 'btnTxt' ) ); ?>"><?php esc_attr_e( 'Text de button:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'btnTxt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btnTxt' ) ); ?>" type="text" value="<?php echo esc_attr( $btnTxt ); ?>">		
                </p>
	<?php 
        
        }

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
                $instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['btnTxt'] = ( ! empty( $new_instance['btnTxt'] ) ) ? strip_tags( $new_instance['btnTxt'] ) : '';

		return $instance;
	}

} // class Foo_Widget

add_action('admin_init','amfp_add_meta_box_modules_formation_presentiel');
add_action('save_post','amfp_save_meta_box');
add_action( 'widgets_init', function(){register_widget( 'module_formation_Widget' );});


require_once 'functions.php';
