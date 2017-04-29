<?php
// compile.php
// This script builds the file and sends it to the user's browser.
include('config.inc.php');
include('parser.inc.php');
include('builder.inc.php');

$list = get_template_list();
