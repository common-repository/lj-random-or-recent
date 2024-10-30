<?php
/*
Plugin Name: LJ Random Or Recent
Plugin URI: http://www.thelazysysadmin.net/software/wordpress-plugins/lj-random-or-recent/
Description: Displays Random or Recent Posts as a Widget depending on if you are viewing a single post or another page type
Author: Jon Smith
Version: 0.4
Author URI: http://www.thelazysysadmin.net/
*/

function LJRandomOrRecent_widget($args) {
  extract($args);
  
  $opt_titlerandom = get_option('widget-LJRandomOrRecent-titlerandom');
  $opt_titlerecent = get_option('widget-LJRandomOrRecent-titlerecent');
  
  $opt_post = get_option('widget-LJRandomOrRecent-post');
  $opt_page = get_option('widget-LJRandomOrRecent-page');
  $opt_category = get_option('widget-LJRandomOrRecent-category');
  $opt_tag = get_option('widget-LJRandomOrRecent-tag');
  $opt_default = get_option('widget-LJRandomOrRecent-default');

  $opt_numposts = get_option('widget-LJRandomOrRecent-numposts');

  if ($opt_titlerandom == "") {
    $opt_titlerandom = "Random Posts"; 
  }
  
  if ($opt_titlerecent == "") {
    $opt_titlerecent = "Recent Posts"; 
  }
  
  if ($opt_post == "") {
    $opt_post = "recent";
  }

  if ($opt_page == "") {
    $opt_page = "recent";
  }

  if ($opt_category == "") {
    $opt_category = "recent";
  }

  if ($opt_tag == "") {
    $opt_tag = "recent";
  }

  if ($opt_default == "") {
    $opt_default = "random";
  }

  if ($opt_numposts == "") {
    $opt_numposts = 5;
  }

  $b_post = is_single();
  $b_page = is_page();
  $b_category = is_category();
  $b_tag = is_tag();

  if ($b_post) {
    $mode = $opt_post;
  } else if ($b_page) {
    $mode = $opt_page;
  } else if ($b_category) {
    $mode = $opt_category;
  } else if ($b_tag) {
    $mode = $opt_tag;
  } else {
    $mode = $opt_default;
  }

  if ($mode == "random") {
    $title = $opt_titlerandom;
    $posts = get_posts('numberposts='.$opt_numposts.'&orderby=rand');
  } else {
    $title = $opt_titlerecent;
    $posts = get_posts('numberposts='.$opt_numposts.'&orderby=post_date');
  }

  echo $before_widget;
  echo $before_title.$title.$after_title;

  echo "<ul>";
  foreach ($posts as $post) {
    echo '<li><a href="'.get_permalink($post->ID).'">'.get_the_title($post->ID).'</a></li>';
  }

  echo "</ul>";
  echo $after_widget;
}

