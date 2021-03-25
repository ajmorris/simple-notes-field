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
function CreateTextfield() {
  $screen = 'page';
  add_meta_box('my-meta-box-id','Text Editor','displayeditor',$screen,'normal','high');
}
add_action( 'add_meta_boxes', 'CreateTextfield' ) ;

/*Display PostMeta*/
function displayeditor($post) {
  global $wbdb;
  $metaeditor = 'metaeditor';
  $displayeditortext = get_post_meta( $post->ID,$metaeditor, true );
  ?>
    <h2>Secound Editor</h2>
    <label for="my_meta_box_text">Add Notes about the Page</label>
      <input type="text" name="my_meta_box_text" id="my_meta_box_text" value="<?php echo $displayeditortext;?>" />
 <?php
}

/*Save Post Meta*/
function saveshorttexteditor($post) {

  $editor = $_POST['my_meta_box_text'];
  update_post_meta(  $post, 'metaeditor', $editor);
}

add_action('save_post','saveshorttexteditor');
