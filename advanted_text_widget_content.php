<?php
  // place any text to be displayed irregardless of the
  // current category here
  echo "";
  
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

  // iterate over the categories and determine
  // which is currently presented
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
    echo "Ananotating category text goes here";
  }

  /***
  * REMIXING CATEGORY TEXT
  ***/
  if($category_to_display == "Remixing") {
    echo "Remixing category text goes here";
  }

?>