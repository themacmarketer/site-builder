<?php
// builder.inc.php
// The site builder core, which does the work

function markdown_to_html ($markdown) {
  
  // initialize Parsedown
  $parsedown = new Parsedown();
  
  // generate & return HTML
  $html = $parsedown->text($markdown);
  return $html;
  
}

function insert_content_into_template ($template, $title, $description, $content) {
 
  // get current year (copyright note)
  $year = date('Y');
  
  // array of parameters
  $values = array( "title" => $title, "description" => $description, "year" => $year, "content" => $content );
  
  // loop through $values and generate html
  foreach ( $values as $key => $value ) {
   
    $name = "%".strtoupper($key);
    $template = str_replace( $name, $value, $template );
    
  }
  
  return $template;
  
}
