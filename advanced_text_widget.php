<?php

  // get the requested url
  $request_uri = $_SERVER["REQUEST_URI"];

  // place any text to be displayed irregardless of the
  // current category here
  // echo $request_uri;

  // parse out requested tag (if any)
  if (strpos($request_uri, '/tag/') !== false) {
    $after_tag = explode("/tag/", $request_uri)[1];
    $requested_tag = str_replace("/", "", $after_tag);
    $title = str_replace("-", " ", $requested_tag);
    $post = get_page_by_title($title, OBJECT, 'post');
    $post_id = $post->ID;
    
    // pluck out the network information from the post
    $network_visualization_image = get_field('network_visualization_image', $post_id, true);
    $network_visualization_text = get_field('network_visualization_text', $post_id, true);

    $network_visualization = "<div class='network-visualization-container'><div class='network-visualization-image'><img src='" . $network_visualization_image . "' /></div><div class='network-visualization-text'>" . $network_visualization_text . "</div></div>";

  echo $network_visualization;
  }

  // parse out requested category (if any)
  if (strpos($request_uri, '/category/') !== false) {
  
    // fetch all of the categories for the current group
    $categories = get_the_category();

    // create variables to store the current category
    $nav_categories = array(
      "Reading",
      "Annotating",
      "Remixing"
    ); 

    // store the category to display
    $category_to_display = "";

    // iterate over the categories assigned to
    // the page the user is viewing and determine
    // which (if any) of those categories
    // are present in the $nav_categories
    foreach ($categories as $value) {
      $category_name = $value->cat_name;

      // check if the current category name is in the
      // nav categories
      if (in_array($category_name, $nav_categories)) {
        // if the current category is a nav category,
        // store that fact so we know to present the
        // text associated with this category      
        $category_to_display = $category_name;
      }
    }

    // here is where we define the text/content to be 
    // displayed for the current category

    /***
    * READING CATEGORY TEXT
    ***/

    if($category_to_display == "Reading") {
      echo "Reading category text goes here";
    }

    /***
    * ANNOTATING CATEGORY TEXT
    ***/

    if($category_to_display == "Annotating") {
      echo "Annotating category text goes here";
    }

    /***
    * REMIXING CATEGORY TEXT
    ***/

    if($category_to_display == "Remixing") {
      echo "Remixing category text goes here";
    }
  }

?>
