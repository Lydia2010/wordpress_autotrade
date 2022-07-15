<?php

function load_stylesheets()
{	wp_register_style('stylesheet',get_template_directory_uri(). '/style.css', '', 1, 'all');
	wp_enqueue_style('stylesheet');

   wp_register_style('custome',get_template_directory_uri(). '/app.css', '', 1, 'all');
   wp_enqueue_style('custome');
}


add_action('wp_enqueue_scripts', 'load_stylesheets');

function load_javascript()
{
   wp_register_script('custom', get_template_directory_uri(). '/app.js', 'jquery', 1, true);
   wp_enqueue_script('custom');
}

 add_action('wp_enqueue_scripts', 'load_javascript');


 //Add menus
 add_theme_support('menus');

 //Register some menus
 register_nav_menus(
   array(
     'top-menu' => 'Top Menu',
   )
 );


 class wp_post_editor {

  public function __construct(){
    add_action('add_meta_boxes', [$this, 'create_meta_box']);
    add_action('save_post', [$this, 'save_developers']);
  }

  public function create_meta_box(){
    add_meta_box('wp_editor','Post Editor',[$this, 'meta_box_html'],['post']);
  }


  public function save_developers($post_id){

    
    if(isset($_POST['wp_post_editor']) && is_numeric($_POST['wp_post_editor'])){

      $editor_id = sanitize_text_field($_POST['wp_post_editor']);

      update_post_meta($post_id, 'wp_post_editor', $editor_id);

    };
   


  }

  public function meta_box_html(){

    $user_query = new WP_User_Query([
      
      'role' => 'editor',
      'number' => '-1',
      'fields' => [
        'display_name',
        'ID',
      ],
    ]);

    $editors =$user_query->get_results();

    if(! empty($editors)) {


    ?>

    <label for="post_editor">Developer:</label>
    <select name="wp_post_editor">
      <option>- Select one - </option> 
      <?php

         foreach ($editors as $editor) {
           echo'<option value="'.$editor->ID.'" '.selected(get_post_meta(get_the_ID(), 'wp_post_editor', true), $editor->ID, false).'>'.$editor->display_name.'</option>';
         }



      ?>     
    </select>

    <?php

  } else {
    echo '<p>No editors found. </p>';
  }
  }

 }

 new wp_post_editor();