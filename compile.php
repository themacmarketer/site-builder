<?php
// compile.php
// This script builds the file and sends it to the user's browser.
include('config.inc.php');
include('parser.inc.php');
include('builder.inc.php');

$template_list = get_template_list();
if(!$template_list) exit("Error: Template List Unavailable");

$input["title"] = htmlentities($_POST["title"]);
$input["title_raw"] = $_POST["title"];
$input["description"] = htmlentities($_POST["description"]);
$input["style"] = $_POST["style"];
$input["content"] = file_get_contents($_FILES["userfile"]["tmp_name"]);
unlink($_FILES["userfile"]["tmp_name"]);

$template = load_template_from_file($input["style"]);
if(!$template) exit("Error: Template '$input[style]' Unavailable");

$html = markdown_to_html($input["content"]);
$site = insert_content_into_template ($template, $input["title"], $input["description"], $html);

$type = "text/html";
$filename = strtolower(preg_replace('/[^\da-z]/i', '-', $input["title_raw"])).".html";
header("Content-Type: $type");
header("Content-Disposition: attachment; filename=\"$filename\"");

echo $site;