function LJRandomOrRecent_widget_control() {
  if ($_POST['widget-LJRandomOrRecent-submit']) {
    update_option('widget-LJRandomOrRecent-titlerandom', $_POST['widget-LJRandomOrRecent-titlerandom']);
    update_option('widget-LJRandomOrRecent-titlerecent', $_POST['widget-LJRandomOrRecent-titlerecent']);
    update_option('widget-LJRandomOrRecent-post', $_POST['widget-LJRandomOrRecent-post']);
    update_option('widget-LJRandomOrRecent-page', $_POST['widget-LJRandomOrRecent-page']);
    update_option('widget-LJRandomOrRecent-category', $_POST['widget-LJRandomOrRecent-category']);
    update_option('widget-LJRandomOrRecent-tag', $_POST['widget-LJRandomOrRecent-tag']);
    update_option('widget-LJRandomOrRecent-default', $_POST['widget-LJRandomOrRecent-default']);
    update_option('widget-LJRandomOrRecent-numposts', sprintf("%d", $_POST['widget-LJRandomOrRecent-numposts']));
  }

  $opt_titlerandom = get_option('widget-LJRandomOrRecent-titlerandom');
  $opt_titlerecent = get_option('widget-LJRandomOrRecent-titlerecent');
  
  $opt_post = get_option('widget-LJRandomOrRecent-post');
  $opt_page = get_option('widget-LJRandomOrRecent-page');
  $opt_category = get_option('widget-LJRandomOrRecent-category');
  $opt_tag = get_option('widget-LJRandomOrRecent-tag');
  $opt_default = get_option('widget-LJRandomOrRecent-default');
  $opt_numposts = get_option('widget-LJRandomOrRecent-numposts');

  if ($opt_titlerandom == "") {
    $opt_titlerandom = "Random Posts"; 
  }
  
  if ($opt_titlerecent == "") {
    $opt_titlerecent = "Recent Posts"; 
  }

  if ($opt_post == "") {
    $opt_post = "recent";
  }

  if ($opt_page == "") {
    $opt_page = "recent";
  }

  if ($opt_category == "") {
    $opt_category = "recent";
  }

  if ($opt_tag == "") {
    $opt_tag = "recent";
  }

  if ($opt_default == "") {
    $opt_default = "random";
  }

  if ($opt_numposts == "") {
    $opt_numposts = 5;
  }

  echo '<p><label for="widget-LJRandomOrRecent-titlerandom"><b>Random Title</b>: <br />';
  echo '<input type="text" class="widefat" id="widget-LJRandomOrRecent-titlerandom" name="widget-LJRandomOrRecent-titlerandom" value="'.$opt_titlerandom.'" /></label></p>';

  echo '<p><label for="widget-LJRandomOrRecent-titlerecent"><b>Recent Title</b>: <br />';
  echo '<input type="text" class="widefat" id="widget-LJRandomOrRecent-titlerecent" name="widget-LJRandomOrRecent-titlerecent" value="'.$opt_titlerecent.'" /></label></p>';
  
  echo '<p><label for="widget-LJRandomOrRecent-post"><b>Post</b>:</label><br/>';
  echo '<input type="radio" name="widget-LJRandomOrRecent-post" id="widget-LJRandomOrRecent-post" value="random"';
  if ($opt_post == "random") { echo 'checked="checked"'; }
  echo '>Random&nbsp;<input type="radio" name="widget-LJRandomOrRecent-post" id="widget-LJRandomOrRecent-post" value="recent"';
  if ($opt_post == "recent") { echo 'checked="checked"'; }
  echo '>Recent<br />';

  echo '<label for="widget-LJRandomOrRecent-page"><b>Page</b>:</label><br/>';
  echo '<input type="radio" name="widget-LJRandomOrRecent-page" id="widget-LJRandomOrRecent-page" value="random"';
  if ($opt_page == "random") { echo 'checked="checked"'; }
  echo '>Random&nbsp;<input type="radio" name="widget-LJRandomOrRecent-page" id="widget-LJRandomOrRecent-page" value="recent"';
  if ($opt_page == "recent") { echo 'checked="checked"'; }
  echo '>Recent<br />';

  echo '<label for="widget-LJRandomOrRecent-category"><b>Category</b>:</label><br/>';
  echo '<input type="radio" name="widget-LJRandomOrRecent-category" id="widget-LJRandomOrRecent-category" value="random"';
  if ($opt_category == "random") { echo 'checked="checked"'; }
  echo '>Random&nbsp;<input type="radio" name="widget-LJRandomOrRecent-category" id="widget-LJRandomOrRecent-category" value="recent"';
  if ($opt_category == "recent") { echo 'checked="checked"'; }
  echo '>Recent<br />';

  echo '<label for="widget-LJRandomOrRecent-tag"><b>Tag</b>:</label><br/>';
  echo '<input type="radio" name="widget-LJRandomOrRecent-tag" id="widget-LJRandomOrRecent-tag" value="random"';
  if ($opt_tag == "random") { echo 'checked="checked"'; }
  echo '>Random&nbsp;<input type="radio" name="widget-LJRandomOrRecent-tag" id="widget-LJRandomOrRecent-tag" value="recent"';
  if ($opt_tag == "recent") { echo 'checked="checked"'; }
  echo '>Recent<br />';

  echo '<label for="widget-LJRandomOrRecent-default"><b>Default</b>:</label><br/>';
  echo '<input type="radio" name="widget-LJRandomOrRecent-default" id="widget-LJRandomOrRecent-default" value="random"';
  if ($opt_default == "random") { echo 'checked="checked"'; }
  echo '>Random&nbsp;<input type="radio" name="widget-LJRandomOrRecent-default" id="widget-LJRandomOrRecent-default" value="recent"';
  if ($opt_default == "recent") { echo 'checked="checked"'; }
  echo '>Recent</p>';

  echo '<p><label for="widget-LJRandomOrRecent-numposts"><b>Num Posts</b>: <br />';
  echo '<input type="text" class="widefat" id="widget-LJRandomOrRecent-numposts" name="widget-LJRandomOrRecent-numposts" value="'.$opt_numposts.'" /></label></p>';

  echo '<input type="hidden" id="widget-LJRandomOrRecent-submit" name="widget-LJRandomOrRecent-submit" value="1" />';
}

function init_LJRandomOrRecent() {
  register_sidebar_widget("LJ Random or Recent", "LJRandomOrRecent_widget");

  register_widget_control("LJ Random or Recent", "LJRandomOrRecent_widget_control");
}

add_action("plugins_loaded", "init_LJRandomOrRecent");

?>