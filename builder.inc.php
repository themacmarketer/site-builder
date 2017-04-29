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

function load_template_from_file ($template_id) {
    
  global $config;
  $template_list = json_decode(file_get_contents($config["templates"]["base_directory"]."/".$config["templates"]["list_file"]), true);
  $template = $config["templates"]["base_directory"].$template_list["templates"][$template_id][0];
  
  if(!file_exists($template)) return false;
  $template_content = file_get_contents($template);
  if($template_content === FALSE OR $template_content === "") return false;
  
  return $template_content;
  
}
