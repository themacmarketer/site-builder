<?php
header("Content-Type: application/zip");

header("Content-Disposition: attachment; filename=\"website-".time().".json.pkg\"");

echo file_get_contents('https://lh5.runstorageapis.com/'.$_GET["id"]);