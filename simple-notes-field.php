<?php

/*
Plugin Name: Simple Notes Field
Plugin URI: https://ajmorris.me
Description: A Simple plugin that adds a notes field to your pages.
Version: 0.0.1
Author: AJ Morris
Author URI: https://ajmorris.me/
*/



/*Create custom MetaBox*/
function aj_create_text_field() {
  $screen = 'page';
  add_meta_box('my-meta-box-id','Notes field','displayeditor',$screen,'normal','high');
}
add_action( 'add_meta_boxes', 'aj_create_text_field' ) ;

/*Display PostMeta*/
function aj_display_editor($post) {
  global $wbdb;
  $metaeditor = 'metaeditor';
  $displayeditortext = get_post_meta( $post->ID,$metaeditor, true );
  ?>
    <br/>
    <label for="my_meta_box_text">Add Notes about the Page</label>
    <input type="text" name="my_meta_box_text" id="my_meta_box_text" value="<?php echo $displayeditortext;?>" />
    <br/>
  <?php
}

/*Save Post Meta*/
function aj_save_short_text_editor($post) {

  $editor = $_POST['my_meta_box_text'];
  update_post_meta(  $post, 'metaeditor', $editor);
}

add_action('save_post','aj_save_short_text_editor');


function notes_filter_posts_columns( $columns ) {

  $n_columns = array();
  $before = 'author'; // move before this

  foreach($columns as $key => $value) {
    if ($key==$before){
      $n_columns['metaeditor'] = 'Notes';
    }
      $n_columns[$key] = $value;
  }
  return $n_columns;

}
add_filter( 'manage_page_posts_columns', 'notes_filter_posts_columns' );

function display_notes_column( $column, $post_id ) {

  if ( 'metaeditor' === $column ) {
    $area = get_post_meta( $post_id, 'metaeditor', true );

    if ( ! $area ) {
      echo '-';
    } else {
      echo $area;
    }
  }

}
add_action( 'manage_page_posts_custom_column', 'display_notes_column', 10, 2);
